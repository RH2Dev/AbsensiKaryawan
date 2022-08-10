<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AbsenModel;

class Absen extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->absenModel = new AbsenModel();
    }

    public function absen()
    {
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Absensi',
            'absen' => $this->absenModel->join('user', 'user.nik = data_absen.nik')->orderBy('tanggal', 'DESC')->paginate(10, 'absen'),
            'pager' => $this->absenModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/Absen/absen', $data);
    }

    public function detail($id)
    {
        
        $db = \Config\Database::connect();
        $builder = $db->table('data_absen');
        $builder->join('user', 'user.nik = data_absen.nik');
        $builder->join('jabatan', 'user.jabatan_id = jabatan.uid');
        $builder->select('data_absen.*');
        $builder->select('user.*');
        $builder->select('jabatan.nama_jabatan');
        $builder->where('absen_id', $id);
        $absen = $builder->get();
        $data = [
            'title' => 'Absensi',
            'absen' => $absen->getResultArray()
        ];

        
        echo view('Admin/Absen/detailAbsen', $data);
    }

    public function formInsert()
    {
        
        $data = [
            'title' => 'Tambah Data Absen',
            'validation' => \Config\Services::validation()
        ];

        echo view('Admin/Absen/formInsert', $data);
    }

    public function insert()
    {

        $today = date('Y-m-d');  
        $db = \Config\Database::connect();
        // NIK Validation
        $nik = $this->userModel->getUserByNIK($this->request->getVar('nik'));
        // Ambil data absen user hari ini
        $builder = $db->table('data_absen');
        $builder->like('tanggal', $today);
        $builder->where('nik', $this->request->getVar('nik'));
        $absen = $builder->get();
        $checkin = $absen->getResultArray();
        // Ambil data checkout user hari ini
        $builder = $db->table('data_absen');
        $builder->like('checkout', $today);
        $builder->where('nik', $this->request->getVar('nik'));
        $absen = $builder->get();
        $checkout = $absen->getResultArray();

        // cek apakah NIK Tersedia
        if (!empty($nik)) {
            // Cek apakah user sudah checkin & checkout
            if (!empty($checkin) && !empty($checkout)) {
                session()->setFlashdata('pesan', 'Anda Sudah Absen Hari ini');
                return redirect()->back();
            }

            // Convert raw image data to file
            $image = $this->request->getVar('photo');
            $imageData = str_replace('data:image/webp;base64,', '', $image);
            $file = base64_decode($imageData, true);
            $fileName = uniqid('', true).'-'.$this->request->getVar('nik').'.jpg';

            // Jika user sudah absen, maka absensi dianggap checkout
            if (!empty($checkin)) {

                $this->absenModel->save([
                    'absen_id' => $checkin[0]['absen_id'],
                    'photoCheckout' => $fileName,
                    'latCheckout' => $this->request->getVar('latitude'),
                    'longCheckout' => $this->request->getVar('longitude'),
                    'checkout' => date('Y-m-d H:i:s')
                ]);

                file_put_contents(FCPATH . 'img/' .$fileName, $file);
    
                session()->setFlashdata('pesan', 'Berhasil Checkout');
                return redirect()->to('Admin/Absensi/formInsert');
            }

            $data = [
                'nik' => $this->request->getVar('nik'),
                'photo' => $fileName,
                'latitude' => $this->request->getVar('latitude'),
                'longitude' => $this->request->getVar('longitude'),
                'tanggal' => date('Y-m-d H:i:s')
            ];

            // insert input to database
            if($this->absenModel->save($data) === true) {
            // insert file to img folder
                file_put_contents(FCPATH . 'img/' .$fileName, $file);

                session()->setFlashdata('pesan', 'Berhasil absen');
                return redirect()->to('Admin/Absensi/formInsert');
            };

            return redirect()->back()->withInput();

        } else {
            session()->setFlashdata('pesan', 'NIK tidak terdaftar');
            return redirect()->back()->withInput();
        }
    }

    public function export()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('data_absen');
        $builder->join('user', 'user.nik = data_absen.nik');
        $builder->join('jabatan', 'user.jabatan_id = jabatan.uid');
        $builder->select('data_absen.*');
        $builder->select('user.*');
        $builder->select('jabatan.nama_jabatan');
        $absen = $builder->get();

        $data = [
            'absen' => $absen->getResultArray()
        ];

        echo view('Admin/Absen/export', $data);
    }

    public function search() 
    {
        $search = $this->request->getVar('search');
        $currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
        $data = [
            'title' => 'Karyawan',
            'absen' => $this->absenModel->join('user', 'user.nik = data_absen.nik')->join('jabatan', 'user.jabatan_id = jabatan.uid')->like('user.name', $search)->orWhere('data_absen.nik', $search)->orderBy('tanggal', 'DESC')->paginate(10, 'absen'),
            'pager' => $this->absenModel->pager,
            'currentPage' => $currentPage
        ];

        // echo '<pre>'; print_r($data['absen']); die;

        echo view('Admin/Absen/search', $data);
    }
}