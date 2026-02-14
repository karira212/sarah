<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InstitutionProfile extends Migration
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
            'school_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'school_address' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'headmaster_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'headmaster_nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('institution_profile');

        // Seed default data
        $data = [
            'school_name'     => 'SMA Negeri 1 Jakarta',
            'school_address'  => 'Jl. Budi Utomo No.7, Ps. Baru, Kecamatan Sawah Besar, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10710',
            'headmaster_name' => 'Nama Kepala Sekolah',
            'headmaster_nip'  => '19800101 200501 1 001',
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ];
        $this->db->table('institution_profile')->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('institution_profile');
    }
}
