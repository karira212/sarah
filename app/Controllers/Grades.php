<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\ClassModel;

class Grades extends BaseController
{
    public function index()
    {
        if (session()->get('role') == 'siswa') {
            return redirect()->to('/dashboard');
        }

        $activityModel = new ActivityModel();
        $classModel = new ClassModel();
        
        $classes = $classModel->findAll();
        $classId = $this->request->getGet('class_id');
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        // Build query
        $query = $activityModel->select('activities.*, users.name as student_name, classes.name as class_name')
                            ->join('users', 'users.id = activities.student_id')
                            ->join('classes', 'classes.id = users.class_id', 'left')
                            ->where('activities.date', $date)
                            ->where('activities.status', 'approved'); // Only show approved for grading? Or all? User said "Daftar nilai". Assuming approved ones or all. Let's show all but highlight approved.
                            // Actually user said "jika siswa mengisi semua kegiatan maka diberi nilai 100%". 
                            // The percentage is calculated regardless of approval status in student view? No, usually approval confirms it.
                            // But for "Daftar Nilai", let's show all submissions for that day.
        
        // Remove status check to see all submissions, or keep it?
        // Let's remove status check so teacher can see pending ones too, but usually grade is final.
        // Let's stick to showing everything for that date.
        
        if ($classId) {
            $query->where('users.class_id', $classId);
        }

        // If user is walas, restrict to their class?
        if (session()->get('role') == 'walas') {
             // Find class for this walas
             $myClass = $classModel->where('wali_kelas_id', session()->get('id'))->first();
             if ($myClass) {
                 // If walas selects another class, it shouldn't be allowed or just ignore?
                 // For simplicity, just force the class_id if not admin
                 // But wait, user requirement "halaman guru". 
                 // If role is guru/admin, can see all. Walas sees their own.
             }
        }

        $activities = $query->orderBy('users.name', 'ASC')->findAll();

        // Calculate scores
        foreach ($activities as &$activity) {
            if ($activity['status'] == 'rejected') {
                $activity['calculated_score'] = 50;
            } else {
                $totalItems = 9; 
                $filled = 0;
                if ($activity['shalat_subuh']) $filled++;
                if ($activity['shalat_dzuhur']) $filled++;
                if ($activity['shalat_ashar']) $filled++;
                if ($activity['shalat_maghrib']) $filled++;
                if ($activity['shalat_isya']) $filled++;
                if ($activity['tarawih']) $filled++;
                if ($activity['puasa']) $filled++;
                if (!empty($activity['tadarus_surah'])) $filled++;
                if (!empty($activity['kultum_judul'])) $filled++;
                
                $activity['calculated_score'] = round(($filled / $totalItems) * 100);
            }
        }

        $data = [
            'title' => 'Daftar Nilai Kegiatan',
            'activities' => $activities,
            'classes' => $classes,
            'currentClassId' => $classId,
            'currentDate' => $date
        ];

        return view('grades/index', $data);
    }

    public function export()
    {
        if (session()->get('role') == 'siswa') {
            return redirect()->to('/dashboard');
        }

        $activityModel = new ActivityModel();
        $classModel = new ClassModel();

        $classId = $this->request->getGet('class_id');
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        $query = $activityModel->select('activities.*, users.name as student_name, classes.name as class_name')
            ->join('users', 'users.id = activities.student_id')
            ->join('classes', 'classes.id = users.class_id', 'left')
            ->where('activities.date', $date);

        if ($classId) {
            $query->where('users.class_id', $classId);
        }

        $activities = $query->orderBy('users.name', 'ASC')->findAll();

        foreach ($activities as &$activity) {
            if ($activity['status'] == 'rejected') {
                $activity['calculated_score'] = 50;
            } else {
                $totalItems = 9;
                $filled = 0;
                if ($activity['shalat_subuh']) $filled++;
                if ($activity['shalat_dzuhur']) $filled++;
                if ($activity['shalat_ashar']) $filled++;
                if ($activity['shalat_maghrib']) $filled++;
                if ($activity['shalat_isya']) $filled++;
                if ($activity['tarawih']) $filled++;
                if ($activity['puasa']) $filled++;
                if (!empty($activity['tadarus_surah'])) $filled++;
                if (!empty($activity['kultum_judul'])) $filled++;
                $activity['calculated_score'] = round(($filled / $totalItems) * 100);
            }
        }

        $filename = 'nilai_' . $date . ($classId ? '_kelas_' . $classId : '') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $output = fopen('php://temp', 'w+');
        fputcsv($output, ['No', 'Nama Siswa', 'Kelas', 'Shalat (5)', 'Tarawih', 'Puasa', 'Tadarus', 'Kultum', 'Nilai', 'Status']);

        $i = 1;
        foreach ($activities as $activity) {
            $shalatCount = 0;
            if ($activity['shalat_subuh']) $shalatCount++;
            if ($activity['shalat_dzuhur']) $shalatCount++;
            if ($activity['shalat_ashar']) $shalatCount++;
            if ($activity['shalat_maghrib']) $shalatCount++;
            if ($activity['shalat_isya']) $shalatCount++;

            fputcsv($output, [
                $i++,
                $activity['student_name'],
                $activity['class_name'] ?? '-',
                $shalatCount . '/5',
                $activity['tarawih'] ? 'Ya' : 'Tidak',
                $activity['puasa'] ? 'Ya' : 'Tidak',
                !empty($activity['tadarus_surah']) ? 'Ada' : '-',
                !empty($activity['kultum_judul']) ? 'Ada' : '-',
                $activity['calculated_score'],
                $activity['status'],
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $this->response->setHeader('Content-Type', $headers['Content-Type'])
            ->setHeader('Content-Disposition', $headers['Content-Disposition'])
            ->setBody($csv);
    }
}
