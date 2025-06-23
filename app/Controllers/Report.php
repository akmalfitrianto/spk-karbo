<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Dompdf\Dompdf;

class Report extends BaseController
{
  protected $db;

  public function __construct()
  {
    $this->db = \Config\Database::connect();
  }

  public function excelReporting()
  {
    if (!isset($_POST['excel'])) {
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
  }

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

  $styleArray = [
    'borders' => [
      'allBorders' => [
        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        'color' => ['hex' => '#000000'],
      ],
    ],
  ];

  $sheet->getStyle('A1:H1')->applyFromArray($styleArray);

  // Header
  $sheet->setCellValue('A1', 'No.');
  $sheet->setCellValue('B1', 'Kode');
  $sheet->setCellValue('C1', 'Nama Karbohidrat');
  $sheet->setCellValue('D1', 'Indeks Glikemik');
  $sheet->setCellValue('E1', 'Serat (g)');
  $sheet->setCellValue('F1', 'Karbohidrat (g)');
  $sheet->setCellValue('G1', 'Harga');
  $sheet->setCellValue('H1', 'Ketersediaan');

  $sheet->getStyle('A1:H1')->getFont()->setBold(true);

  $data = $this->db->query(
    "SELECT a.* FROM nilai_akhir na JOIN alternatif a ON na.id_alternatif = a.id_alternatif ORDER BY nilai_akhir DESC"
  )->getResultArray();

  $ketersediaanMap = [1 => 'Sangat Sulit', 2 => 'Sulit', 3 => 'Cukup', 4 => 'Mudah', 5 => 'Sangat Mudah'];

  foreach ($data as $key => $value) {
    $sheet->setCellValue('A' . ($key + 2), $key + 1);
    $sheet->setCellValue('B' . ($key + 2), $value['kode']);
    $sheet->setCellValue('C' . ($key + 2), $value['nama_karbohidrat']);
    $sheet->setCellValue('D' . ($key + 2), $value['indeks_glikemik']);
    $sheet->setCellValue('E' . ($key + 2), $value['serat']);
    $sheet->setCellValue('F' . ($key + 2), $value['karbohidrat']);
    $sheet->setCellValue('G' . ($key + 2), $value['harga']);
    $sheet->setCellValue('H' . ($key + 2), $ketersediaanMap[$value['ketersediaan']] ?? '-');
  }

  $filename = 'Laporan_Peringkat_Karbohidrat.xlsx';
  $writer = new Xlsx($spreadsheet);
  $writer->save($filename);

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="' . $filename . '"');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  header('Content-Length: ' . filesize($filename));

  flush();
  readfile($filename);
  unlink($filename);
  exit;
  }

  public function pdfReporting()
  {
    if (!isset($_POST['pdf'])) {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $data['query'] = $this->db->query(
      "SELECT a.* FROM nilai_akhir na JOIN alternatif a ON na.id_alternatif = a.id_alternatif ORDER BY nilai_akhir DESC"
    )->getResultArray();

    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->setDefaultFont('Courier');
    $dompdf->setOptions($options);

    $dompdf->loadHtml(view('perhitungan/pdf-reporting', $data));

    $dompdf->setPaper('A4', 'portrait');
    $dompdf->filename = "laporan peringkat alternatif.pdf";
    $dompdf->render();

    $dompdf->stream();
  }
}
