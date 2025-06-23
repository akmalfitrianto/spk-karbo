<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Pembobotan extends Seeder
{
    public function run()
    {
        $data = [
            ['id_kriteria' => 1, 'nilai_bobot' => 30], // Indeks Glikemik
            ['id_kriteria' => 2, 'nilai_bobot' => 25], // Serat
            ['id_kriteria' => 3, 'nilai_bobot' => 20], // Karbohidrat
            ['id_kriteria' => 4, 'nilai_bobot' => 15], // Harga
            ['id_kriteria' => 5, 'nilai_bobot' => 10], // Ketersediaan
        ];

        $this->db->table('pembobotan')->insertBatch($data);
    }
}
