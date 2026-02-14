<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name', 'username', 'password', 'role', 'class_id'];
    protected $useTimestamps = true;
}
