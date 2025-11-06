<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SanksiMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_murid' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_pelanggaran' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'nama_pelapor' => [
                'type'       => 'VARCHAR',
                'constraint' => 254,
                'null'       => false,
            ],
            'file_foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 254,
                'null'       => false,
            ],
            'catatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 254,
                'null'       => false,
            ],
            'active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        $this->forge->createTable('sanksi', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci',
        ]);
    }
    public function down()
    {
        $this->forge->dropTable('sanksi', true);
    }
}
