<?php

namespace App\Controllers;
use App\Models\UsersModel;

class Auth extends BaseController
{
	private $model;

	public function __construct()
	{
		$this->model = new UsersModel();
	}

    public function index()
    {
        return view('login');
    }

    public function verify() {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $auth = service('auth');

        if($auth->login($email, $password)) {
            return redirect()->to('/')
                        ->with('info', 'Login berhasil.');
        } else {
            return redirect()->back()
                        ->withInput()
                        ->with('error', 'Email atau password salah.');
        }
    }

    public function logout()
    {
        service('auth')->logout();

        return redirect()->to('login');
    }
}