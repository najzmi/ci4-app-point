<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            'first_name'    => 'Pudin',
            'last_name'     => 'Saepudin',
            'email'         => 'pudin@email.id',
            'password'      => password_hash('p4ssw0rd', PASSWORD_DEFAULT),
            'active'        => 1,
            'role'          => 'Admin',
            'token'         => bin2hex(random_bytes(16)),
            'phone'         => '085221389555',
            'avatar'        => 'pudin.jpg',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),

        ];
        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
