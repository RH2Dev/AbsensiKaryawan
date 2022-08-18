<?php 

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\IzinModel;
use App\Models\StatusIzinModel;

class Izin extends BaseController
{
    protected $userModel;
    protected $izinModel;
    protected $statusIzinModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->izinModel = new IzinModel();
        $this->statusIzinModel = new StatusIzinModel();
    }

    public function index() 
    {
        $statusIzinBuilder = $this->statusIzinModel;
        $statusIzinBuilder->select('*');
        $statusIzin = $statusIzinBuilder->get();
        $statusIzin_arr = $statusIzin->getResultArray();

        $data = [
            'title' => 'Formulir Izin',
            'statusIzin' => $statusIzin_arr,
            'validation' => \Config\Services::validation()
        ];
        
        echo view('/formIzin', $data);
    }

    public function insert()
    {
        // Validation
        if(!$this->validate([
            'name' => [
                'rules' => 'required|is_not_unique[user.user_name]|alpha_space|max_length[50]',
                'errors' => [
                    'required' => 'Nama harus diisi gan',
                    'is_not_unique' => 'Nama Karyawan tidak terdaftar',
                    'alpha_space' => 'Nama tidak boleh menggunakan special character',
                    'max_length' => 'Ngapain punya nama panjang gan, maksimal 50 karakter'
                ]
            ],
            'nik' => [
                'rules' => 'required|is_not_unique[user.user_nik]|alpha_numeric|exact_length[11]',
                'errors' => [
                    'required' => 'NIK wajib disi gan',
                    'is_not_unique' => 'NIK Karyawan tidak terdaftar',
                    'alpha_numeric' => 'NIK hanya diperbolehkan menggunakan angka',
                    'exact_length' => 'NIK harus berisi 11 karakter, NO NEGO',
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih keterangan izin dulu gan'
                ]
            ],
            'syarat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih syarat izin dulu gan'
                ]
            ],
            'date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mau izin tanggal berapa gan'
                ]
            ],
            'hari' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Mau izin berapa hari gan'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $this->izinModel->save([
            'izin_nik' => $this->request->getVar('nik'),
            'izin_date' => $this->request->getVar('date'),
            'izin_status_id' => $this->request->getVar('status'),
            'izin_syarat' => $this->request->getVar('syarat'),
            'izin_hari' => $this->request->getVar('hari')
        ]);

        session()->setFlashdata('pesan', 'Data izin sudah berhasil ditambahkan');
        return redirect()->to('/Izin');
    }
}