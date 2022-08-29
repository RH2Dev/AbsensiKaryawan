<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $useTimestamps = true;
    protected $createdField  = 'user_created_datetime';
    protected $updatedField  = 'user_updated_datetime';
    protected $allowedFields = [
        'user_name',
        'user_slug',
        'user_nik',
        'user_jenis_kelamin',
        'user_jabatan_id',
        'user_kantor_id'
    ];

    public function getUserByNIK($nik = false)
    {
        if ($nik == false) {
            return $this->findAll();
        }

        return $this->where(['user_nik' => $nik])->first();
    }

    public function getUserAdmin($nik = false)
    {
        
        if ($nik == false) {
            $sql = 'SELECT * FROM user WHERE user_jabatan_id != ?';
            return $this->query($sql, [4])->getResultArray();
        }

        $sql = 'SELECT * FROM user WHERE user_jabatan_id != ? AND nik = ?';
        return $this->query($sql, [4, $nik])->getResultArray();
    }
}