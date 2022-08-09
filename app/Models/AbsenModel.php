<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenModel extends Model
{
    protected $table = "data_absen";
    protected $primaryKey = "absen_id";
    protected $allowedFields = ['nik', 'photo', 'latitude', 'longitude', 'tanggal'];
}