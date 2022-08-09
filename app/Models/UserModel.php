<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'slug', 'nik', 'jenis_kelamin', 'jabatan_id'];

    public function getUser($slug = false) 
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }

    public function getUserByNIK($nik = false)
    {
        if ($nik == false) {
            return $this->findAll();
        }

        return $this->where(['nik' => $nik])->first();
    }

    public function getUserAdmin($nik = false)
    {
        
        if ($nik == false) {
            $sql = 'SELECT * FROM user WHERE jabatan_id != ?';
            return $this->query($sql, [4])->getResultArray();
        }

        $sql = 'SELECT * FROM user WHERE jabatan_id != ? AND nik = ?';
        return $this->query($sql, [4, $nik])->getResultArray();
    }
}