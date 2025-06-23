<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Alternatif extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode' => 'K1',
                'nama_karbohidrat' => 'Beras Merah',
                'indeks_glikemik' => 55,
                'serat' => 1.8,
                'karbohidrat' => 23,
                'harga' => 3500,
                'ketersediaan' => 4,
                'id_user' => 1
            ],
            [
                'kode' => 'K2',
                'nama_karbohidrat' => 'Kentang Rebus',
                'indeks_glikemik' => 65,
                'serat' => 2.2,
                'karbohidrat' => 20,
                'harga' => 2500,
                'ketersediaan' => 5,
                'id_user' => 1
            ]
        ];

        $this->db->table('alternatif')->insertBatch($data);
    }
}
