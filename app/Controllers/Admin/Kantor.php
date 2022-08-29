<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KantorModel;
use App\Models\UserModel;
use App\Models\AuthModel;
use App\Models\IzinModel;
use App\Models\AbsenModel;
class Kantor extends BaseController
{
    protected $kantorModel;
    protected $absenModel;
    protected $userModel;
    protected $authModel;
    protected $izinModel;
    public function __construct()
    {
        $this->kantorModel = new KantorModel();
        $this->absenModel = new AbsenModel();
        $this->userModel = new UserModel();
        $this->authModel = new AuthModel();
        $this->izinModel = new IzinModel();
    }

    public function index()
    {
        $search = $this->request->getVar('search');

        if (!empty($search)) {
            $kantor_arr = $this->kantorModel->like('kantor_name', $search)->orLike('kantor_alamat', $search)->orderBy('kantor_name', 'ASC')->paginate(10, 'kantor');
        } else {
            $kantor_arr =  $this->kantorModel->orderBy('kantor_name', 'ASC')->paginate(10, 'kantor');
        }

        
        $currentPage = $this->request->getVar('page_kantor') ? $this->request->getVar('page_kantor') : 1;
        $data = [
            'title' => 'Kantor',
            'menu' => 'kantor',
            'kantor_arr' => $kantor_arr,
            'searchInput' => $search,
            'pager' => $this->kantorModel->pager,
            'currentPage' => $currentPage
        ];

        echo view('Admin/Kantor/kantor', $data);
    }

    public function formInsert()
    {
        $data = [
            'title' => 'Kantor Form Insert',
            'menu' => 'kantor',
            'validation' => \Config\Services::validation()
        ];

        
        echo view('Admin/Kantor/formInsert', $data);
    }

    public function insert()
    {
        // Validation
        if(!$this->validate([
            'name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama Kantor harus diisi gan',
                    'max_length' => 'Nama Kantor tidak boleh melebihi 100 huruf'
                ]
            ],
            'alamat' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Alamat wajib diisi gan',
                    'max_length' => 'Alamat Kantor tidak boleh melebihi 255 huruf'
                ]
            ],
            'latitude' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'Alamat Latitude wajib diisi gan',
                    'max_length' => 'Alamat Kantor Latitude tidak boleh melebihi 20 huruf'
                ]
            ],
            'longitude' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'Alamat Latitude wajib diisi gan',
                    'max_length' => 'Alamat Kantor Longitude tidak boleh melebihi 20 huruf'
                ]
            ],
            'radius' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Radius Kantor wajib diisi gan',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $this->kantorModel->save([
            'kantor_name' => $this->request->getVar('name'),
            'kantor_alamat' => $this->request->getVar('alamat'),
            'kantor_latitude' => $this->request->getVar('latitude'),
            'kantor_longitude' => $this->request->getVar('longitude'),
            'kantor_radius' => $this->request->getVar('radius')
        ]);
        
        session()->setFlashdata('pesan', 'Data kantor berhasil ditambahkan');
        return redirect()->to('/Admin/Kantor');
    }

    public function formUpdate($id)
    {
        $data = [
            'title' => 'Kantor Form Insert',
            'menu' => 'kantor',
            'kantor_arr' => $this->kantorModel->where('kantor_id', $id)->first(),
            'validation' => \Config\Services::validation()
        ];

        
        echo view('Admin/Kantor/formUpdate', $data);
    }

    public function update()
    {
        // Validation
        if(!$this->validate([
            'name' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama Kantor harus diisi gan',
                    'max_length' => 'Nama Kantor tidak boleh melebihi 100 huruf'
                ]
            ],
            'alamat' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Alamat wajib diisi gan',
                    'max_length' => 'Alamat Kantor tidak boleh melebihi 255 huruf'
                ]
            ],
            'latitude' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'Alamat Latitude wajib diisi gan',
                    'max_length' => 'Alamat Kantor Latitude tidak boleh melebihi 20 huruf'
                ]
            ],
            'longitude' => [
                'rules' => 'required|max_length[20]',
                'errors' => [
                    'required' => 'Alamat Latitude wajib diisi gan',
                    'max_length' => 'Alamat Kantor Longitude tidak boleh melebihi 20 huruf'
                ]
            ],
            'radius' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Radius Kantor wajib diisi gan',
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $this->kantorModel->save([
            'kantor_id' => $this->request->getVar('id'),
            'kantor_name' => $this->request->getVar('name'),
            'kantor_alamat' => $this->request->getVar('alamat'),
            'kantor_latitude' => $this->request->getVar('latitude'),
            'kantor_longitude' => $this->request->getVar('longitude'),
            'kantor_radius' => $this->request->getVar('radius')
        ]);
        
        session()->setFlashdata('pesan', 'Data kantor berhasil diupdate');
        return redirect()->to('/Admin/Kantor');
    }

    public function delete($id)
    {
        $user_arr = $this->userModel->where('user_kantor_id', $id)->get()->getResultArray();
        foreach($user_arr as $user) {
            $this->userModel->delete('user_nik', $user['user_nik']);

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
        }
        
        $this->kantorModel->delete($id);
        session()->setFlashdata('pesan', 'Data kantor sudah terhapus');
        return redirect()->to('/Admin/Kantor');
    }

    public function export ()
    {
        $data = [
            'title' => 'Kantor',
            'menu' => 'kantor',
            'kantor_arr' => $this->kantorModel->findAll()
        ];

        echo view('Admin/Kantor/export', $data);
    }
}