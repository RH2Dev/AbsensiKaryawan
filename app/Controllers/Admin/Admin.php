<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AuthModel;

class Admin extends BaseController
{
    protected $userModel;
    protected $authModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $users = $this->userModel->where('jabatan_id', '4')->paginate(10, 'index');
        foreach ($users as $key=>$user) {
            $today = date('Y-m-d');
            $db = \Config\Database::connect();
            $absen = $db->table('data_absen');
            $absen->select('data_absen.*');
            $absen->where('nik', $user['nik']);
            $absen->like('tanggal', $today);
            $absen = $absen->get();
            $dataAbsen = $absen->getResultArray();

            $absenLabel = !empty($dataAbsen) ? 'Sudah Absen' : 'Belum Absen';
            $checkoutLabel = !empty($dataAbsen) ? 'Sudah Checkout' : 'Belum Checkout';

            $users[$key]['absenLabel'] = $absenLabel;
            $users[$key]['checkoutLabel'] = $checkoutLabel;
        }        
        
        $data = [
            'title' => 'Home',
            'user' => $users,
            'pager' => $this->userModel->pager,
            'currentPage' => $currentPage
        ];
          

        // echo '<pre>'; print_r($data['user']); die;
        echo view('Admin/index', $data);
    }

    public function admin()
    {
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Data Admin',
            'admin' => $this->authModel->join('user', 'auth.nik = user.nik')->join('jabatan', 'user.jabatan_id = jabatan.uid')->select('auth.*')->select('user.*')->select('jabatan.nama_jabatan')->paginate(10, 'admin'),
            'pager' => $this->authModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/admin', $data);
    }

    public function formInsert()
    {
        $user = $this->userModel->getUserAdmin();
        $data = [
            'title' => 'Form Insert Data Admin',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/formInsert', $data);
    }

    public function insert() 
    {
        // Validation
        if(!$this->validate([
            'username' => [
                'rules' => 'required|alpha',
                'errors' => [
                    'required' => 'Username harus diisi gan',
                    'alpha' => 'Username tidak sesuai format'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email wajib disi gan',
                    'valid_email' => 'Format email tidak valid'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib disi gan'
                ]
            ],
            'confirmPwd' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Harus Pilih salah satu jabatan',
                    'matches' => 'Password tidak cocok'
                ]
            ],
            'nik' => [
                'rules' => 'required|is_unique[auth.nik]',
                'errors' => [
                    'required' => 'Pilih Salah Satu Karyawan sebagai pemegang dan penanggung jawab akun',
                    'is_unique' => 'Karyawan Sudah Memiliki Akun',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }
        $password = $this->request->getVar('password');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // insert input to database
        $this->authModel->save([
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => $hashedPassword,
            'nik' => $this->request->getVar('nik')
        ]);

        session()->setFlashdata('pesan', 'Berhasil Membuat akun admin baru');
        return redirect()->to('/Admin/Admin');
    }

    public function formUpdate($nik)
    {
        $user = $this->userModel->getUserAdmin();
        $admin = $this->authModel->getAdmin($nik);
        $data = [
            'title' => 'Form Update Data Admin',
            'user' => $user,
            'admin' => $admin,
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/formUpdate', $data);
    }

    public function update($id)
    {
        // Validation
        if(!$this->validate([
            'username' => [
                'rules' => 'required|alpha',
                'errors' => [
                    'required' => 'Username harus diisi gan',
                    'alpha' => 'Username tidak sesuai format'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email wajib disi gan',
                    'valid_email' => 'Format email tidak valid'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        
        $this->authModel->save([
            'admin_id' => $id,
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email')
        ]);

        session()->setFlashdata('pesan', 'Berhasil update data akun admin');
        return redirect()->to('/Admin/Admin');
    }

    public function delete($id)
    {
        $this->authModel->delete($id);
        session()->setFlashdata('pesan', 'Data akun sudah terhapus');
        return redirect()->to('/Admin/Admin');
    }

    public function search() 
    {
        $search = $this->request->getVar('search');
        $db = \Config\Database::connect();
        $admin = $db->table('auth');
        $admin->join('user', 'auth.nik = user.nik');
        $admin->join('jabatan', 'user.jabatan_id = jabatan.uid');
        $admin->select('auth.*');
        $admin->select('user.name');
        $admin->select('jabatan.nama_jabatan');
        $admin->like('username', $search);
        $admin->orWhere('auth.nik', $search);
        $admin = $admin->get();
        $data = [
            'title' => 'Data Admin',
            'admin' => $admin->getResultArray()
        ];

        echo view('Admin/search', $data);
    }
}
?>