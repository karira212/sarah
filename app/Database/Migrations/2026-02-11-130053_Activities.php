<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Activities extends Migration
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
            'student_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'shalat_subuh' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'shalat_dzuhur' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'shalat_ashar' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'shalat_maghrib' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'shalat_isya' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'tarawih' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'tarawih_photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'puasa' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'puasa_photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tadarus_surah' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'tadarus_ayat' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'kultum_type' => [
                'type'       => 'ENUM',
                'constraint' => ['online', 'offline'],
                'null'       => true,
            ],
            'kultum_penceramah' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'kultum_judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default'    => 'pending',
            ],
            'teacher_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'reviewed_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
        $this->forge->addForeignKey('student_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('activities');
    }

    public function down()
    {
        $this->forge->dropTable('activities');
    }
}
