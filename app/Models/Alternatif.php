<?php

namespace App\Models;

use CodeIgniter\Model;

class Alternatif extends Model
{
  protected $table          = 'alternatif';
  protected $primaryKey     = 'id_alternatif';
  protected $allowedFields  = ['kode', 'nama_karbohidrat', 'indeks_glikemik', 'serat', 'karbohidrat', 'harga', 'ketersediaan','id_user'];

  protected $validationRules = [
    'kode'             => 'required|is_unique[alternatif.kode, id_alternatif, {id_alternatif}]',
    'nama_karbohidrat' => 'required',
    'indeks_glikemik'  => 'required|numeric',
    'serat'            => 'required|numeric',
    'karbohidrat'      => 'required|numeric',
    'harga'            => 'required|numeric',
    'ketersediaan'     => 'required|in_list[1,2,3,4,5]',
  ];


  public function getAlternatifCriteria()
  {
    return $this->db->query("
        SELECT 
            id_alternatif, 
            kode,
            nama_karbohidrat,
            indeks_glikemik, 
            serat, 
            karbohidrat, 
            harga, 
            ketersediaan 
        FROM " . $this->table . "
        WHERE id_user = " . session('id_user') . "
    ")->getResultArray();
  }


  public function getKodeAlternatif()
  {
    return $this->db->query("
      SELECT id_alternatif, kode FROM " . $this->table . " WHERE id_user = " . session('id_user') . " ORDER BY id_alternatif
    ")->getResultArray();
  }

  public function countAlternatifByUser($id_user)
  {
    return $this->where('id_user', $id_user)->countAllResults();
  }
}
