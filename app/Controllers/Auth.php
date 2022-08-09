<?php 

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $authModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->authModel = new AuthModel();
    }

    public function index()
    {

        $data = [
            'title' => 'Login',
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/login', $data);
    }

    public function login()
    {
        // Form validator
        if(!$this->validate([
            'username' => [
                'rules' => 'required|alpha|is_not_unique[auth.username]',
                'errors' => [
                    'required' => 'Username harus diisi gan',
                    'alpha' => 'Username tidak sesuai format',
                    'is_not_unique' => 'Username tidak terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Passwordnyaaaa....',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }
        
        // get admin data by username 
        $username = $this->request->getVar('username');
        $dataAdmin = $this->authModel->getAdminByUsername($username);

        // echo '<pre>'; print_r($dataAdmin); die;
        // save password data to variable
        $password = $this->request->getVar('password');
        $hashPassword = $dataAdmin['password'];
        // verify password match
        $checkpwd = password_verify($password, $hashPassword);

        if($checkpwd === false) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }       
        // get full admin data with join user & jabatan
        $db = \Config\Database::connect();
        $builder = $db->table('auth');
        $builder->join('user', 'auth.nik = user.nik');
        $builder->join('jabatan', 'user.jabatan_id = jabatan.uid');
        $builder->select('auth.*');
        $builder->select('user.name');
        $builder->select('jabatan.*');
        $builder->where('username', $username);
        $query = $builder->get();
        $admin = $query->getResultArray();
        // session data config
        foreach($admin as $admin) {
            $dataSession = [
                'adminId' => $admin['admin_id'],
                'adminStatus' => $admin['uid'],
                'adminName' => $admin['name']
            ];
        }
        session()->set($dataSession);
        return redirect()->to('/Admin');
    }

    public function forgotPasswordForm()
    {
        $data = [
            'title' => 'Forgot Password',
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/forgotPassword', $data);
    }

    public function resetCheck()
    {
        // Form Validator
        if(!$this->validate([
            'nik' => [
                'rules' => 'required|numeric|is_not_unique[auth.nik]',
                'errors' => [
                    'required' => 'NIK harus diisi gan',
                    'numeric' => 'NIK tidak sesuai format',
                    'is_not_unique' => 'NIK tidak terdaftar'
                ]
            ],
            'username' => [
                'rules' => 'required|alpha|is_not_unique[auth.username]',
                'errors' => [
                    'required' => 'Username harus diisi gan',
                    'alpha' => 'Username tidak sesuai format',
                    'is_not_unique' => 'Username tidak terdaftar'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[auth.email]',
                'errors' => [
                    'required' => 'Email harus diisi gan',
                    'valid_email' => 'Email tidak sesuai format',
                    'is_not_unique' => 'Email tidak terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Passwordnya manaa....'
                ]
            ],
            'confirmPwd' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Passwordnya 2 kali gan',
                    'matches' => 'Password tidak cocok'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        
        $db = \Config\Database::connect();
        $builder = $db->table('auth');
        $builder->select('*');
        $builder->where('nik', $this->request->getVar('nik'));
        $builder->where('username', $this->request->getVar('username'));
        $builder->where('email', $this->request->getVar('email'));
        $builder->limit(1);
        $admin = $builder->get();

        if (empty($admin->getResultArray()))
        {
            session()->setFlashdata('pesan', 'Akun Tidak Sesuai');
            return redirect()->back()->withInput();
        }

        $dataAdmin = $this->authModel->getAdmin($this->request->getVar('nik'));
        $password = $this->request->getVar('confirmPwd');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        
        // echo '<pre>'; print_r($dataAdmin); die;
        $this->authModel->save([
            'admin_id' => $dataAdmin['admin_id'],
            'password' => $passwordHash
        ]);

        session()->setFlashdata('resetSuccess', 'Berhasil Reset Password Anda Silahkan coba login kembali');
        return redirect()->to('Admin/Login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('Admin/Login');
    }
}

?>