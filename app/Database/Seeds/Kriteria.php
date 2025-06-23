<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kriteria extends Seeder
{
    /*
      cc = cost criteria
      bc = benefit criteria
    */
    public function run()
    {
        $data = [
            [
                'nama' => 'Indeks Glikemik (GI)',
                'jenis' => 'cc', // makin kecil GI makin baik
                'data_kuantitatif' => 1
            ],
            [
                'nama' => 'Serat (g)',
                'jenis' => 'bc', // makin tinggi makin bagus
                'data_kuantitatif' => 1
            ],
            [
                'nama' => 'Karbohidrat (g)',
                'jenis' => 'cc', // makin sedikit karbohidrat makin baik
                'data_kuantitatif' => 1
            ],
            [
                'nama' => 'Harga (Rp)',
                'jenis' => 'cc', // lebih murah lebih baik
                'data_kuantitatif' => 1
            ],
            [
                'nama' => 'Ketersediaan',
                'jenis' => 'bc', // makin tersedia makin bagus
                'data_kuantitatif' => 1
            ]
        ];

        $this->db->table('kriteria')->insertBatch($data);
    }
}
