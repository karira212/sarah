<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\UserModel;
use App\Models\ActivityModel;
use App\Models\InstitutionModel;

class Monitoring extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'walas' && session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $classModel = new ClassModel();
        $userModel = new UserModel();
        $activityModel = new ActivityModel();
        $institutionModel = new InstitutionModel();

        $institution = $institutionModel->first();
        if (!$institution) {
            $institution = [
                'school_name' => 'SARAH',
                'school_address' => 'Alamat Sekolah',
                'headmaster_name' => 'Kepala Sekolah',
                'headmaster_nip' => '-',
                'logo' => null
            ];
        }

        $userId = session()->get('id');
        $role = session()->get('role');

        $classId = null;
        $className = '';
        $allClasses = [];

        if ($role == 'admin') {
            $allClasses = $classModel->findAll();
            
            // Get class_id from request or default to first class
            $reqClassId = $this->request->getGet('class_id');
            
            if ($reqClassId) {
                $class = $classModel->find($reqClassId);
            } else {
                $class = $classModel->first();
            }

            if ($class) {
                $classId = $class['id'];
                $className = $class['name'];
            }
        } else {
            $class = $classModel->where('wali_kelas_id', $userId)->first();
            if ($class) {
                $classId = $class['id'];
                $className = $class['name'];
            }
        }

        if (!$classId) {
            return view('monitoring/index', [
                'title' => 'Monitoring Kelas',
                'students' => [],
                'className' => 'Tidak ada kelas assigned',
                'allClasses' => $allClasses,
                'currentClassId' => null,
                'institution' => $institution
            ]);
        }

        // Get Students
        $students = $userModel->where('class_id', $classId)->where('role', 'siswa')->findAll();

        // Attach stats
        foreach ($students as &$student) {
            $student['total_logs'] = $activityModel->where('student_id', $student['id'])->countAllResults();
            $student['approved_logs'] = $activityModel->where('student_id', $student['id'])->where('status', 'approved')->countAllResults();
            $student['rejected_logs'] = $activityModel->where('student_id', $student['id'])->where('status', 'rejected')->countAllResults();
            
            // Check recent activity (last 7 days)
            // $student['recent_logs'] = ... 
        }

        $data = [
            'title' => 'Monitoring Kelas',
            'students' => $students,
            'className' => $className,
            'institution' => $institution,
            'allClasses' => $allClasses ?? [],
            'currentClassId' => $classId
        ];

        return view('monitoring/index', $data);
    }
}
