<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $userId = session()->get('id');
        $user = $userModel->find($userId);

        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];

        return view('profile/index', $data);
    }

    public function update()
    {
        $userModel = new UserModel();
        $userId = session()->get('id');
        
        $rules = [
            'name' => 'required|min_length[3]',
            'username' => "required|min_length[3]|is_unique[users.username,id,$userId]",
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $data);
        
        // Update session data if name changed
        session()->set('name', $data['name']);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
