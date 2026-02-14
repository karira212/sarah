<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $allowedFields = ['name', 'wali_kelas_id'];
    protected $useTimestamps = true;
}
