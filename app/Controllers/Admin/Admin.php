<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AuthModel;
use App\Models\AbsenModel;

class Admin extends BaseController
{
    protected $userModel;
    protected $authModel;
    protected $absenModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->authModel = new AuthModel();
        $this->absenModel = new AbsenModel();
    }

    public function index()
    {
        $filterYear = $this->request->getVar('year');
        $thisYear = date('Y');

        if (!empty($filterYear)) {
            $likeJan = ''.$filterYear.'-01';
            $likeFeb = ''.$filterYear.'-02';
            $likeMar = ''.$filterYear.'-03';
            $likeApr = ''.$filterYear.'-04';
            $likeMei = ''.$filterYear.'-05';
            $likeJun = ''.$filterYear.'-06';
            $likeJul = ''.$filterYear.'-07';
            $likeAgu = ''.$filterYear.'-08';
            $likeSep = ''.$filterYear.'-09';
            $likeOkt = ''.$filterYear.'-10';
            $likeNov = ''.$filterYear.'-11';
            $likeDes = ''.$filterYear.'-12';
        } else {
            $likeJan = ''.$thisYear.'-01';
            $likeFeb = ''.$thisYear.'-02';
            $likeMar = ''.$thisYear.'-03';
            $likeApr = ''.$thisYear.'-04';
            $likeMei = ''.$thisYear.'-05';
            $likeJun = ''.$thisYear.'-06';
            $likeJul = ''.$thisYear.'-07';
            $likeAgu = ''.$thisYear.'-08';
            $likeSep = ''.$thisYear.'-09';
            $likeOkt = ''.$thisYear.'-10';
            $likeNov = ''.$thisYear.'-11';
            $likeDes = ''.$thisYear.'-12';
        }

        $todayDate = date('Y-m-d');
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $totalUser = $this->userModel->where('user_jabatan_id', '4')->countAllResults();
        $totalAbsen = $this->absenModel->like('absen_datetime', $todayDate)->countAllResults();
        $totalCheckout = $this->absenModel->like('absen_checkout_datetime', $todayDate)->countAllResults();
        $absenPercent = $totalAbsen / $totalUser * 100;
        $checkoutPercent = $totalCheckout / $totalUser * 100;

        $absenJan = $this->absenModel->like('absen_datetime', $likeJan)->countAllResults() / ($totalUser * 20) * 100;
        $absenFeb = $this->absenModel->like('absen_datetime', $likeFeb)->countAllResults() / ($totalUser * 20) * 100;
        $absenMar = $this->absenModel->like('absen_datetime', $likeMar)->countAllResults() / ($totalUser * 20) * 100;
        $absenApr = $this->absenModel->like('absen_datetime', $likeApr)->countAllResults() / ($totalUser * 20) * 100;
        $absenMei = $this->absenModel->like('absen_datetime', $likeMei)->countAllResults() / ($totalUser * 20) * 100;
        $absenJun = $this->absenModel->like('absen_datetime', $likeJun)->countAllResults() / ($totalUser * 20) * 100;
        $absenJul = $this->absenModel->like('absen_datetime', $likeJul)->countAllResults() / ($totalUser * 20) * 100;
        $absenAgu = $this->absenModel->like('absen_datetime', $likeAgu)->countAllResults() / ($totalUser * 20) * 100;
        $absenSep = $this->absenModel->like('absen_datetime', $likeSep)->countAllResults() / ($totalUser * 20) * 100;
        $absenOkt = $this->absenModel->like('absen_datetime', $likeOkt)->countAllResults() / ($totalUser * 20) * 100;
        $absenNov = $this->absenModel->like('absen_datetime', $likeNov)->countAllResults() / ($totalUser * 20) * 100;
        $absenDes = $this->absenModel->like('absen_datetime', $likeDes)->countAllResults() / ($totalUser * 20) * 100;

        $absenYearBuilder = $this->absenModel;
        $absenYearBuilder->distinct();
        $absenYearBuilder->select('Year(absen_datetime)');
        $absenYear = $absenYearBuilder->get();
        $absenYear = $absenYear->getResultArray();

        $users = $this->userModel->where('user_jabatan_id', '4')->paginate(10, 'index');
        foreach ($users as $key=>$user) {
            $absenBuilder = $this->absenModel;
            $absenBuilder->select('absen.*');
            $absenBuilder->where('absen_nik', $user['user_nik']);
            $absenBuilder->like('absen_datetime', $todayDate);
            $absen = $absenBuilder->get();
            $dataAbsen = $absen->getResultArray();

            $absenLabel = !empty($dataAbsen[0]['absen_datetime']) ? 'Sudah Absen' : 'Belum Absen';
            $checkoutLabel = !empty($dataAbsen[0]['absen_checkout_datetime']) ? 'Sudah Checkout' : 'Belum Checkout';

            $users[$key]['absen_label'] = $absenLabel;
            $users[$key]['checkout_label'] = $checkoutLabel;
        }
        
        $data = [
            'title' => 'Home',
            'menu' => 'dashboard',
            'absenJan' => $absenJan,
            'absenFeb' => $absenFeb,
            'absenMar' => $absenMar,
            'absenApr' => $absenApr,
            'absenMei' => $absenMei,
            'absenJun' => $absenJun,
            'absenJul' => $absenJul,
            'absenAgu' => $absenAgu,
            'absenSep' => $absenSep,
            'absenOkt' => $absenOkt,
            'absenNov' => $absenNov,
            'absenDes' => $absenDes,
            'totalUser' => $totalUser,
            'totalAbsen' => $totalAbsen,
            'absenPercent' => $absenPercent,
            'checkoutPercent' => $checkoutPercent,
            'user_arr' => $users,
            'absenYear' => $absenYear,
            'pager' => $this->userModel->pager,
            'currentPage' => $currentPage
        ];
          
        echo view('Admin/index', $data);
    }

    public function admin()
    {
        $search = $this->request->getVar('search');

        if (!empty($search)) {
            $admin_arr = $this->authModel->like('auth_username', $search)->orWhere('auth_nik', $search)->join('user', 'auth_nik = user_nik')->join('jabatan', 'user_jabatan_id = jabatan_id')->select('auth.*')->select('user.*')->select('jabatan_nama')->paginate(10, 'admin');
        } else {
            $admin_arr = $this->authModel->join('user', 'auth_nik = user_nik')->join('jabatan', 'user_jabatan_id = jabatan_id')->select('auth.*')->select('user.*')->select('jabatan_nama')->paginate(10, 'admin');
        }

        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Data Admin',
            'menu' => 'admin',
            'admin_arr' => $admin_arr,
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
            'menu' => 'admin',
            'user_arr' => $user,
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/formInsert', $data);
    }

    public function insert() 
    {
        // Validation
        if(!$this->validate([
            'username' => [
                'rules' => 'required|alpha_numeric_punct|max_length[25]',
                'errors' => [
                    'required' => 'Username harus diisi gan',
                    'alpha_numeric_punct' => 'Username tidak sesuai format',
                    'max_length' => 'Username tidak boleh melebihi 25 huruf'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email wajib diisi gan',
                    'valid_email' => 'Format email tidak valid'
                ]
            ],
            'password' => [
                'rules' => 'required|max_length[25]',
                'errors' => [
                    'required' => 'Password wajib diisi gan',
                    'max_length' => 'Password tidak boleh melebihi 25 karakter'
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
                'rules' => 'required|alpha_numeric|is_unique[auth.auth_nik]|exact_length[11]',
                'errors' => [
                    'required' => 'Pilih Salah Satu Karyawan sebagai pemegang dan penanggung jawab akun',
                    'alpha_numeric' => 'NIK hanya boleh berisi angka dan huruf',
                    'is_unique' => 'Karyawan Sudah Memiliki Akun',
                    'exact_length' => 'NIK harus berisi 11 karakter, NO NEGO',
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
            'auth_username' => $this->request->getVar('username'),
            'auth_email' => $this->request->getVar('email'),
            'auth_password' => $hashedPassword,
            'auth_nik' => $this->request->getVar('nik')
        ]);

        session()->setFlashdata('pesan', 'Berhasil Membuat akun admin baru');
        return redirect()->to('/Admin/Admin');
    }

    public function formUpdate($nik)
    {
        $user = $this->userModel->getUserAdmin();
        $admin = $this->authModel->getAdmin($nik);
        $data = [
            'title' => 'Form Update Admin',
            'menu' => 'admin',
            'user_arr' => $user,
            'admin_arr' => $admin,
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/formUpdate', $data);
    }

    public function update($id)
    {
        // Validation
        if(!$this->validate([
            'username' => [
                'rules' => 'required|alpha_numeric_punct|max_length[25]',
                'errors' => [
                    'required' => 'Username harus diisi gan',
                    'alpha_numeric_punct' => 'Username tidak sesuai format',
                    'max_length' => 'Username tidak boleh melebihi 25 huruf'
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
            'auth_id' => $id,
            'auth_username' => $this->request->getVar('username'),
            'auth_email' => $this->request->getVar('email')
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

    public function previewPdf()
    {
        $filterYear = $this->request->getVar('year');
        $thisYear = date('Y');

        if (!empty($filterYear)) {
            $likeJan = ''.$filterYear.'-01';
            $likeFeb = ''.$filterYear.'-02';
            $likeMar = ''.$filterYear.'-03';
            $likeApr = ''.$filterYear.'-04';
            $likeMei = ''.$filterYear.'-05';
            $likeJun = ''.$filterYear.'-06';
            $likeJul = ''.$filterYear.'-07';
            $likeAgu = ''.$filterYear.'-08';
            $likeSep = ''.$filterYear.'-09';
            $likeOkt = ''.$filterYear.'-10';
            $likeNov = ''.$filterYear.'-11';
            $likeDes = ''.$filterYear.'-12';
        } else {
            $likeJan = ''.$thisYear.'-01';
            $likeFeb = ''.$thisYear.'-02';
            $likeMar = ''.$thisYear.'-03';
            $likeApr = ''.$thisYear.'-04';
            $likeMei = ''.$thisYear.'-05';
            $likeJun = ''.$thisYear.'-06';
            $likeJul = ''.$thisYear.'-07';
            $likeAgu = ''.$thisYear.'-08';
            $likeSep = ''.$thisYear.'-09';
            $likeOkt = ''.$thisYear.'-10';
            $likeNov = ''.$thisYear.'-11';
            $likeDes = ''.$thisYear.'-12';
        }

        $todayDate = date('Y-m-d');
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $totalUser = $this->userModel->where('user_jabatan_id', '4')->countAllResults();
        $totalAbsen = $this->absenModel->like('absen_datetime', $todayDate)->countAllResults();
        $totalCheckout = $this->absenModel->like('absen_checkout_datetime', $todayDate)->countAllResults();
        $absenPercent = $totalAbsen / $totalUser * 100;
        $checkoutPercent = $totalCheckout / $totalUser * 100;

        $absenJan = $this->absenModel->like('absen_datetime', $likeJan)->countAllResults() / ($totalUser * 20) * 100;
        $absenFeb = $this->absenModel->like('absen_datetime', $likeFeb)->countAllResults() / ($totalUser * 20) * 100;
        $absenMar = $this->absenModel->like('absen_datetime', $likeMar)->countAllResults() / ($totalUser * 20) * 100;
        $absenApr = $this->absenModel->like('absen_datetime', $likeApr)->countAllResults() / ($totalUser * 20) * 100;
        $absenMei = $this->absenModel->like('absen_datetime', $likeMei)->countAllResults() / ($totalUser * 20) * 100;
        $absenJun = $this->absenModel->like('absen_datetime', $likeJun)->countAllResults() / ($totalUser * 20) * 100;
        $absenJul = $this->absenModel->like('absen_datetime', $likeJul)->countAllResults() / ($totalUser * 20) * 100;
        $absenAgu = $this->absenModel->like('absen_datetime', $likeAgu)->countAllResults() / ($totalUser * 20) * 100;
        $absenSep = $this->absenModel->like('absen_datetime', $likeSep)->countAllResults() / ($totalUser * 20) * 100;
        $absenOkt = $this->absenModel->like('absen_datetime', $likeOkt)->countAllResults() / ($totalUser * 20) * 100;
        $absenNov = $this->absenModel->like('absen_datetime', $likeNov)->countAllResults() / ($totalUser * 20) * 100;
        $absenDes = $this->absenModel->like('absen_datetime', $likeDes)->countAllResults() / ($totalUser * 20) * 100;

        $absenYearBuilder = $this->absenModel;
        $absenYearBuilder->distinct();
        $absenYearBuilder->select('Year(absen_datetime)');
        $absenYear = $absenYearBuilder->get();
        $absenYear = $absenYear->getResultArray();

        $users = $this->userModel->where('user_jabatan_id', '4')->paginate(10, 'index');
        foreach ($users as $key=>$user) {
            $absenBuilder = $this->absenModel;
            $absenBuilder->select('absen.*');
            $absenBuilder->where('absen_nik', $user['user_nik']);
            $absenBuilder->like('absen_datetime', $todayDate);
            $absen = $absenBuilder->get();
            $dataAbsen = $absen->getResultArray();

            $absenLabel = !empty($dataAbsen[0]['absen_datetime']) ? 'Sudah Absen' : 'Belum Absen';
            $checkoutLabel = !empty($dataAbsen[0]['absen_checkout_datetime']) ? 'Sudah Checkout' : 'Belum Checkout';

            $users[$key]['absen_label'] = $absenLabel;
            $users[$key]['checkout_label'] = $checkoutLabel;
        }        
        
        $data = [
            'title' => 'Home',
            'menu' => 'dashboard',
            'absenJan' => $absenJan,
            'absenFeb' => $absenFeb,
            'absenMar' => $absenMar,
            'absenApr' => $absenApr,
            'absenMei' => $absenMei,
            'absenJun' => $absenJun,
            'absenJul' => $absenJul,
            'absenAgu' => $absenAgu,
            'absenSep' => $absenSep,
            'absenOkt' => $absenOkt,
            'absenNov' => $absenNov,
            'absenDes' => $absenDes,
            'totalUser' => $totalUser,
            'totalAbsen' => $totalAbsen,
            'absenPercent' => $absenPercent,
            'checkoutPercent' => $checkoutPercent,
            'user_arr' => $users,
            'absenYear' => $absenYear,
            'pager' => $this->userModel->pager,
            'currentPage' => $currentPage
        ];
          
        echo view('Admin/previewPdf', $data);
    }
}
?>