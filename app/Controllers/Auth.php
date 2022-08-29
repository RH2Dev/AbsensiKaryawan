<?php 

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $authModel;
    protected $userModel;
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
                'rules' => 'required|alpha_numeric_punct|is_not_unique[auth.auth_username]',
                'errors' => [
                    'required' => 'Username harus diisi gan',
                    'alpha_numeric_punct' => 'Username tidak sesuai format',
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
        $dataAdmin = $this->authModel->where('auth_username', $this->request->getVar('username'))->first();

        // save password data to variable
        $password = $this->request->getVar('password');
        $hashPassword = $dataAdmin['auth_password'];
        // verify password match
        $checkpwd = password_verify($password, $hashPassword);

        if($checkpwd === false) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }       
        // get full admin data with join user & jabatan
        $authBuilder = $this->authModel;
        $authBuilder->select('auth_id');
        $authBuilder->select('jabatan_id');
        $authBuilder->select('user_name');
        $authBuilder->select('kantor_id');
        $authBuilder->where('auth_username', $this->request->getVar('username'));
        $authBuilder->join('user', 'auth_nik = user_nik');
        $authBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $authBuilder->join('kantor', 'user_kantor_id = kantor_id');
        $auth = $authBuilder->get();
        $auth_arr = $auth->getResultArray();

        // session data config
        foreach($auth_arr as $admin) {
            $dataSession = [
                'adminId' => $admin['auth_id'],
                'adminStatus' => $admin['jabatan_id'],
                'adminName' => $admin['user_name'],
                'adminKantor' => $admin['kantor_id']
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
                'rules' => 'required|alpha_numeric_punct|is_not_unique[auth.auth_nik]',
                'errors' => [
                    'required' => 'NIK harus diisi gan',
                    'alpha_numeric_punct' => 'NIK hanya boleh berisi angka dan huruf',
                    'is_not_unique' => 'NIK tidak terdaftar'
                ]
            ],
            'username' => [
                'rules' => 'required|alpha_numeric_punct|is_not_unique[auth.auth_username]',
                'errors' => [
                    'required' => 'Username harus diisi gan',
                    'alpha_numeric_punct' => 'Username tidak sesuai format',
                    'is_not_unique' => 'Username tidak terdaftar'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[auth.auth_email]',
                'errors' => [
                    'required' => 'Email harus diisi gan',
                    'valid_email' => 'Email tidak sesuai format',
                    'is_not_unique' => 'Email tidak terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|max_length[30]',
                'errors' => [
                    'required' => 'Passwordnya manaa....',
                    'min_length' => 'Minimal password 8 karakter',
                    'max_length' => 'Maximal password 30 karakter'
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

        $authBuilder = $this->authModel;
        $authBuilder->select('*');
        $authBuilder->where('auth_nik', $this->request->getVar('nik'));
        $authBuilder->where('auth_username', $this->request->getVar('username'));
        $authBuilder->where('auth_email', $this->request->getVar('email'));
        $auth = $authBuilder->get();
        $auth_arr = $auth->getResultArray();

        if (empty($auth_arr))
        {
            session()->setFlashdata('pesan', 'Akun Tidak Sesuai');
            return redirect()->back()->withInput();
        }

        $password = $this->request->getVar('confirmPwd');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        
        // echo '<pre>'; print_r($dataAdmin); die;
        $this->authModel->save([
            'auth_id' => $auth_arr[0]['auth_id'],
            'auth_password' => $passwordHash
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