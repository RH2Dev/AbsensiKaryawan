<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table = "jabatan";
    protected $primaryKey = "jabatan_id";
    protected $allowedFields = ['nama_jabatan'];
}