<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityModel;

class Activity extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'siswa') {
            return redirect()->to('/dashboard');
        }

        $model = new ActivityModel();
        $activities = $model->where('student_id', session()->get('id'))->orderBy('date', 'DESC')->findAll();

        $data = [
            'title' => 'Riwayat Kegiatan',
            'activities' => $activities
        ];

        return view('activity/index', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'siswa') {
            return redirect()->to('/dashboard')->with('error', 'Hanya siswa yang dapat mengisi kegiatan.');
        }

        $data = [
            'title' => 'Input Kegiatan Ramadhan',
            'user' => session()->get()
        ];
        return view('activity/create', $data);
    }

    public function store()
    {
        if (session()->get('role') != 'siswa') {
            return redirect()->to('/dashboard');
        }

        $model = new ActivityModel();
        
        $rules = [
            'date' => 'required',
            'tarawih_photo' => [
                'rules' => 'max_size[tarawih_photo,2048]|is_image[tarawih_photo]|mime_in[tarawih_photo,image/jpg,image/jpeg,image/png]',
                'label' => 'Foto Tarawih'
            ],
            'puasa_photo' => [
                'rules' => 'max_size[puasa_photo,2048]|is_image[puasa_photo]|mime_in[puasa_photo,image/jpg,image/jpeg,image/png]',
                'label' => 'Foto Sahur/Buka'
            ]
        ];

        // Check for duplicate date
        $existingActivity = $model->where('student_id', session()->get('id'))
                                  ->where('date', $this->request->getPost('date'))
                                  ->first();
        if ($existingActivity) {
            return redirect()->back()->withInput()->with('error', 'Laporan untuk tanggal ini sudah ada. Anda tidak dapat mengisi laporan ganda untuk tanggal yang sama.');
        }

        // Validate date must be today
        if ($this->request->getPost('date') !== date('Y-m-d')) {
             return redirect()->back()->withInput()->with('error', 'Anda hanya dapat mengisi kegiatan untuk hari ini.');
        }

        // Conditional validation: if tarawih is checked, photo is required? 
        // User requirements say "Upload foto WAJIB" for Tarawih and Puasa.
        // But let's assume if they check "Ya", they must upload.
        
        if ($this->request->getPost('tarawih') == '1') {
             // We can check if file is uploaded
             $fileTarawih = $this->request->getFile('tarawih_photo');
             if (!$fileTarawih || !$fileTarawih->isValid()) {
                 return redirect()->back()->withInput()->with('error', 'Foto Tarawih Wajib Diupload jika Tarawih');
             }
        }

        if ($this->request->getPost('puasa') == '1') {
             $filePuasa = $this->request->getFile('puasa_photo');
             if (!$filePuasa || !$filePuasa->isValid()) {
                 return redirect()->back()->withInput()->with('error', 'Foto Puasa Wajib Diupload jika Puasa');
             }
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Handle File Uploads
        $tarawihPhotoName = null;
        $fileTarawih = $this->request->getFile('tarawih_photo');
        if ($fileTarawih && $fileTarawih->isValid() && !$fileTarawih->hasMoved()) {
            $tarawihPhotoName = $fileTarawih->getRandomName();
            $fileTarawih->move('uploads/activities', $tarawihPhotoName);
        }

        $puasaPhotoName = null;
        $filePuasa = $this->request->getFile('puasa_photo');
        if ($filePuasa && $filePuasa->isValid() && !$filePuasa->hasMoved()) {
            $puasaPhotoName = $filePuasa->getRandomName();
            $filePuasa->move('uploads/activities', $puasaPhotoName);
        }

        $data = [
            'student_id' => session()->get('id'),
            'date' => $this->request->getPost('date'),
            'shalat_subuh' => $this->request->getPost('shalat_subuh') ? 1 : 0,
            'shalat_dzuhur' => $this->request->getPost('shalat_dzuhur') ? 1 : 0,
            'shalat_ashar' => $this->request->getPost('shalat_ashar') ? 1 : 0,
            'shalat_maghrib' => $this->request->getPost('shalat_maghrib') ? 1 : 0,
            'shalat_isya' => $this->request->getPost('shalat_isya') ? 1 : 0,
            'tarawih' => $this->request->getPost('tarawih') ? 1 : 0,
            'tarawih_photo' => $tarawihPhotoName,
            'puasa' => $this->request->getPost('puasa') ? 1 : 0,
            'puasa_photo' => $puasaPhotoName,
            'tadarus_surah' => $this->request->getPost('tadarus_surah'),
            'tadarus_ayat' => $this->request->getPost('tadarus_ayat'),
            'kultum_type' => $this->request->getPost('kultum_type'),
            'kultum_penceramah' => $this->request->getPost('kultum_penceramah'),
            'kultum_judul' => $this->request->getPost('kultum_judul'),
            'status' => 'pending'
        ];

        $model->save($data);

        return redirect()->to('/activity')->with('success', 'Laporan kegiatan berhasil disimpan.');
    }

    public function edit($id)
    {
        if (session()->get('role') != 'siswa') {
            return redirect()->to('/dashboard');
        }

        $model = new ActivityModel();
        $activity = $model->find($id);

        if (!$activity) {
            return redirect()->to('/activity')->with('error', 'Data tidak ditemukan.');
        }

        // Check ownership
        if ($activity['student_id'] != session()->get('id')) {
            return redirect()->to('/activity')->with('error', 'Anda tidak memiliki akses.');
        }

        // Check if date is today and status is pending
        if ($activity['date'] !== date('Y-m-d') || $activity['status'] !== 'pending') {
            return redirect()->to('/activity')->with('error', 'Anda hanya dapat mengedit laporan hari ini yang belum diverifikasi.');
        }

        $data = [
            'title' => 'Edit Kegiatan Ramadhan',
            'activity' => $activity
        ];
        return view('activity/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') != 'siswa') {
            return redirect()->to('/dashboard');
        }

        $model = new ActivityModel();
        $activity = $model->find($id);

        if (!$activity) {
            return redirect()->to('/activity')->with('error', 'Data tidak ditemukan.');
        }

        if ($activity['student_id'] != session()->get('id')) {
            return redirect()->to('/activity')->with('error', 'Anda tidak memiliki akses.');
        }

        if ($activity['date'] !== date('Y-m-d') || $activity['status'] !== 'pending') {
            return redirect()->to('/activity')->with('error', 'Anda hanya dapat mengedit laporan hari ini yang belum diverifikasi.');
        }

        $rules = [
            'tarawih_photo' => [
                'rules' => 'max_size[tarawih_photo,2048]|is_image[tarawih_photo]|mime_in[tarawih_photo,image/jpg,image/jpeg,image/png]',
                'label' => 'Foto Tarawih'
            ],
            'puasa_photo' => [
                'rules' => 'max_size[puasa_photo,2048]|is_image[puasa_photo]|mime_in[puasa_photo,image/jpg,image/jpeg,image/png]',
                'label' => 'Foto Sahur/Buka'
            ]
        ];

        // Conditional validation: if tarawih is checked as "1" (Ya)
        // If they already have a photo, it's not required to upload again.
        // If they don't have a photo, it is required.
        
        if ($this->request->getPost('tarawih') == '1') {
             $fileTarawih = $this->request->getFile('tarawih_photo');
             // If no new file uploaded AND no existing photo, error
             if ((!$fileTarawih || !$fileTarawih->isValid()) && empty($activity['tarawih_photo'])) {
                 return redirect()->back()->withInput()->with('error', 'Foto Tarawih Wajib Diupload jika Tarawih');
             }
        }

        if ($this->request->getPost('puasa') == '1') {
             $filePuasa = $this->request->getFile('puasa_photo');
             // If no new file uploaded AND no existing photo, error
             if ((!$filePuasa || !$filePuasa->isValid()) && empty($activity['puasa_photo'])) {
                 return redirect()->back()->withInput()->with('error', 'Foto Puasa Wajib Diupload jika Puasa');
             }
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Handle File Uploads
        $tarawihPhotoName = $activity['tarawih_photo'];
        $fileTarawih = $this->request->getFile('tarawih_photo');
        if ($fileTarawih && $fileTarawih->isValid() && !$fileTarawih->hasMoved()) {
            $tarawihPhotoName = $fileTarawih->getRandomName();
            $fileTarawih->move('uploads/activities', $tarawihPhotoName);
        }

        $puasaPhotoName = $activity['puasa_photo'];
        $filePuasa = $this->request->getFile('puasa_photo');
        if ($filePuasa && $filePuasa->isValid() && !$filePuasa->hasMoved()) {
            $puasaPhotoName = $filePuasa->getRandomName();
            $filePuasa->move('uploads/activities', $puasaPhotoName);
        }

        $data = [
            'id' => $id,
            'shalat_subuh' => $this->request->getPost('shalat_subuh') ? 1 : 0,
            'shalat_dzuhur' => $this->request->getPost('shalat_dzuhur') ? 1 : 0,
            'shalat_ashar' => $this->request->getPost('shalat_ashar') ? 1 : 0,
            'shalat_maghrib' => $this->request->getPost('shalat_maghrib') ? 1 : 0,
            'shalat_isya' => $this->request->getPost('shalat_isya') ? 1 : 0,
            'tarawih' => $this->request->getPost('tarawih') ? 1 : 0,
            'tarawih_photo' => $tarawihPhotoName,
            'puasa' => $this->request->getPost('puasa') ? 1 : 0,
            'puasa_photo' => $puasaPhotoName,
            'tadarus_surah' => $this->request->getPost('tadarus_surah'),
            'tadarus_ayat' => $this->request->getPost('tadarus_ayat'),
            'kultum_type' => $this->request->getPost('kultum_type'),
            'kultum_penceramah' => $this->request->getPost('kultum_penceramah'),
            'kultum_judul' => $this->request->getPost('kultum_judul'),
            // Keep status pending if edited? Or reset to pending? Let's assume edit resets to pending/needs re-review if it was approved.
            // But usually edit implies "I made a mistake, let me fix it".
            // Let's not change status automatically unless requested, OR reset to pending if logic demands.
            // For now, let's keep status as is OR reset to pending if we want re-approval.
            // Safest: reset to pending.
            'status' => 'pending' 
        ];

        $model->save($data);

        return redirect()->to('/activity')->with('success', 'Laporan kegiatan berhasil diperbarui.');
    }
}
