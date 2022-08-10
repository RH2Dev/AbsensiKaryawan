<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\JabatanModel;
use App\Models\AbsenModel;

class User extends BaseController
{
    protected $userModel;
    protected $jabatanModel;
    protected $absenModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jabatanModel = new JabatanModel();
        $this->absenModel = new AbsenModel();
    }

    // get all users
    public function user()
    {
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Karyawan',
            'user' => $this->userModel->join('jabatan', 'jabatan.uid = user.jabatan_id')->orderBy('jabatan_id', 'ASC')->paginate(10, 'user'),
            'pager' => $this->userModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/User/user', $data);
    }

    public function detail($nik) 
    {
        $db = \Config\Database::connect();
        $user = $db->table('user');
        $user->join('jabatan', 'user.jabatan_id = jabatan.uid');
        $user->select('user.*');
        $user->where('nik', $nik);
        $user->select('jabatan.nama_jabatan');
        $user = $user->get();
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Detail Karyawan',
            'user' => $user->getResultArray(),
            'absen' => $this->absenModel->where('nik', $nik)->orderBy('tanggal', 'DESC')->paginate(10, 'absen'),
            'pager' => $this->absenModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/User/detailUser', $data);
    }

    // echo form insert user view
    public function formInsert()
    {
        $data = [
            'title' => 'Tambah Data Karyawan',
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
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Nama harus diisi gan',
                    'alpha_space' => 'Nama tidak boleh menggunakan special character'
                ]
            ],
            'nik' => [
                'rules' => 'required|is_unique[user.nik]|decimal',
                'errors' => [
                    'required' => 'NIK wajib disi gan',
                    'is_unique' => 'NIK tidak boleh sama',
                    'decimal' => 'NIK hanya diperbolehkan menggunakan angka'
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
            'name' => $this->request->getVar('name'),
            'slug' => $slug,
            'nik' => $this->request->getVar('nik'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'jabatan_id' => $this->request->getVar('jabatan_id')
        ]);
        
        // redirect to user page
        session()->setFlashdata('pesan', 'Data user sudah berhasil ditambahkan');
        return redirect()->to('/Admin/User');
    }

    public function delete($user_id)
    {
        $this->userModel->delete($user_id);
        session()->setFlashdata('pesan', 'Data user sudah terhapus');
        return redirect()->to('/Admin/User');
    }

    public function formEdit($slug)
    {
        $data = [
            'title' => 'Edit Data Karyawan',
            'validation' => \Config\Services::validation(),
            'user' => $this->userModel->getUser($slug)
        ];

        echo view('Admin/User/formEdit', $data);
    }

    public function update($id) 
    {
        $oldUser = $this->userModel->getUser($this->request->getVar('slug'));
        if ($oldUser['nik'] == $this->request->getVar('nik')) {
            $rules_nik = 'required|decimal';
        } else {
            $rules_nik = 'required|is_unique[user.nik]|decimal';
        }
        // Validation
        if(!$this->validate([
            'name' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Nama harus diisi gan',
                    'alpha_space' => 'Nama tidak boleh menggunakan special character'
                ]
            ],
            'nik' => [
                'rules' => $rules_nik,
                'errors' => [
                    'required' => 'NIK wajib disi gan',
                    'is_unique' => 'NIK tidak boleh sama',
                    'decimal' => 'NIK hanya diperbolehkan menggunakan angka'
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

        // insert input to database
        $slug = url_title($this->request->getVar('name'), '-', true);
        $this->userModel->save([
            'user_id' => $id,
            'name' => $this->request->getVar('name'),
            'slug' => $slug,
            'nik' => $this->request->getVar('nik'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'jabatan_id' => $this->request->getVar('jabatan_id')
        ]);

        
        // redirect to user page
        session()->setFlashdata('pesan', 'Data user sudah berhasil diupdate');
        return redirect()->to('/Admin/User');
    }

    public function search() 
    {
        $search = $this->request->getVar('search');
        $db = \Config\Database::connect();
        $user = $db->table('user');
        $user->join('jabatan', 'user.jabatan_id = jabatan.uid');
        $user->select('user.*');
        $user->select('jabatan.*');
        $user->like('name', $search);
        $user->orWhere('nik', $search);
        $user = $user->get();
        
        $data = [
            'title' => 'Karyawan',
            'user' => $user->getResultArray()
        ];

        // echo '<pre>'; print_r($data['user']); die;

        echo view('Admin/User/search', $data);
    }
}
?>