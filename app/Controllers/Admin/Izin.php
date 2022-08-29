<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\IzinModel;
use App\Models\StatusIzinModel;
use App\Models\KantorModel;

class Izin extends BaseController
{
    protected $userModel;
    protected $izinModel;
    protected $statusIzinModel;
    protected $kantorModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->izinModel = new IzinModel();
        $this->statusIzinModel = new StatusIzinModel();
        $this->kantorModel = new KantorModel();
    }

    public function index()
    {
        $session = session()->get();
        $search = $this->request->getVar('search');
        $kantor = $this->request->getVar('kantor');
        $year = $this->request->getVar('year');
        $month = $this->request->getVar('month');
        $date = ''.$year.'-'.$month.'';
        $izinYearBuilder = $this->izinModel;
        $izinYearBuilder->distinct();
        $izinYearBuilder->select('Year(izin_date)');
        $izinYear = $izinYearBuilder->get();
        $izinYear = $izinYear->getResultArray();

        $izinBuilder = $this->izinModel;
        $izinBuilder->select('izin.*');
        $izinBuilder->select('status_izin_keterangan');
        $izinBuilder->select('user_name');
        $izinBuilder->join('status_izin', 'izin_status_id = status_izin_id');
        $izinBuilder->join('user', 'user_nik = izin_nik');
        if ($session['adminStatus'] == 1) {
            if (!empty($kantor)) {
                $izinBuilder->where('user_kantor_id', $kantor);
            }
        } else {
            $izinBuilder->where('user_kantor_id', $session['adminKantor']);
        }
        if (!empty($search)) {
            $izinBuilder->like('user_name', $search);
        }
        if (!empty($year)) {
            $izinBuilder->like('izin_date', $date);
        }
        $izinBuilder->orderBy('izin_date', 'DESC');
        $izin_arr = $izinBuilder->paginate(10, 'izin');

        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $kantor_arr = $this->kantorModel->findAll();
        $data = [
            'title' => 'Izin',
            'menu' => 'izin',
            'izinYear' => $izinYear,
            'izin_arr' => $izin_arr,
            'kantor_arr' => $kantor_arr,
            'kantorInput' => $kantor,
            'searchInput' => $search,
            'yearInput' => $year,
            'monthInput' => $month,
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
        $session = session()->get();
        $year = $this->request->getVar('year');
        $month = $this->request->getVar('month');
        $kantor = $this->request->getVar('kantor');
        $date = ''.$year.'-'.$month.'';
        $izinBuilder = $this->izinModel;
        $izinBuilder->select('izin.*');
        $izinBuilder->select('jabatan_nama');
        $izinBuilder->select('user_name');
        $izinBuilder->select('kantor_name');
        $izinBuilder->like('izin_date', $date);
        if ($session['adminStatus'] == 1) {
            if (!empty($kantor)) {
                $izinBuilder->where('user_kantor_id', $kantor);
            }
        } else {
            $izinBuilder->where('user_kantor_id', $session['adminKantor']);
        }
        $izinBuilder->select('status_izin_keterangan');
        $izinBuilder->join('user', 'user_nik = izin_nik');
        $izinBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $izinBuilder->join('status_izin', 'izin_status_id = status_izin_id');
        $izinBuilder->join('kantor', 'kantor_id = user_kantor_id');
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