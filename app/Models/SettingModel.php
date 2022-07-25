<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'setting';
    protected $allowedFields = ['field', 'value'];
    protected $validationRules = [
        'field' => 'required',
    ];
    protected $validationMessages = [
        'field' => [
            'required' => 'Field wajib diisi.',
        ],
    ];

    public function getRecipients()
    {
        return $this->where('field', 'recipients')->get();
    }

    public function getSMTP()
    {
        return $this->where('field', 'smtp')->get();
    }

    public function getSpecificRecipient()
    {
        return $this->where('field', 'specific_recipients')->get();
    }
}