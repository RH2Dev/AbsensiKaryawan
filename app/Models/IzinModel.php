<?php

namespace App\Models;

use CodeIgniter\Model;

class IzinModel extends Model
{
    protected $table = "izin";
    protected $primaryKey = "izin_id";
    protected $allowedFields = [
        'izin_nik',
        'izin_date',
        'izin_hari',
        'izin_status_id',
        'izin_syarat'
    ];
}