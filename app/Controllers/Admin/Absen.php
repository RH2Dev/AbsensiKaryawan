<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AbsenModel;

class Absen extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->absenModel = new AbsenModel();
    }

    public function absen()
    {
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Absensi',
            'absen' => $this->absenModel->join('user', 'user.nik = data_absen.nik')->orderBy('tanggal', 'DESC')->paginate(10, 'absen'),
            'pager' => $this->absenModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/Absen/absen', $data);
    }

    public function detail($id)
    {
        
        $db = \Config\Database::connect();
        $builder = $db->table('data_absen');
        $builder->join('user', 'user.nik = data_absen.nik');
        $builder->join('jabatan', 'user.jabatan_id = jabatan.uid');
        $builder->select('data_absen.*');
        $builder->select('user.*');
        $builder->select('jabatan.nama_jabatan');
        $builder->where('absen_id', $id);
        $absen = $builder->get();
        $data = [
            'title' => 'Absensi',
            'absen' => $absen->getResultArray()
        ];

        
        echo view('Admin/Absen/detailAbsen', $data);
    }

    public function formInsert()
    {
        
        $data = [
            'title' => 'Tambah Data Absen',
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/Absen/formInsert', $data);
    }

    public function insert()
    {

        // FORM Validation
        if(!$this->validate([
            'nik' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'NIK harus diisi gan',
                    'decimal' => 'NIK hanya angka gan'
                ]
            ],
            'photo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ambil photo dulu gan'
                ]
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ambil lokasi dulu gan'
                ]
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ambil lokasi dulu gan'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // NIK Validation
        $nik = $this->userModel->getUserByNIK($this->request->getVar('nik'));
        if (!empty($nik)) {
            // Convert raw image data to file
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
                return redirect()->to('/Admin/Absensi');
            };

            return redirect()->back()->withInput();

        } else {
            session()->setFlashdata('pesan', 'NIK tidak terdaftar');
            return redirect()->back()->withInput();
        }
    }
}