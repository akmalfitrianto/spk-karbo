<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laporan PDF - Peringkat Alternatif</title>
  <style>
    table>tr>td {
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <h3 style="margin-bottom: 0;">Laporan Peringkat Alternatif</h3>
  <div style="margin-bottom: 20px;">dicetak pada tanggal: <?= date('d/M/Y'); ?></div>

  <table border="1" cellpadding="4" cellspacing="0">
    <thead>
      <tr>
        <th width="15px" align="center">No.</th>
        <th align="center">Detail Alternatif</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($query as $key => $row) : ?>
        <tr nobr="true">
          <td width="15px" align="center"><?= $key + 1; ?></td>
          <td>
            <table border="0">
              <tr>
                <td width="30%">Kode</td>
                <td>: <?= $row['kode']; ?></td>
              </tr>
              <tr>
                <td>Nama Karbohidrat</td>
                <td>: <?= $row['nama_karbohidrat']; ?></td>
              </tr>
              <tr>
                <td>Indeks Glikemik</td>
                <td>: <?= $row['indeks_glikemik']; ?></td>
              </tr>
              <tr>
                <td>Serat</td>
                <td>: <?= $row['serat']; ?> g</td>
              </tr>
              <tr>
                <td>Karbohidrat</td>
                <td>: <?= $row['karbohidrat']; ?> g</td>
              </tr>
              <tr>
                <td>Harga</td>
                <td>: Rp. <?= number_format($row['harga'], 0, ',', '.'); ?></td>
              </tr>
              <tr>
                <td>Ketersediaan</td>
                <td>: 
                  <?php 
                    $map = [1 => 'Sangat Sulit', 2 => 'Sulit', 3 => 'Cukup', 4 => 'Mudah', 5 => 'Sangat Mudah'];
                    echo $map[$row['ketersediaan']] ?? '-';
                  ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
