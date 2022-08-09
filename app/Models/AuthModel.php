<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = "auth";
    protected $primaryKey = "admin_id";
    protected $useTimestamps = true;
    protected $allowedFields = ['username', 'email', 'password', 'nik'];

    public function getAdmin($nik = false)
    {
        if ($nik == false) {
            return $this->findAll();
        }

        return $this->where(['nik' => $nik])->first();
    }

    public function getAdminByUsername($username = false)
    {
        if ($username == false) {
            return $this->findAll();
        }

        return $this->where(['username' => $username])->first();
    }
}