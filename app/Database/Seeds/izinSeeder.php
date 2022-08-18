<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class izinSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'izin_nik' => '19990510123',
                'izin_date' => '2022-08-18',
                'izin_hari' => 1,
                'izin_status_id' => 3,
                'izin_syarat' => 'Potong Cuti'
            ],
            [
                'izin_nik' => '19990510123',
                'izin_date' => '2022-07-11',
                'izin_hari' => 1,
                'izin_status_id' => 2,
                'izin_syarat' => 'Potong Cuti'
            ],
            [
                'izin_nik' => '19990510123',
                'izin_date' => '2022-06-11',
                'izin_hari' => 2,
                'izin_status_id' => 3,
                'izin_syarat' => 'Potong Cuti'
            ],
            [
                'izin_nik' => '19990510123',
                'izin_date' => '2022-05-2',
                'izin_hari' => 1,
                'izin_status_id' => 4,
                'izin_syarat' => 'Bebas'
            ],
            [
                'izin_nik' => '19990510123',
                'izin_date' => '2022-04-11',
                'izin_hari' => 1,
                'izin_status_id' => 2,
                'izin_syarat' => 'Potong Cuti'
            ],
            [
                'izin_nik' => '19990510123',
                'izin_date' => '2022-03-12',
                'izin_hari' => 1,
                'izin_status_id' => 3,
                'izin_syarat' => 'Potong Cuti'
            ],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
        $this->db->table('izin')->insertBatch($data);
    }
}