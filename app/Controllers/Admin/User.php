<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\AbsenModel;
use App\Models\AuthModel;

class User extends BaseController
{
    protected $userModel;
    protected $jabatanModel;
    protected $absenModel;
    protected $adminModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jabatanModel = new JabatanModel();
        $this->absenModel = new AbsenModel();
        $this->authModel = new AuthModel();
    }

    // get all users
    public function index()
    {
        $search = $this->request->getVar('search');
        if (!empty($search)) {
            $user_arr = $this->userModel->like('user_name', $search)->orWhere('user_nik', $search)->join('jabatan', 'jabatan_id = user_jabatan_id')->orderBy('jabatan_id', 'ASC')->paginate(10, 'user');
        } else {
            $user_arr = $this->userModel->join('jabatan', 'jabatan_id = user_jabatan_id')->orderBy('jabatan_id', 'ASC')->paginate(10, 'user');
        }
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Karyawan',
            'menu' => 'user',
            'user_arr' => $user_arr,
            'pager' => $this->userModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/User/user', $data);
    }

    public function detail($nik) 
    {
        $userBuilder = $this->userModel;
        $userBuilder->select('user.*');
        $userBuilder->select('jabatan_nama');
        $userBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $userBuilder->where('user_nik', $nik);
        $user = $userBuilder->get();
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Detail Karyawan',
            'menu' => 'user',
            'user_arr' => $user->getResultArray(),
            'absen_arr' => $this->absenModel->where('absen_nik', $nik)->orderBy('absen_datetime', 'DESC')->paginate(10, 'absen'),
            'pager' => $this->absenModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/User/detailUser', $data);
    }

    // echo form insert user view
    public function formInsert()
    {
        $data = [
            'title' => 'Form Tambah Karyawan',
            'menu' => 'user',
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/User/formInsert', $data);
    }

    // insert data
    public function insert()
    {
        // Validation
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
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        // insert input to database
        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->userModel->save([
            'user_name' => $this->request->getVar('name'),
            'user_slug' => $slug,
            'user_nik' => $this->request->getVar('nik'),
            'user_jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'user_jabatan_id' => $this->request->getVar('jabatan_id')
        ]);
        
        // redirect to user page
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

        $user_arr = $this->userModel->where('user_nik', $nik)->first();
        
        if ($session['adminStatus'] == 2) {
            return redirect()->to('/Admin');
        }

        if (($session['adminStatus'] == $user_arr['user_jabatan_id'] && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3) || $user_arr['user_jabatan_id'] == 4 && ($session['adminStatus'] == 1 || $session['adminStatus'] == 3)) || $session['adminStatus'] == 1) {
            $data = [
                'title' => 'Form Edit Data Karyawan',
                'menu' => 'user',
                'validation' => \Config\Services::validation(),
                'user_arr' => $this->userModel->where('user_nik', $nik)->first()
            ];
    
            echo view('Admin/User/formEdit', $data);
        } else {
            return redirect()->to('/Admin');
        }


    }

    public function update($id) 
    {
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
        // Validation
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

        // insert input to database
        $this->userModel->save([
            'user_id' => $id,
            'user_name' => $this->request->getVar('name'),
            'user_slug' => $oldUser['user_slug'],
            'user_nik' => $this->request->getVar('nik'),
            'user_jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'user_jabatan_id' => $this->request->getVar('jabatan_id')
        ]);

        
        // redirect to user page
        session()->setFlashdata('pesan', 'Data user sudah berhasil diupdate');
        return redirect()->to('/Admin/User');
    }

    public function export()
    {
        $userBuilder = $this->userModel;
        $userBuilder->select('user.*');
        $userBuilder->select('jabatan_nama');
        $userBuilder->where('user_jabatan_id', 4);
        $userBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $user = $userBuilder->get();

        $data = [
            'user_arr' => $user->getResultArray()
        ];

        echo view('Admin/User/export', $data);
    }
}
?>