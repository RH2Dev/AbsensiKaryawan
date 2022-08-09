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
   
        // NIK Validation
        $today = date('Y-m-d');  
        $db = \Config\Database::connect();
        $builder = $db->table('data_absen');
        $builder->like('tanggal', $today);
        $builder->where('nik', $this->request->getVar('nik'));
        $absen = $builder->get();
        $dataAbsen = $absen->getResultArray();
        $nik = $this->userModel->getUserByNIK($this->request->getVar('nik'));

        if (!empty($nik)) {
            // Convert raw image data to file
            if (!empty($dataAbsen)) {
                session()->setFlashdata('pesan', 'Anda Sudah Absen Hari ini');
                return redirect()->back();
            }

            $image = $this->request->getVar('photo');
            $imageData = str_replace('data:image/webp;base64,', '', $image);
            $file = base64_decode($imageData, true);
            $fileName = uniqid('', true).'-'.$this->request->getVar('nik').'.jpg';

            $data = [
                'nik' => $this->request->getVar('nik'),
                'photo' => $fileName,
                'latitude' => $this->request->getVar('latitude'),
                'longitude' => $this->request->getVar('longitude'),
                'tanggal' => date('Y-m-d H:i:s')
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
