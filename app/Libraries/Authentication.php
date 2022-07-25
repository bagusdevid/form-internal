<?php

namespace App\Libraries;

class Authentication
{
    private $user;
    
    public function login($email, $password) {
        $model = new \App\Models\UsersModel;
        $user = $model->findByEmail($email);

        if($user === null) {
            return false;
        }

        if( ! password_verify($password, $user->password) ) {
            return false;
        }

        $session = session();
        $session->regenerate();
        $session->set('user_id', $user->id);
        $session->set('is_admin', $user->is_admin);

        return true;
    }

    public function logout() {
        session()->destroy();
    }

    public function isLoggedIn() {
        return session()->has('user_id');
    }

    public function getCurrentUser() {
        if(!$this->isLoggedIn()) {
            return null;
        }

        if($this->user === null) {
            $model = new \App\Models\UsersModel;

            $this->user = $model->asObject()->where('id', session()->get('user_id'))->first();
        }

        return $this->user;
    }
}