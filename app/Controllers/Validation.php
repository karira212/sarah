<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\ClassModel;

class Validation extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'guru' && session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $model = new ActivityModel();
        $classModel = new ClassModel();
        
        $classId = $this->request->getGet('class_id');
        if (session()->get('role') === 'guru') {
            $allowedClassId = session()->get('class_id');
            $classes = $allowedClassId ? $classModel->where('id', $allowedClassId)->findAll() : [];
            $classId = $allowedClassId; // force filter to teacher's class
        } else {
            $classes = $classModel->findAll();
        }

        // Join with users table to get student names and classes
        $query = $model->select('activities.*, users.name as student_name, classes.name as class_name')
                            ->join('users', 'users.id = activities.student_id')
                            ->join('classes', 'classes.id = users.class_id', 'left')
                            ->where('activities.status', 'pending');
        
        if ($classId) {
            $query->where('users.class_id', $classId);
        }

        $activities = $query->orderBy('activities.date', 'DESC')->findAll();

        $data = [
            'title' => 'Validasi Ibadah',
            'activities' => $activities,
            'classes' => $classes,
            'currentClassId' => $classId
        ];

        return view('validation/index', $data);
    }

    public function updateStatus()
    {
        if (session()->get('role') != 'guru' && session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $model = new ActivityModel();
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status'); // approved or rejected
        $note = $this->request->getPost('teacher_note');

        if (session()->get('role') === 'guru') {
            $allowedClassId = session()->get('class_id');
            $activity = $model->select('activities.*, users.class_id')
                              ->join('users', 'users.id = activities.student_id')
                              ->where('activities.id', $id)
                              ->first();
            if (!$activity || !$allowedClassId || $activity['class_id'] != $allowedClassId) {
                return redirect()->to('/validation')->with('success', 'Akses ditolak: Anda hanya boleh memvalidasi kelas yang diajar.');
            }
        }

        $data = [
            'id' => $id,
            'status' => $status,
            'teacher_note' => $note,
            'reviewed_by' => session()->get('id')
        ];

        $model->save($data);
        return redirect()->to('/validation')->with('success', 'Status kegiatan berhasil diperbarui.');
    }
}
