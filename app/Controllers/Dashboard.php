<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $role = $session->get('role');
        
        $data = [
            'title' => 'Dashboard',
            'user' => $session->get()
        ];

        return view('dashboard/index', $data);
    }
}
