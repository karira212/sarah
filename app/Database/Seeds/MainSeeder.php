<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        $this->db->table('users')->insert([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Create Guru Agama
        $this->db->table('users')->insert([
            'name' => 'Guru Agama',
            'username' => 'guru',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'guru',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Create Wali Kelas
        $this->db->table('users')->insert([
            'name' => 'Wali Kelas X-1',
            'username' => 'walas',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'walas',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $walasId = $this->db->insertID();

        // Create Class
        $this->db->table('classes')->insert([
            'name' => 'X-1',
            'wali_kelas_id' => $walasId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $classId = $this->db->insertID();

        // Update Walas class_id (optional, if walas needs to know their class directly in user table, but here it's in classes table)
        // Actually, the relationship is Class -> hasOne -> Walas.
        
        // Create Student
        $this->db->table('users')->insert([
            'name' => 'Siswa Teladan',
            'username' => 'siswa',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'siswa',
            'class_id' => $classId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
