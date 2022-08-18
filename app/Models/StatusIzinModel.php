<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusIzinModel extends Model
{
    protected $table = "status_izin";
    protected $primaryKey = "status_izin_id";
    protected $allowedFields = [
        'status_izin_keterangan',
    ];
}