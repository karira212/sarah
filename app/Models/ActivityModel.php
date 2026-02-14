<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table = 'activities';
    protected $allowedFields = [
        'student_id', 'date', 
        'shalat_subuh', 'shalat_dzuhur', 'shalat_ashar', 'shalat_maghrib', 'shalat_isya',
        'tarawih', 'tarawih_photo',
        'puasa', 'puasa_photo',
        'tadarus_surah', 'tadarus_ayat',
        'kultum_type', 'kultum_penceramah', 'kultum_judul',
        'status', 'teacher_note', 'reviewed_by'
    ];
    protected $useTimestamps = true;
}
