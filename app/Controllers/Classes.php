<?php

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Classes extends Controller
{
    protected $classModel;
    protected $userModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if ($perPage < 5) $perPage = 5;
        if ($perPage > 100) $perPage = 100;

        // Join with users table to get Wali Kelas name
        $query = $this->classModel->select('classes.*, users.name as walas_name')
            ->join('users', 'users.id = classes.wali_kelas_id', 'left');
        $classes = $query->paginate($perPage, 'classes');

        $data = [
            'classes' => $classes,
            'pager' => $query->pager,
            'perPage' => $perPage
        ];

        return view('classes/index', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        // Get users with role 'walas'
        $walas = $this->userModel->where('role', 'walas')->findAll();

        $data = [
            'walas' => $walas
        ];
        return view('classes/create', $data);
    }

    public function store()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $rules = [
            'name' => 'required|is_unique[classes.name]',
            'wali_kelas_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->classModel->save([
            'name' => $this->request->getPost('name'),
            'wali_kelas_id' => $this->request->getPost('wali_kelas_id')
        ]);

        return redirect()->to('/classes')->with('msg', 'Kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $class = $this->classModel->find($id);
        if (!$class) {
            return redirect()->to('/classes')->with('msg', 'Kelas tidak ditemukan.');
        }

        $data = [
            'class' => $class,
            'walas' => $this->userModel->where('role', 'walas')->findAll()
        ];
        return view('classes/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $class = $this->classModel->find($id);
        if (!$class) {
            return redirect()->to('/classes')->with('msg', 'Kelas tidak ditemukan.');
        }

        $rules = [
            'name' => "required|is_unique[classes.name,id,$id]",
            'wali_kelas_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->classModel->save([
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'wali_kelas_id' => $this->request->getPost('wali_kelas_id')
        ]);

        return redirect()->to('/classes')->with('msg', 'Kelas berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        if (!$this->classModel->find($id)) {
            return redirect()->to('/classes')->with('msg', 'Kelas tidak ditemukan.');
        }

        // Check if there are users in this class
        $userCount = $this->userModel->where('class_id', $id)->countAllResults();
        if ($userCount > 0) {
            return redirect()->to('/classes')->with('error', 'Gagal menghapus kelas. Masih ada ' . $userCount . ' siswa di kelas ini.');
        }

        $this->classModel->delete($id);
        return redirect()->to('/classes')->with('msg', 'Kelas berhasil dihapus.');
    }
}
