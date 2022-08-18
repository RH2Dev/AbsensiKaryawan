<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenModel extends Model
{
    protected $table = "absen";
    protected $primaryKey = "absen_id";
    protected $allowedFields = [
        'absen_nik',
        'absen_photo',
        'absen_photo_checkout',
        'absen_latitude',
        'absen_longitude',
        'absen_latitude_checkout',
        'absen_longitude_checkout',
        'absen_datetime',
        'absen_checkout_datetime'
    ];
}