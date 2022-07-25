<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
	private $model;

	public function __construct() {
		$this->model = new UsersModel();
	}

    public function index()
    {
        return view('Users/main', [
            'page_title' => 'Users'
        ]);
    }

    public function create()
    {
    	return view('Users/create', [
    		'page_title' => 'Users'
    	]);
    }

    public function store()
    {
    	$post = $this->request->getPost();
    	unset($post['submit']);
        unset($post['id']);
        // return $this->response->setJSON($post);

    	if( $this->model->insert($post) ) {
            $msg = 'Data berhasil ditambahkan';
            session()->setFlashData('success', $msg);
            $response = [
                'success' => true,
                'msg' => $msg,
                'data' => [
                    'id' => $this->model->insertID(),
                ],
            ];
        } else {
            $response = [
                'success' => false,
                'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>',
                'data' => null,
            ];
        }

        return $this->response->setJSON($response);
    }

    public function apiGetAll()
    {
        $query = $this->model->asObject()->findAll();

        $data = [];
        foreach ($query as $key => $value) {
            if($value->id == session()->get('user_id')) {
                $passwd = '<a href="#" class="change-passwd" data-id="' . $value->id . '" title="Ubah password"><i class="fas fa-key"></i></a> ';
                $hapus = '';
            } else {
                $passwd = '<a href="' . site_url('users/reset_passwd/'.$value->id) . '" title="Reset password" onclick="return confirm(\'Apa Anda yakin mereset password user ini?\')"><i class="fas fa-sync"></i></a> ';
                $hapus = '<a href="' . site_url('users/delete/'.$value->id) . '" data-id="' . $value->id . '" onclick="return confirm(\'Apa Anda yakin menghapus user ini?\')" title="Hapus"><i class="fas fa-trash-alt"></i></a>';
            }

            $data[] = [
                $key + 1,
                $value->name,
                $value->email,
                $passwd . $hapus
            ];
        }

        return $this->response->setJSON($data);
    }

    public function getById($id)
    {
        $query = $this->model->asObject()->find($id);
        unset($query->password);

        if($query == null) {
            return $this->response->setJSON([
                'success' => false,
                'data' => null
            ]);
        }

        return $this->response->setJSON([
                'success' => true,
                'data' => $query
            ]);
    }

    public function apiChangePasswd()
    {
        $data = $this->request->getPost();
        // return $this->response->setJSON($data);

        if($this->model->save($data)) {
            $msg = 'Data berhasil diupdate';
            session()->setFlashData('success', $msg);
            return $this->response->setJSON([
                'success' => true,
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'msg' => '<p>' . implode('</p><p>', $this->model->errors()) . '</p>',
            ]);
        }
    }

    public function delete($id)
    {
        if($this->model->delete($id)) {
            return redirect()->back()
                            ->with('success', 'User berhasil dihapus');
        } else {
            return redirect()->back()
                            ->with('error', 'User gagal dihapus');
        }
    }

    public function resetPasswd($id)
    {
        $length = 8;
        $str = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),1,$length);

        $data = [
            'id' => $id,
            'password' => $str
        ];
        if($this->model->save($data)) {
            return redirect()->back()
                        ->with('success', 'Resetting password berhasil. Password baru adalah:<br /><strong>' . $str . '</strong>');
        } else {
            return redirect()->back()
                        ->with('error', 'Resetting password gagal.');
        }
    }

    public function changePasswd()
    {
        return view('Users/change_passwd', [
            'page_title' => 'Ubah password'
        ]);
    }

    public function changePasswdProcess()
    {
        $id = session()->get('user_id');

        $data = [
            'id' => $id,
            'password' => $this->request->getPost('password')
        ];
        if($this->model->save($data)) {
            return redirect()->back()
                        ->with('success', 'Ubah password berhasil');
        } else {
            return redirect()->back()
                        ->with('error', 'Ubah password gagal.');
        }
    }
}