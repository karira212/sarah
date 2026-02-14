<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InstitutionModel;

class InstitutionController extends BaseController
{
    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $model = new InstitutionModel();
        $profile = $model->first();

        if (!$profile) {
            // Should be seeded, but just in case
            $model->insert([
                'school_name' => 'Default School Name',
                'school_address' => 'Default Address',
                'headmaster_name' => 'Default Headmaster',
                'headmaster_nip' => '00000000'
            ]);
            $profile = $model->first();
        }

        $data = [
            'title' => 'Data Instansi',
            'profile' => $profile
        ];

        return view('institution/index', $data);
    }

    public function update()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $model = new InstitutionModel();
        $id = $this->request->getPost('id');

        $rules = [
            'school_name' => 'required',
            'school_address' => 'required',
            'headmaster_name' => 'required',
            'headmaster_nip' => 'required',
            'logo' => [
                'rules' => 'max_size[logo,2048]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
                'label' => 'Logo Sekolah'
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'school_name' => $this->request->getPost('school_name'),
            'school_address' => $this->request->getPost('school_address'),
            'headmaster_name' => $this->request->getPost('headmaster_name'),
            'headmaster_nip' => $this->request->getPost('headmaster_nip'),
        ];

        // Handle Logo Upload
        $fileLogo = $this->request->getFile('logo');
        if ($fileLogo && $fileLogo->isValid() && !$fileLogo->hasMoved()) {
            $logoName = $fileLogo->getRandomName();
            $fileLogo->move('uploads', $logoName);
            $data['logo'] = $logoName;
            
            // Delete old logo if exists (optional, maybe later)
        }

        $model->update($id, $data);

        return redirect()->to('/institution')->with('success', 'Data instansi berhasil diperbarui.');
    }
}
