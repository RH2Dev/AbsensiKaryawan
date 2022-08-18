<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
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
        
        $search = $this->request->getVar('search');

        if (!empty($search)) {
            $izin_arr = $this->izinModel->like('user_name', $search)->orWhere('izin_nik', $search)->select('izin.*')->select('status_izin_keterangan')->select('user_name')->join('status_izin', 'izin_status_id = status_izin_id')->join('user', 'user_nik = izin_nik')->paginate(10, 'izin');
        } else {
            $izin_arr = $this->izinModel->select('izin.*')->select('status_izin_keterangan')->select('user_name')->join('status_izin', 'izin_status_id = status_izin_id')->join('user', 'user_nik = izin_nik')->paginate(10, 'izin');
        }
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Izin',
            'menu' => 'izin',
            'izin_arr' => $izin_arr,
            'pager' => $this->izinModel->pager,
            'currentPage' => $currentPage
        ];
        
        echo view('Admin/Izin/izin', $data);
    }

    public function formIzin() 
    {
        $statusIzinBuilder = $this->statusIzinModel;
        $statusIzinBuilder->select('*');
        $statusIzin = $statusIzinBuilder->get();
        $statusIzin_arr = $statusIzin->getResultArray();

        $data = [
            'title' => 'Formulir Izin',
            'menu' => 'izin',
            'statusIzin' => $statusIzin_arr,
            'validation' => \Config\Services::validation()
        ];
        
        echo view('Admin/Izin/formInsert', $data);
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
        return redirect()->to('/Admin/Izin');
    }

    public function formEdit($id)
    {
        $izinBuilder = $this->izinModel;
        $izinBuilder->select('izin.*');
        $izinBuilder->select('user_name');
        $izinBuilder->where('izin_id', $id);
        $izinBuilder->join('user', 'user_nik = izin_nik');
        $izin = $izinBuilder->get();

        
        $statusIzinBuilder = $this->statusIzinModel;
        $statusIzinBuilder->select('*');
        $statusIzin = $statusIzinBuilder->get();

        $data = [
            'title' => 'Formulir Izin',
            'menu' => 'izin',
            'izin_arr' => $izin->getResultArray(),
            'statusIzin' => $statusIzin->getResultArray(),
            'validation' => \Config\Services::validation()
        ];
        
        echo view('Admin/Izin/formUpdate', $data);
    }

    public function update()
    {
        if(!$this->validate([
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
            'izin_id' => $this->request->getVar('id'),
            'izin_date' => $this->request->getVar('date'),
            'izin_status_id' => $this->request->getVar('status'),
            'izin_syarat' => $this->request->getVar('syarat'),
            'izin_hari' => $this->request->getVar('hari')
        ]);

        session()->setFlashdata('pesan', 'Data izin sudah berhasil diupdate');
        return redirect()->to('/Admin/Izin');
    }

    public function delete($id)
    {
        $this->izinModel->delete($id);
        session()->setFlashdata('pesan', 'Data izin sudah terhapus');
        return redirect()->to('/Admin/Izin');
    }

    public function export()
    {
        $izinBuilder = $this->izinModel;
        $izinBuilder->select('izin.*');
        $izinBuilder->select('jabatan_nama');
        $izinBuilder->select('user_name');
        $izinBuilder->select('status_izin_keterangan');
        $izinBuilder->join('user', 'user_nik = izin_nik');
        $izinBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $izinBuilder->join('status_izin', 'izin_status_id = status_izin_id');
        $izin = $izinBuilder->get();

        $data = [
            'izin_arr' => $izin->getResultArray()
        ];

        echo view('Admin/Izin/export', $data);
    }

    public function detail($id)
    {
        $izinBuilder = $this->izinModel;
        $izinBuilder->select('izin.*');
        $izinBuilder->select('user_name');
        $izinBuilder->where('izin_id', $id);
        $izinBuilder->join('user', 'user_nik = izin_nik');
        $izin = $izinBuilder->get();
        $izin_arr = $izin->getResultArray();

        $statusIzinBuilder = $this->statusIzinModel;
        $statusIzinBuilder->select('*');
        $statusIzin = $statusIzinBuilder->get();
        $statusIzin_arr = $statusIzin->getResultArray();
        $data = [
            'title' => 'Detail Izin',
            'menu' => 'izin',
            'statusIzin' => $statusIzin_arr,
            'izin' => $izin_arr
        ];
        
        echo view('Admin/Izin/detail', $data);
    }
}