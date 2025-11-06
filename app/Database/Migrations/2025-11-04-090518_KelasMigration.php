<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelasMigration extends Migration
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
            'kelas_nama' => [
                'type'       => 'ENUM',
                'constraint' => ['Kelas 7', 'Kelas 8','Kelas 9','Kelas 10','Kelas 11', 'Kelas 12'],
            ],
            'kelas_subnama' => [
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
        
        $this->forge->createTable('kelas', true, [
            'ENGINE' => 'InnoDB',
            'CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('kelas', true);
    }
}
