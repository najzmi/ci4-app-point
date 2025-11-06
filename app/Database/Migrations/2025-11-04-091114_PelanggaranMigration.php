<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PelanggaranMigration extends Migration
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
            'pelanggaran_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 254,
                'null'       => false,
            ],
            'pelanggaran_point' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
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
        
        $this->forge->createTable('pelanggaran', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci',
        ]);
    }
    public function down()
    {
        $this->forge->dropTable('pelanggaran', true);
    }
}
