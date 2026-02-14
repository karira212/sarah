<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ClassModel;
use CodeIgniter\Controller;

class Users extends Controller
{
    protected $userModel;
    protected $classModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->classModel = new ClassModel();
    }

    public function index()
    {
        // Role check: Only Admin
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard')->with('msg', 'Akses ditolak.');
        }

        $search = $this->request->getGet('search');
        $role = $this->request->getGet('role');
        $perPage = (int) ($this->request->getGet('perPage') ?? 10);
        if ($perPage < 5) $perPage = 5;
        if ($perPage > 100) $perPage = 100;

        $query = $this->userModel->select('users.*, classes.name as class_name')
            ->join('classes', 'classes.id = users.class_id', 'left');

        if ($search) {
            $query->groupStart()
                ->like('users.name', $search)
                ->orLike('users.username', $search)
                ->groupEnd();
        }

        if ($role) {
            $query->where('users.role', $role);
        }

        $data = [
            'users' => $query->paginate($perPage, 'users'),
            'pager' => $query->pager,
            'search' => $search,
            'role' => $role,
            'perPage' => $perPage
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $data = [
            'classes' => $this->classModel->findAll()
        ];
        return view('users/create', $data);
    }

    public function store()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $rules = [
            'name' => 'required',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'class_id' => $this->request->getPost('class_id') ?: null,
        ];

        $this->userModel->save($data);
        return redirect()->to('/users')->with('msg', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('msg', 'User tidak ditemukan.');
        }

        $data = [
            'user' => $user,
            'classes' => $this->classModel->findAll()
        ];
        return view('users/edit', $data);
    }

    public function update($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('msg', 'User tidak ditemukan.');
        }
        
        $rules = [
            'name' => 'required',
            'username' => "required|is_unique[users.username,id,$id]",
            'role' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role'),
            'class_id' => $this->request->getPost('class_id') ?: null,
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->save($data);
        return redirect()->to('/users')->with('msg', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');
        
        if (!$this->userModel->find($id)) {
            return redirect()->to('/users')->with('msg', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/users')->with('msg', 'User berhasil dihapus.');
    }

    public function resetPassword($id)
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        if (!$this->userModel->find($id)) {
            return redirect()->to('/users')->with('msg', 'User tidak ditemukan.');
        }

        // Reset to default: 123456
        $data = [
            'id' => $id,
            'password' => password_hash('123456', PASSWORD_DEFAULT)
        ];
        $this->userModel->save($data);
        return redirect()->to('/users')->with('msg', 'Password berhasil direset menjadi 123456.');
    }

    public function import()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');
        return view('users/import');
    }

    public function processImport()
    {
        if (session()->get('role') != 'admin') return redirect()->to('/dashboard');

        $file = $this->request->getFile('csv_file');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filepath = $file->getTempName();
            $fileHandle = fopen($filepath, "r");
            
            // Skip header row
            fgetcsv($fileHandle);
            
            $count = 0;
            while (($row = fgetcsv($fileHandle, 1000, ",")) !== FALSE) {
                // Format CSV: Name, Username, Password, Role, Class Name (Optional)
                // We will handle class lookup by name if possible, or just skip class for now simplicity
                // Let's assume CSV: name,username,password,role,class_id
                
                $name = $row[0] ?? '';
                $username = $row[1] ?? '';
                $password = $row[2] ?? '123456';
                $role = $row[3] ?? 'siswa';
                $class_id = $row[4] ?? null;

                if ($username && $role) {
                    // Check if exists
                    if ($this->userModel->where('username', $username)->countAllResults() == 0) {
                        $this->userModel->save([
                            'name' => $name,
                            'username' => $username,
                            'password' => password_hash($password, PASSWORD_DEFAULT),
                            'role' => $role,
                            'class_id' => $class_id
                        ]);
                        $count++;
                    }
                }
            }
            fclose($fileHandle);
            return redirect()->to('/users')->with('msg', "$count user berhasil diimport.");
        }
        
        return redirect()->back()->with('error', 'Gagal upload file.');
    }
}
