<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = "auth";
    protected $primaryKey = "auth_id";
    protected $useTimestamps = true;
    protected $createdField  = 'auth_created_datetime';
    protected $updatedField  = 'auth_updated_datetime';
    protected $allowedFields = [
        'auth_username',
        'auth_email',
        'auth_password',
        'auth_nik'
    ];

    public function getAdmin($nik = false)
    {
        if ($nik == false) {
            return $this->findAll();
        }

        return $this->where(['auth_nik' => $nik])->first();
    }
}