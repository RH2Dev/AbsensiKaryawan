<?php

namespace App\Models;

use CodeIgniter\Model;

class KantorModel extends Model
{
    protected $table = "kantor";
    protected $primaryKey = "kantor_id";
    protected $useTimestamps = true;
    protected $createdField  = 'kantor_created_datetime';
    protected $updatedField  = 'kantor_updated_datetime';
    protected $allowedFields = [
        'kantor_name',
        'kantor_alamat',
        'kantor_latitude',
        'kantor_longitude',
        'kantor_radius'
    ];

}