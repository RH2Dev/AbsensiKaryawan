<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\AbsenModel;
use App\Models\AuthModel;
use App\Models\KantorModel;
use App\Models\IzinModel;

class User extends BaseController
{
    protected $userModel;
    protected $jabatanModel;
    protected $absenModel;
    protected $adminModel;
    protected $kantorModel;
    protected $izinModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jabatanModel = new JabatanModel();
        $this->absenModel = new AbsenModel();
        $this->authModel = new AuthModel();
        $this->kantorModel = new KantorModel();
        $this->izinModel = new IzinModel();
    }

    // get all users
    public function index()
    {
        $session = session()->get();
        $search = $this->request->getVar('search');
        $kantor = $this->request->getVar('kantor');

        $userBuilder = $this->userModel;
        if ($session['adminStatus'] == 1) {
            if (!empty($kantor)) {
                $userBuilder->where('user_kantor_id', $kantor);
                $userBuilder->orWhere('user_jabatan_id',1);
            }
        } else {
            $userBuilder->where('user_kantor_id', $session['adminKantor']);
            $userBuilder->orWhere('user_jabatan_id',1);
        }
        if (!empty($search)) {
            $userBuilder->like('user_name', $search);
        }
        $userBuilder->join('kantor', 'kantor_id = user_kantor_id');
        $userBuilder->join('jabatan', 'jabatan_id = user_jabatan_id');
        $userBuilder->orderBy('jabatan_id', 'ASC');
        $user_arr = $userBuilder->paginate(10, 'user');

        $ceo_arr = $this->userModel->where('user_jabatan_id', 1)->get()->getResultArray();
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $kantor_arr = $this->kantorModel->findAll();
        $data = [
            'title' => 'Karyawan',
            'menu' => 'user',
            'search' => $search,
            'ceo_arr' => $ceo_arr,
            'user_arr' => $user_arr,
            'kantor_arr' => $kantor_arr,
            'kantorInput' => $kantor,
            'pager' => $this->userModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/User/user', $data);
    }

    public function detail($nik) 
    {
        $thisYear = date('Y');
        $year = $this->request->getVar('year');
        $month = $this->request->getVar('month');
        $yearIzin = $this->request->getVar('yearIzin');
        $monthIzin = $this->request->getVar('monthIzin');
        $dateIzin = ''.$yearIzin.'-'.$monthIzin.'';
        $date = ''.$year.'-'.$month.'';
        $absenYearBuilder = $this->absenModel;
        $absenYearBuilder->distinct();
        $absenYearBuilder->select('Year(absen_datetime)');
        $absenYearBuilder->where('absen_nik', $nik);
        $absenYear = $absenYearBuilder->get();
        $absenYear = $absenYear->getResultArray();

        
        $izinYearBuilder = $this->izinModel;
        $izinYearBuilder->distinct();
        $izinYearBuilder->select('Year(izin_date)');
        $izinYearBuilder->where('izin_nik', $nik);
        $izinYear = $izinYearBuilder->get();
        $izinYear = $izinYear->getResultArray();

        $izin_arr = $this->izinModel->where('izin_nik', $nik)->get()->getResultArray();
        $izin_cuti_arr = $this->izinModel->where('izin_nik', $nik)->where('izin_syarat', 'Potong Cuti')->get()->getResultArray();
        $izin_bebas_arr =  $this->izinModel->where('izin_nik', $nik)->where('izin_syarat', 'Bebas')->get()->getResultArray();
        $izin_tahun_arr = $this->izinModel->where('izin_nik', $nik)->like('izin_date', $thisYear)->get()->getResultArray();
        $izin_tahun_cuti_arr = $this->izinModel->where('izin_nik', $nik)->where('izin_syarat', 'Potong Cuti')->like('izin_date', $thisYear)->get()->getResultArray();
        $izin_tahun_bebas_arr = $this->izinModel->where('izin_nik', $nik)->where('izin_syarat', 'Bebas')->like('izin_date', $thisYear)->get()->getResultArray();

        $totalIzin = 0;
        foreach($izin_arr as $izin) {
            $totalIzin = $totalIzin + $izin['izin_hari'];
        }
        $totalCuti = 0;
        foreach($izin_cuti_arr as $cuti) {
            $totalCuti = $totalCuti + $cuti['izin_hari'];
        }
        $totalBebas = 0;
        foreach($izin_bebas_arr as $bebas) {
            $totalBebas = $totalBebas + $bebas['izin_hari'];
        }

        $totalIzinTahun = 0;
        foreach($izin_tahun_arr as $izin) {
            $totalIzinTahun = $totalIzinTahun + $izin['izin_hari'];
        }
        $totalCutiTahun = 0;
        foreach($izin_tahun_cuti_arr as $cuti) {
            $totalCutiTahun = $totalCutiTahun + $cuti['izin_hari'];
        }
        $totalBebasTahun = 0;
        foreach($izin_tahun_bebas_arr as $bebas) {
            $totalBebasTahun = $totalBebasTahun + $bebas['izin_hari'];
        }
        $sisaCuti = 12 - $totalCutiTahun;

        if (!empty($year)) {
            $absen_arr = $this->absenModel->like('absen_datetime', $date)->where('absen_nik', $nik)->orderBy('absen_datetime', 'DESC')->get()->getResultArray();
            $pager = '';
        } else {
            $absen_arr = $this->absenModel->where('absen_nik', $nik)->orderBy('absen_datetime', 'DESC')->paginate(10, 'absen');
            $pager = $this->absenModel->pager;
        }
        if (!empty($yearIzin)) {
            $izin_data_arr = $this->izinModel->like('izin_date', $dateIzin)->where('izin_nik', $nik)->join('status_izin', 'izin_status_id = status_izin_id')->orderBy('izin_date', 'DESC')->get()->getResultArray();
            $pagerIzin = '';
        } else {
            $izin_data_arr = $this->izinModel->where('izin_nik', $nik)->orderBy('izin_date', 'DESC')->join('status_izin', 'izin_status_id = status_izin_id')->paginate(10, 'izin');
            $pagerIzin = $this->izinModel->pager;
        }

        $userBuilder = $this->userModel;
        $userBuilder->select('user.*');
        $userBuilder->select('jabatan_nama');
        $userBuilder->select('kantor_name');
        $userBuilder->where('user_nik', $nik);
        $userBuilder->join('kantor', 'kantor_id = user_kantor_id');
        $userBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $user = $userBuilder->get();

        $currentPage = $this->request->getVar('page_absen') ? $this->request->getVar('page_absen') : 1;
        $currentPageIzin = $this->request->getVar('page_izin') ? $this->request->getVar('page_izin') : 1;
        $data = [
            'title' => 'Detail Karyawan',
            'menu' => 'user',
            'user_arr' => $user->getResultArray(),
            'absenYear' => $absenYear,
            'izinYear' => $izinYear,
            'absen_arr' => $absen_arr,
            'izin_data_arr' => $izin_data_arr,
            'totalIzin' => $totalIzin,
            'totalCuti' => $totalCuti,
            'totalBebas' => $totalBebas,
            'totalIzinTahun' => $totalIzinTahun,
            'totalCutiTahun' => $totalCutiTahun,
            'totalBebasTahun' => $totalBebasTahun,
            'sisaCuti' => $sisaCuti,
            'pager' => $pager,
            'pagerIzin' => $pagerIzin,
            'month' => $month,
            'monthIzin' => $monthIzin,
            'year' => $year,
            'yearIzin' => $yearIzin,
            'currentPage' => $currentPage,
            'currentPageIzin' => $currentPageIzin
        ];

        echo view('Admin/User/detailUser', $data);
    }

    public function formInsert()
    {
        $jabatan_arr = $this->jabatanModel->findAll();
        $kantor_arr = $this->kantorModel->findAll();
        $data = [
            'title' => 'Form Tambah Karyawan',
            'menu' => 'user',
            'jabatan_arr' => $jabatan_arr,
            'kantor_arr' => $kantor_arr,
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/User/formInsert', $data);
    }

    public function insert()
    {
        if(!$this->validate([
            'name' => [
                'rules' => 'required|alpha_space|max_length[50]',
                'errors' => [
                    'required' => 'Nama harus diisi gan',
                    'alpha_space' => 'Nama tidak boleh menggunakan special character',
                    'max_length' => 'Ngapain punya nama panjang gan, maksimal 50 karakter'
                ]
            ],
            'nik' => [
                'rules' => 'required|is_unique[user.user_nik]|alpha_numeric|exact_length[11]',
                'errors' => [
                    'required' => 'NIK wajib disi gan',
                    'is_unique' => 'NIK tidak boleh sama',
                    'alpha_numeric' => 'NIK hanya diperbolehkan menggunakan angka dan huruf',
                    'exact_length' => 'NIK harus berisi 11 karakter, NO NEGO',
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required|alpha',
                'errors' => [
                    'required' => 'Harus Pilih salah satu jenis kelamin',
                    'alpha' => 'Data yang dimasukkan tidak sesuai format'
                ]
            ],
            'jabatan_id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Harus Pilih salah satu jabatan',
                    'integer' => 'Data yang dimasukkan tidak sesuai format'
                ]
            ],
            'user_kantor_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus Pilih salah satu kantor',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->userModel->save([
            'user_name' => $this->request->getVar('name'),
            'user_slug' => $slug,
            'user_nik' => $this->request->getVar('nik'),
            'user_jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'user_jabatan_id' => $this->request->getVar('jabatan_id'),
            'user_kantor_id' => $this->request->getVar('user_kantor_id')
        ]);
        
        session()->setFlashdata('pesan', 'Data user sudah berhasil ditambahkan');
        return redirect()->to('/Admin/User');
    }

    public function delete($id)
    {
        $user = $this->userModel->where('user_id', $id)->first();
        $dataAbsen_arr = $this->absenModel->where('absen_nik', $user['user_nik'])->first();
        $absenBuilder = $this->absenModel;
        $absenBuilder->select('*');
        $absenBuilder->where('absen_nik', $user['user_nik']);
        $absen = $absenBuilder->get();
        $absen_arr = $absen->getResultArray();
        $admin_arr = $this->authModel->where('auth_nik', $user['user_nik'])->first();

        $izinBuilder = $this->izinModel;
        $izinBuilder->select('*');
        $izinBuilder->where('izin_nik', $user['user_nik']);
        $izinBuilder = $izinBuilder->get();
        $izin_arr = $izinBuilder->getResultArray();

        if (!empty($dataAbsen_arr)) {
            foreach ($absen_arr as $absen) {
                $this->absenModel->delete($absen['absen_nik']);
            }
            foreach ($absen_arr as $absen) {
                if(!empty($absen['absen_photo'])) {
                    unlink('img/' . $absen['absen_photo']);
                }
                if (!empty($absen['absen_photo_checkout'])) {
                    unlink('img/' . $absen['absen_photo_checkout']);
                }
            }
        }

        if (!empty($izin_arr)) {
            foreach ($izin_arr as $izin) {
            $this->izinModel->delete($izin['izin_nik']);
            }
        }

        if (!empty($admin_arr)) {
            $this->authModel->delete($admin_arr['auth_nik']);
        }
        
        $this->userModel->delete($id);
        session()->setFlashdata('pesan', 'Data user sudah terhapus');
        return redirect()->to('/Admin/User');
    }

    public function formEdit($nik)
    {
        $session = session()->get();

        $jabatan_arr = $this->jabatanModel->findAll();
        $kantor_arr = $this->kantorModel->findAll();
        $user_arr = $this->userModel->where('user_nik', $nik)->first();
        
        if ($session['adminStatus'] == 2) {
            return redirect()->to('/Admin');
        }

        if (($session['adminStatus'] == $user_arr['user_jabatan_id'] && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3) || $user_arr['user_jabatan_id'] == 4 && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3)) || $session['adminStatus'] == 1) {
            $data = [
                'title' => 'Form Edit Data Karyawan',
                'menu' => 'user',
                'kantor_arr' => $kantor_arr,
                'jabatan_arr' => $jabatan_arr,
                'validation' => \Config\Services::validation(),
                'user_arr' => $this->userModel->where('user_nik', $nik)->first()
            ];
    
            echo view('Admin/User/formEdit', $data);
        } else {
            return redirect()->to('/Admin');
        }


    }

    public function update() 
    {
        $id = $this->request->getVar('user_id');
        $oldUser = $this->userModel->where('user_id', $id)->first();
        if ($oldUser['user_nik'] == $this->request->getVar('nik')) {
            $rulesNIK = 'required|alpha_numeric|exact_length[11]';
        } else {
            $rulesNIK = 'required|is_unique[user.user_nik]|alpha_numeric|exact_length[11]';
        }

        $absenBuilder = $this->absenModel;
        $absenBuilder->select('*');
        $absenBuilder->where('absen_nik', $oldUser['user_nik']);
        $absen = $absenBuilder->get();
        $absen_arr = $absen->getResultArray();
        $admin_arr = $this->authModel->where('auth_nik', $oldUser['user_nik'])->first();
        
        if(!$this->validate([
            'name' => [
                'rules' => 'required|alpha_space|max_length[50]',
                'errors' => [
                    'required' => 'Nama harus diisi gan',
                    'alpha_space' => 'Nama tidak boleh menggunakan special character',
                    'max_length' => 'Ngapain punya nama panjang gan, maksimal 50 karakter'
                ]
            ],
            'nik' => [
                'rules' => $rulesNIK,
                'errors' => [
                    'required' => 'NIK wajib disi gan',
                    'is_unique' => 'NIK tidak boleh sama',
                    'alpha_numeric' => 'NIK hanya diperbolehkan menggunakan angka',
                    'exact_length' => 'NIK harus berisi 11 karakter, NO NEGO',
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'alpha',
                'errors' => [
                    'alpha' => 'Data yang dimasukkan tidak sesuai format'
                ]
            ],
            'jabatan_id' => [
                'rules' => 'integer',
                'errors' => [
                    'integer' => 'Data yang dimasukkan tidak sesuai format'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        if (!empty($absen_arr)) {
            foreach ($absen_arr as $absen) {
                $this->absenModel->save([
                    'absen_id' => $absen['absen_id'],
                    'absen_nik' => $this->request->getVar('nik')
                ]);
            }
        }        
        if (!empty($admin_arr)) {
            $this->authModel->save([
                'auth_id' => $admin_arr['auth_id'],
                'auth_nik' => $this->request->getVar('nik')
            ]);
        }

        $this->userModel->save([
            'user_id' => $id,
            'user_name' => $this->request->getVar('name'),
            'user_slug' => $oldUser['user_slug'],
            'user_nik' => $this->request->getVar('nik'),
            'user_jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'user_jabatan_id' => $this->request->getVar('jabatan_id'),
            'user_kantor_id' => $this->request->getVar('user_kantor_id')
        ]);

        session()->setFlashdata('pesan', 'Data user sudah berhasil diupdate');
        return redirect()->to('/Admin/User');
    }

    public function export()
    {
        $session = session()->get();
        $kantor = $this->request->getVar('kantor');
        $userBuilder = $this->userModel;
        $userBuilder->select('user.*');
        $userBuilder->select('jabatan_nama');
        $userBuilder->where('user_jabatan_id', 4);
        if ($session['adminStatus'] == 1) {
            if (!empty($kantor)) {
                $userBuilder->where('user_kantor_id', $kantor);
            }
        } else {
            $userBuilder->where('user_kantor_id', $session['adminKantor']);
        }
        $userBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $user = $userBuilder->get();

        $data = [
            'user_arr' => $user->getResultArray()
        ];

        echo view('Admin/User/export', $data);
    }

    public function exportDetail($nik)
    {
        $thisYear = date('Y');
        $absenYearBuilder = $this->absenModel;
        $absenYearBuilder->distinct();
        $absenYearBuilder->select('Year(absen_datetime)');
        $absenYearBuilder->where('absen_nik', $nik);
        $absenYear = $absenYearBuilder->get();
        $absenYear = $absenYear->getResultArray();

        
        $izinYearBuilder = $this->izinModel;
        $izinYearBuilder->distinct();
        $izinYearBuilder->select('Year(izin_date)');
        $izinYearBuilder->where('izin_nik', $nik);
        $izinYear = $izinYearBuilder->get();
        $izinYear = $izinYear->getResultArray();

        $izin_arr = $this->izinModel->where('izin_nik', $nik)->get()->getResultArray();
        $izin_cuti_arr = $this->izinModel->where('izin_nik', $nik)->where('izin_syarat', 'Potong Cuti')->get()->getResultArray();
        $izin_bebas_arr =  $this->izinModel->where('izin_nik', $nik)->where('izin_syarat', 'Bebas')->get()->getResultArray();
        $izin_tahun_arr = $this->izinModel->where('izin_nik', $nik)->like('izin_date', $thisYear)->get()->getResultArray();
        $izin_tahun_cuti_arr = $this->izinModel->where('izin_nik', $nik)->where('izin_syarat', 'Potong Cuti')->like('izin_date', $thisYear)->get()->getResultArray();
        $izin_tahun_bebas_arr = $this->izinModel->where('izin_nik', $nik)->where('izin_syarat', 'Bebas')->like('izin_date', $thisYear)->get()->getResultArray();

        $totalIzin = 0;
        foreach($izin_arr as $izin) {
            $totalIzin = $totalIzin + $izin['izin_hari'];
        }
        $totalCuti = 0;
        foreach($izin_cuti_arr as $cuti) {
            $totalCuti = $totalCuti + $cuti['izin_hari'];
        }
        $totalBebas = 0;
        foreach($izin_bebas_arr as $bebas) {
            $totalBebas = $totalBebas + $bebas['izin_hari'];
        }

        $totalIzinTahun = 0;
        foreach($izin_tahun_arr as $izin) {
            $totalIzinTahun = $totalIzinTahun + $izin['izin_hari'];
        }
        $totalCutiTahun = 0;
        foreach($izin_tahun_cuti_arr as $cuti) {
            $totalCutiTahun = $totalCutiTahun + $cuti['izin_hari'];
        }
        $totalBebasTahun = 0;
        foreach($izin_tahun_bebas_arr as $bebas) {
            $totalBebasTahun = $totalBebasTahun + $bebas['izin_hari'];
        }
        $sisaCuti = 12 - $totalCutiTahun;

        $absen_arr = $this->absenModel->where('absen_nik', $nik)->orderBy('absen_datetime', 'DESC')->get()->getResultArray();

        $izin_data_arr = $this->izinModel->where('izin_nik', $nik)->orderBy('izin_date', 'DESC')->join('status_izin', 'izin_status_id = status_izin_id')->get()->getResultArray();

        $userBuilder = $this->userModel;
        $userBuilder->select('user.*');
        $userBuilder->select('jabatan_nama');
        $userBuilder->select('kantor_name');
        $userBuilder->where('user_nik', $nik);
        $userBuilder->join('kantor', 'kantor_id = user_kantor_id');
        $userBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $user = $userBuilder->get();

        $data = [
            'user_arr' => $user->getResultArray(),
            'absen_arr' => $absen_arr,
            'izin_data_arr' => $izin_data_arr,
            'totalIzin' => $totalIzin,
            'totalCuti' => $totalCuti,
            'totalBebas' => $totalBebas,
            'totalIzinTahun' => $totalIzinTahun,
            'totalCutiTahun' => $totalCutiTahun,
            'totalBebasTahun' => $totalBebasTahun,
            'sisaCuti' => $sisaCuti,
        ];

        echo view('Admin/User/exportDetail', $data);

    }
}
?>