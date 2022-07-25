<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $allowedFields = ['status', 'tanggal', 'klasifikasi', 'client_status', 'client_name', 'unit', 'reference', 'social_media_order', 'social_media_account', 'postdate', 'post_qty', 'cost', 'other_brief'];
    protected $validationRules = [
        'status' => 'required',
        'tanggal' => 'required',
        'klasifikasi' => 'required',
    ];
    protected $validationMessages = [
        'status'        => [
            'required' => 'Field Status harus diisi.',
        ],
        'tanggal'        => [
            'required' => 'Field Tanggal harus diisi.',
        ],
        'klasifikasi'        => [
            'required' => 'Field Klasifikasi harus diisi.',
        ],
    ];

    public function getAll()
    {
        $query = $this->orderBy('id', 'desc')
                        ->get();

        if($query->getNumRows() > 0) {
            return $query->getResult();
        }

        return [];
    }

    public function getById($id)
    {
        $query = $this->find($id);

        return $query;
    }
}