<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alternatif extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alternatif'    => ['type' => 'INT','unsigned' => true ,'auto_increment' => true],
            'kode'             => ['type' => 'VARCHAR', 'constraint' => 10],
            'nama_karbohidrat' => ['type' => 'VARCHAR', 'constraint' => 100],
            'indeks_glikemik'  => ['type' => 'FLOAT'],
            'serat'            => ['type' => 'FLOAT'],
            'karbohidrat'      => ['type' => 'FLOAT'],
            'harga'            => ['type' => 'INT'],
            'ketersediaan'     => ['type' => 'INT'],
            'id_user'          => ['type' => 'INT'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_alternatif', true);
        $this->forge->createTable('alternatif');
    }

    public function down()
    {
        $this->forge->dropTable('alternatif');
    }
}
