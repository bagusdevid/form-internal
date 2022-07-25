<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['name', 'email', 'password', 'is_admin'];
    protected $validationRules = [
        'name' => 'required',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required',
        'password_confirmation' => 'required|matches[password]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Silahkan isikan form nama.',
        ],
        'email' => [
            'required' => 'Silahkan isikan form email.',
            'is_unique' => 'Alamat email sudah terdaftar.',
        ],
        'password' => [
            'required' => 'Silahkan isikan form password.',
        ],
        'password_confirmation' => [
            'required' => 'Silahkan isikan form password confirmation.',
            'matches' => 'Konfirmasi password tidak sama.'
        ],
    ];
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data) {
        if(isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            // unset($data['data']['password']);
        }

        return $data;
    }

    public function findByEmail($email) {
        return $this->asObject()->where('email', $email)->first();
    }

    public function getAll()
    {
        $query = $this->orderBy('id', 'desc')
                        ->get();

        if($query->getNumRows() > 0) {
            return $query->getResult();
        }

        return [];
    }
}