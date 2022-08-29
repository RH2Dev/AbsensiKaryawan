<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AbsenModel;
use App\Models\KantorModel;

class Absen extends BaseController
{
    protected $userModel;
    protected $absenModel;
    protected $kantorModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->absenModel = new AbsenModel();
        $this->kantorModel = new KantorModel();
    }

    public function index()
    {   
        $session = session()->get();
        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $fullURL = $currentURL . '?' . $params;

        $search = $this->request->getVar('search');
        $year = $this->request->getVar('year');
        $month = $this->request->getVar('month');
        $kantor = $this->request->getVar('kantor');
        $date = ''.$year.'-'.$month.'';
        $absenYearBuilder = $this->absenModel;
        $absenYearBuilder->distinct();
        $absenYearBuilder->select('Year(absen_datetime)');
        $absenYear = $absenYearBuilder->get();
        $absenYear = $absenYear->getResultArray();

        $absenBuilder = $this->absenModel;
        $absenBuilder->join('user', 'user_nik = absen_nik');
        if (!empty($search)) {
            $absenBuilder->like('user_name', $search);
        }
        if (!empty($year)) {
            $absenBuilder->like('absen_datetime', $date);
        }
        if ($session['adminStatus'] == 1) {
            if (!empty($kantor)) {
                $absenBuilder->where('user_kantor_id', $kantor);
            }
        } else {
            $absenBuilder->where('user_kantor_id', $session['adminKantor']);
        }
        $absenBuilder->orderBy('absen_datetime', 'DESC');
        $absen_arr = $absenBuilder->paginate(10, 'absen');

        $currentPage = $this->request->getVar('page_absen') ? $this->request->getVar('page_absen') : 1;
        $kantor_arr = $this->kantorModel->findAll();
        $data = [
            'title' => 'Absensi',
            'menu' => 'absensi',
            'absenYear' => $absenYear,
            'absen_arr' => $absen_arr,
            'kantor_arr' => $kantor_arr,
            'kantorInput' => $kantor,
            'yearInput' => $year,
            'searchInput' => $search,
            'pager' => $this->absenModel->pager,
            'currentPage' => $currentPage,
            'fullURL' => $fullURL,
            'year' => $year,
            'month' => $month,
        ];

        echo view('Admin/Absen/absen', $data);
    }

    public function detail($id)
    {
        
        $db = \Config\Database::connect();
        $absen_builder = $db->table('absen');
        $absen_builder->select('absen.*');
        $absen_builder->select('user.*');
        $absen_builder->select('jabatan.jabatan_nama');
        $absen_builder->select('kantor.*');
        $absen_builder->where('absen_id', $id);
        $absen_builder->join('user', 'user_nik = absen_nik');
        $absen_builder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $absen_builder->join('kantor', 'user_kantor_id = kantor_id');
        $absen = $absen_builder->get();
        $data = [
            'title' => 'Absensi',
            'menu' => 'absensi',
            'absen_arr' => $absen->getResultArray()
        ];

        
        echo view('Admin/Absen/detailAbsen', $data);
    }

    public function formInsert()
    {
        $data = [
            'title' => 'Form Insert Absen',
            'menu' => 'absensi',
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/Absen/formInsert', $data);
    }

    public function insert()
    {

        $todayDate = date('Y-m-d');
        // NIK Validation
        $nik = $this->userModel->getUserByNIK($this->request->getVar('nik'));
        $kantor_arr = $this->kantorModel->where('kantor_id', $nik['user_kantor_id'])->first();
        
        // Calculate Radius
        $latKantor = $kantor_arr['kantor_latitude'] ; 
        $longKantor = $kantor_arr['kantor_longitude']; 
        $latUser = $this->request->getVar('latitude'); 
        $longUser = $this->request->getVar('longitude');  
        
        //Converting to radians
        $longi1 = deg2rad($longKantor); 
        $longi2 = deg2rad($longUser); 
        $lati1 = deg2rad($latKantor); 
        $lati2 = deg2rad($latUser); 
                
        //Haversine Formula 
        $difflong = $longi2 - $longi1; 
        $difflat = $lati2 - $lati1; 
                
        $val = pow(sin($difflat/2),2)+cos($lati1)*cos($lati2)*pow(sin($difflong/2),2); 
                
        $radius = 6378.8 * (2 * asin(sqrt($val))) * 1000; //for meters
        $max = $kantor_arr['kantor_radius'];

        if ($radius >= $max) {
            session()->setFlashdata('pesan', 'Anda Tidak Dalam Radius Absen '.$kantor_arr['kantor_name'].'');
            return redirect()->back();
        }

        // Ambil data absen user hari ini
        $absenBuilder = $this->absenModel;
        $absenBuilder->like('absen_datetime', $todayDate);
        $absenBuilder->where('absen_nik', $this->request->getVar('nik'));
        $absen = $absenBuilder->get();
        $absen_arr = $absen->getResultArray();

        if ($nik['user_jabatan_id'] != 4) {
            session()->setFlashdata('pesan', 'Hanya karyawan yang perlu absen');
            return redirect()->back();
        }

        // cek apakah NIK Tersedia
        if (!empty($nik)) {
            // Cek apakah user sudah absen & checkout
            if (!empty($absen_arr[0]['absen_datetime']) && !empty($absen_arr[0]['absen_checkout_datetime'])) {
                session()->setFlashdata('pesan', 'Anda Sudah Absen Hari ini');
                return redirect()->back();
            }

            // Convert raw image data to file
            $image = $this->request->getVar('photo');
            $imageData = str_replace('data:image/webp;base64,', '', $image);
            $file = base64_decode($imageData, true);
            $fileName = uniqid('', true).'-'.$this->request->getVar('nik').'.jpg';

            // Jika user sudah absen, maka absensi dianggap checkout
            if (!empty($absen_arr)) {

                $this->absenModel->save([
                    'absen_id' => $absen_arr[0]['absen_id'],
                    'absen_photo_checkout' => $fileName,
                    'absen_latitude_checkout' => $this->request->getVar('latitude'),
                    'absen_longitude_checkout' => $this->request->getVar('longitude'),
                    'absen_checkout_datetime' => date('Y-m-d H:i:s')
                ]);

                file_put_contents(FCPATH . 'img/' .$fileName, $file);
    
                session()->setFlashdata('pesan', 'Berhasil Checkout');
                return redirect()->to('/Admin/Absensi/formInsert');
            }

            $data = [
                'absen_nik' => $this->request->getVar('nik'),
                'absen_photo' => $fileName,
                'absen_latitude' => $this->request->getVar('latitude'),
                'absen_longitude' => $this->request->getVar('longitude'),
                'absen_datetime' => date('Y-m-d H:i:s')
            ];

            // insert input to database
            if($this->absenModel->save($data) === true) {
            // insert file to img folder
                file_put_contents(FCPATH . 'img/' .$fileName, $file);

                session()->setFlashdata('pesan', 'Berhasil absen');
                return redirect()->to('/Admin/Absensi/formInsert');
            };

            return redirect()->back()->withInput();

        } else {
            session()->setFlashdata('pesan', 'NIK tidak terdaftar');
            return redirect()->back()->withInput();
        }
    }

    public function export()
    {
        $session = session()->get();
        $year = $this->request->getVar('year');
        $month = $this->request->getVar('month');
        $kantor = $this->request->getVar('kantor');
        $date = ''.$year.'-'.$month.'';
        $absenBuilder = $this->absenModel;
        $absenBuilder->select('absen.*');
        $absenBuilder->select('user_name');
        $absenBuilder->select('jabatan_nama');
        $absenBuilder->like('absen_datetime', $date);
        if ($session['adminStatus'] == 1) {
            if (!empty($kantor)) {
                $absenBuilder->where('user_kantor_id', $kantor);
            }
        } else {
            $absenBuilder->where('user_kantor_id', $session['adminKantor']);
        }
        $absenBuilder->join('user', 'user_nik = absen_nik');
        $absenBuilder->join('jabatan', 'user_jabatan_id = jabatan_id');
        $absenBuilder->orderBy('absen_datetime', 'DESC');
        $absen = $absenBuilder->get();

        $data = [
            'absen_arr' => $absen->getResultArray()
        ];

        echo view('Admin/Absen/export', $data);
    }
}