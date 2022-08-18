<?php

namespace App\Controllers;

use App\Models\AbsenModel;
use App\Models\UserModel;

class Home extends BaseController
{
    protected $absenModel;
    protected $userModel;
    public function __construct()
    {
        $this->absenModel = new AbsenModel();
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('index', $data);
    }

    public function insert()
    {
   
        $todayDate = date('Y-m-d');
        // NIK Validation
        $nik = $this->userModel->getUserByNIK($this->request->getVar('nik'));
        // Ambil data absen user hari ini
        $absenBuilder = $this->absenModel;
        $absenBuilder->like('absen_datetime', $todayDate);
        $absenBuilder->where('absen_nik', $this->request->getVar('nik'));
        $absen = $absenBuilder->get();
        $absen_arr = $absen->getResultArray();

        if ($nik['user_jabatan_id'] !== 4) {
            session()->setFlashdata('pesan', 'Hanya karyawan yang perlu absen');
            return redirect()->back();
        }

        // cek apakah NIK Tersedia
        if (!empty($nik)) {
            // Cek apakah user sudah absen & checkout
            if (!empty($absen_arr[0]['absen_datetime']) && !empty($absen_arr[0]['absen_checkout_datetime'])) {
                session()->setFlashdata('pesan', 'Anda Sudah Absen Hari ini');
                return redirect()->back();
            }

            // Convert raw image data to file
            $image = $this->request->getVar('photo');
            $imageData = str_replace('data:image/webp;base64,', '', $image);
            $file = base64_decode($imageData, true);
            $fileName = uniqid('', true).'-'.$this->request->getVar('nik').'.jpg';

            // Jika user sudah absen, maka absensi dianggap checkout
            if (!empty($absen_arr)) {

                $this->absenModel->save([
                    'absen_id' => $absen_arr[0]['absen_id'],
                    'absen_photo_checkout' => $fileName,
                    'absen_latitude_checkout' => $this->request->getVar('latitude'),
                    'absen_longitude_checkout' => $this->request->getVar('longitude'),
                    'absen_checkout_datetime' => date('Y-m-d H:i:s')
                ]);

                file_put_contents(FCPATH . 'img/' .$fileName, $file);
    
                session()->setFlashdata('pesan', 'Berhasil Checkout');
                return redirect()->to('/');
            }

            $data = [
                'absen_nik' => $this->request->getVar('nik'),
                'absen_photo' => $fileName,
                'absen_latitude' => $this->request->getVar('latitude'),
                'absen_longitude' => $this->request->getVar('longitude'),
                'absen_datetime' => date('Y-m-d H:i:s')
            ];

            // insert input to database
            if($this->absenModel->save($data) === true) {
            // insert file to img folder
                file_put_contents(FCPATH . 'img/' .$fileName, $file);

                session()->setFlashdata('pesan', 'Berhasil absen');
                return redirect()->to('/');
            };

            return redirect()->back()->withInput();

        } else {
            session()->setFlashdata('pesan', 'NIK tidak terdaftar');
            return redirect()->back()->withInput();
        }
    }
}
