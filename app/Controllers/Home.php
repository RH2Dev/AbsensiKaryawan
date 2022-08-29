<?php

namespace App\Controllers;

use App\Models\AbsenModel;
use App\Models\UserModel;
use App\Models\KantorModel;

class Home extends BaseController
{
    protected $absenModel;
    protected $userModel;
    protected $kantorModel;
    
    public function __construct()
    {
        $this->absenModel = new AbsenModel();
        $this->userModel = new UserModel();
        $this->kantorModel = new KantorModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Karyawan',
            'validation' => \Config\Services::validation()
        ];
        return view('index', $data);
    }

    public function insert()
    {
        $todayDate = date('Y-m-d');
        // NIK Validation
        $nik = $this->userModel->getUserByNIK($this->request->getVar('nik'));
        $kantor_arr = $this->kantorModel->where('kantor_id', $nik['user_kantor_id'])->first();

        // Calculate Radius
        $latKantor = $kantor_arr['kantor_latitude'] ; 
        $longKantor = $kantor_arr['kantor_longitude']; 
        $latUser = $this->request->getVar('latitude'); 
        $longUser = $this->request->getVar('longitude');  
        
        //Converting to radians
        $longi1 = deg2rad($longKantor); 
        $longi2 = deg2rad($longUser); 
        $lati1 = deg2rad($latKantor); 
        $lati2 = deg2rad($latUser); 
                
        //Haversine Formula 
        $difflong = $longi2 - $longi1; 
        $difflat = $lati2 - $lati1; 
                
        $val = pow(sin($difflat/2),2)+cos($lati1)*cos($lati2)*pow(sin($difflong/2),2); 
                
        $radius = 6378.8 * (2 * asin(sqrt($val))) * 1000; //for meters
        $max = $kantor_arr['kantor_radius'];

        if ($radius >= $max) {
            session()->setFlashdata('pesan', 'Anda Tidak Dalam Radius Absen '.$kantor_arr['kantor_name'].'');
            return redirect()->back();
        }

        // Ambil data absen user hari ini
        $absenBuilder = $this->absenModel;
        $absenBuilder->like('absen_datetime', $todayDate);
        $absenBuilder->where('absen_nik', $this->request->getVar('nik'));
        $absen = $absenBuilder->get();
        $absen_arr = $absen->getResultArray();

        if ($nik['user_jabatan_id'] != 4) {
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
