<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (session()->get('isLoggedIn')) {
            $db = \Config\Database::connect();
            $db->table('users')
               ->where('id', session()->get('id'))
               ->update(['updated_at' => date('Y-m-d H:i:s')]);
        }
    }
}
