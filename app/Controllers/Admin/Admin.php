<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Helpers\HelperCarbon;
use App\Models\UserModel;
use App\Models\AuthModel;
use App\Models\AbsenModel;
use App\Models\KantorModel;

use function PHPUnit\Framework\isNull;

class Admin extends BaseController
{
    protected $userModel;
    protected $authModel;
    protected $absenModel;
    protected $kantorModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->authModel = new AuthModel();
        $this->absenModel = new AbsenModel();
        $this->kantorModel = new KantorModel();
    }

    public function index()
    {
        $session = session()->get();
        $thisYear = date('Y');
        $todayDate = date('Y-m-d');
        
        $inputFilterKantor = $this->request->getVar('kantor');
        $filterKantor = (!empty($inputFilterKantor)? $inputFilterKantor : $session['adminKantor']);
        $whereCond = array('user_kantor_id' => (!empty($inputFilterKantor) ? $inputFilterKantor : $session['adminKantor']));

        $kantor_name = $this->kantorModel->where($whereCond)->join('user', 'user_kantor_id = kantor_id')->first();

        $inputFilterYear = $this->request->getVar('year');
        $filterYear = (!empty($inputFilterYear) ?  $inputFilterYear : $thisYear);

        if ($session['adminStatus'] == 1) {
            if (!empty($inputFilterKantor)) {
                $totalUser = $this->userModel->where('user_jabatan_id', '4')->where($whereCond)->countAllResults();
                $totalAbsen = $this->absenModel->like('absen_datetime', $todayDate)->where($whereCond)->join('user', 'user_nik = absen_nik')->countAllResults();
                $totalCheckout = $this->absenModel->like('absen_checkout_datetime', $todayDate)->where($whereCond)->join('user', 'user_nik = absen_nik')->countAllResults();
            } else {
                $totalUser = $this->userModel->where('user_jabatan_id', '4')->countAllResults();
                $totalAbsen = $this->absenModel->like('absen_datetime', $todayDate)->join('user', 'user_nik = absen_nik')->countAllResults();
                $totalCheckout = $this->absenModel->like('absen_checkout_datetime', $todayDate)->join('user', 'user_nik = absen_nik')->countAllResults();
            }
        } else {
            $totalUser = $this->userModel->where('user_jabatan_id', '4')->where($whereCond)->countAllResults();
            $totalAbsen = $this->absenModel->like('absen_datetime', $todayDate)->where($whereCond)->join('user', 'user_nik = absen_nik')->countAllResults();
            $totalCheckout = $this->absenModel->like('absen_checkout_datetime', $todayDate)->where($whereCond)->join('user', 'user_nik = absen_nik')->countAllResults();
        }

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

        $calJan = HelperCarbon::calendar($likeJan, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkJan = count($calJan);
        $calFeb = HelperCarbon::calendar($likeFeb, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkFeb = count($calFeb);
        $calMar = HelperCarbon::calendar($likeMar, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkMar = count($calMar);
        $calApr = HelperCarbon::calendar($likeApr, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkApr = count($calApr);
        $calMei = HelperCarbon::calendar($likeMei, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkMei = count($calMei);
        $calJun = HelperCarbon::calendar($likeJun, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkJun = count($calJun);
        $calJul = HelperCarbon::calendar($likeJul, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkJul = count($calJul);
        $calAgu = HelperCarbon::calendar($likeAgu, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkAgu = count($calAgu);
        $calSep = HelperCarbon::calendar($likeSep, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkSep = count($calSep);
        $calOkt = HelperCarbon::calendar($likeOkt, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkOkt = count($calOkt);
        $calNov = HelperCarbon::calendar($likeNov, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkNov = count($calNov);
        $calDes = HelperCarbon::calendar($likeDes, ['isStartOfMonth' => true, 'isWorkDay' => true]);
        $dayWorkDes = count($calDes);
        
        $absenJan = $this->absenModel->like('absen_datetime', $likeJan)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkJan) * 100;
        $absenFeb = $this->absenModel->like('absen_datetime', $likeFeb)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkFeb) * 100;
        $absenMar = $this->absenModel->like('absen_datetime', $likeMar)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkMar) * 100;
        $absenApr = $this->absenModel->like('absen_datetime', $likeApr)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkApr) * 100;
        $absenMei = $this->absenModel->like('absen_datetime', $likeMei)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkMei) * 100;
        $absenJun = $this->absenModel->like('absen_datetime', $likeJun)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkJun) * 100;
        $absenJul = $this->absenModel->like('absen_datetime', $likeJul)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkJul) * 100;
        $absenAgu = $this->absenModel->like('absen_datetime', $likeAgu)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkAgu) * 100;
        $absenSep = $this->absenModel->like('absen_datetime', $likeSep)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkSep) * 100;
        $absenOkt = $this->absenModel->like('absen_datetime', $likeOkt)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkOkt) * 100;
        $absenNov = $this->absenModel->like('absen_datetime', $likeNov)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkNov) * 100;
        $absenDes = $this->absenModel->like('absen_datetime', $likeDes)->where($whereCond)->join('user', 'user_nik = absen_nik')->join('kantor', 'kantor_id = user_kantor_id')->countAllResults() / ($totalUser * $dayWorkDes) * 100;

        $absenPercent = $totalAbsen / $totalUser * 100;
        $checkoutPercent = $totalCheckout / $totalUser * 100;

        $offJan = 100 - $absenJan;
        $offFeb = 100 - $absenFeb;
        $offMar = 100 - $absenMar;
        $offApr = 100 - $absenApr;
        $offMei = 100 - $absenMei;
        $offJun = 100 - $absenJun;
        $offJul = 100 - $absenJul;
        $offAgu = 100 - $absenAgu;
        $offSep = 100 - $absenSep;
        $offOkt = 100 - $absenOkt;
        $offNov = 100 - $absenNov;
        $offDes = 100 - $absenDes;

        $kantorMap = $this->kantorModel->where('kantor_id', $filterKantor)->first();
        
        if (!empty($inputFilterKantor)) {
            $users = $this->userModel->where('user_jabatan_id', '4')->where($whereCond)->join('kantor', 'kantor_id = user_kantor_id')->paginate(10, 'index');
        } else {
            $users = $this->userModel->where('user_jabatan_id', '4')->join('kantor', 'kantor_id = user_kantor_id')->paginate(10, 'index');
        }

        foreach ($users as $key=>$user) {
            $absenBuilder = $this->absenModel;
            $absenBuilder->select('absen.*');
            $absenBuilder->where('absen_nik', $user['user_nik']);
            $absenBuilder->like('absen_datetime', $todayDate);
            $absen = $absenBuilder->get();
            $dataAbsen = $absen->getResultArray();
            if (!empty($dataAbsen[0]['absen_datetime'])) {
                unset($users[$key]);
            }
        }

        $absen_arr = $this->absenModel->where($whereCond)->like('absen_datetime', $todayDate)->join('user', 'user_nik = absen_nik')->get()->getResultArray();

        $kantor_arr = $this->kantorModel->findAll();
        $absenYearBuilder = $this->absenModel;
        $absenYearBuilder->distinct();
        $absenYearBuilder->select('Year(absen_datetime)');
        $absenYear = $absenYearBuilder->get();
        $absenYear = $absenYear->getResultArray();

        $data = [
            'title' => 'Home',
            'menu' => 'dashboard',
            'kantorName' => $kantor_name['kantor_name'],
            // data filter
            'inputFilterKantor' => $inputFilterKantor,
            'inputFilterYear' => $inputFilterYear,
            // data header
            'totalUser' => $totalUser,
            'totalAbsen' => $totalAbsen,
            'absenPercent' => $absenPercent,
            'checkoutPercent' => $checkoutPercent,
            // data chart
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
            'offJan' => $offJan,
            'offFeb' => $offFeb,
            'offMar' => $offMar,
            'offApr' => $offApr,
            'offMei' => $offMei,
            'offJun' => $offJun,
            'offJul' => $offJul,
            'offAgu' => $offAgu,
            'offSep' => $offSep,
            'offOkt' => $offOkt,
            'offNov' => $offNov,
            'offDes' => $offDes,
            // data map
            'kantor_map' => $kantorMap,
            // data user absen
            'absen_arr' => $absen_arr,
            'user_arr' => $users,
            'kantor_arr' => $kantor_arr,
            'absenYear' => $absenYear,
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

        $currentPage = $this->request->getVar('page_admin') ? $this->request->getVar('page_admin') : 1;
        $data = [
            'title' => 'Data Admin',
            'menu' => 'admin',
            'searchInput' => $search,
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
                'rules' => 'required|min_length[8]|max_length[30]',
                'errors' => [
                    'required' => 'Password wajib diisi gan',
                    'min_length' => 'Minimal password 8 karakter',
                    'max_length' => 'Maximal password 30 karakter'
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

    public function update()
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
            'auth_id' => $this->request->getVar('id'),
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

    public function export()
    {
        $admin_arr = $this->authModel->select('auth.*')->select('user.*')->select('kantor.kantor_name')->select('jabatan_nama')->join('user', 'auth_nik = user_nik')->join('jabatan', 'user_jabatan_id = jabatan_id')->join('kantor', 'kantor_id = user_kantor_id')->orderBy('kantor_name', 'ASC')->get()->getResultArray();

        $data = [
            'title' => 'Data Admin',
            'menu' => 'admin',
            'admin_arr' => $admin_arr,
        ];

        echo view('Admin/export', $data);
    }
}
?>