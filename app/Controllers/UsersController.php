<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Datatables;
use Config\Services;

class UsersController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $pdnTitle;
    protected $folderName;

    public function __construct()
    {
        $this->data         = [];
        $this->menuActive   = 'menuusers';
        $this->pdnTitle     = 'User';
        $this->urlName      = 'users';
        $this->folderName   = 'users';
    }

    public function index()
    {
        $this->data['pdn_title']         = 'Data User';
        $this->data[$this->menuActive]   = 'active';
        return view('users/content', $this->data);
    }
    // SIMPAN DATA
    public function tambah()
    {
        helper('form');
        $this->data['pdn_title']         = 'Data User';
        $this->data[$this->menuActive]   = 'active';

        $this->data['first_name'] = [
            'name'    => 'first_name',
            'id'      => 'first_name',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('first_name'),
        ];
        $this->data['last_name'] = [
            'name'    => 'last_name',
            'id'      => 'last_name',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('last_name'),
        ];
        $this->data['email'] = [
            'name'    => 'email',
            'id'      => 'email',
            'type'    => 'email',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('email'),
        ];

        $this->data['users_level'] = form_dropdown(
            'users_level',
            ['Admin' => 'Admin','Guest' => 'Guest'],
            '',
            ['class' => 'form-control', 'id' => 'users_level']
        );

        $this->data['password'] = [
            'name'    => 'password',
            'id'      => 'password',
            'type'    => 'password',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('password'),
        ];
        $this->data['password1'] = [
            'name'    => 'password1',
            'id'      => 'password1',
            'type'    => 'password',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('password1'),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Tambahnya
            return view($this->folderName.'/tambah', $this->data);
        }else{
            // Prosess POST Simpan data
            $rules = [
                'first_name' => [
                    'label'  => 'Nama Depan',
                    'rules'  => 'required|min_length[3]|max_length[128]',
                    'errors' => [
                        'required'    => 'Nama Depan tidak boleh kosong.',
                        'min_length'  => 'Nama Depan terlalu pendek.',
                        'max_length'  => 'Nama Depan terlalu panjang.',
                    ]
                ],
                'email' => [
                    'label'  => 'Email',
                    'rules'  => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required'    => 'Email harus diisi.',
                        'valid_email' => 'Format email tidak valid.',
                        'is_unique'   => 'Email sudah terdaftar.',
                    ]
                ],
                'password' => [
                    'label'  => 'Password',
                    'rules'  => 'required|min_length[6]|matches[password1]',
                    'errors' => [
                        'required'   => 'Password harus diisi.',
                        'min_length' => 'Password terlalu pendek!',
                        'matches'    => 'Password tidak cocok!',
                    ]
                ],
                'password1' => [
                    'label'  => 'Konfirmasi Password',
                    'rules'  => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Konfirmasi password harus diisi.',
                        'matches'  => 'Password tidak cocok dengan konfirmasi password.',
                    ]
                ],
            ];

            $data_req = $this->request->getPost(array_keys($rules));
            if (! $this->validateData($data_req, $rules)) {
                // Kembalikan dan berikan informasi errornya
                return view($this->folderName.'/tambah', $this->data);
            }else{
                // Prosess Simpan Data
                $simpan_data = [
                    'first_name'    => $this->request->getPost('first_name'),
                    'last_name'     => $this->request->getPost('last_name'),
                    'email'         => $this->request->getPost('email'),
                    'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'active'        => '1',
                    'role'          => $this->request->getPost('users_level'),
                    'token'         => bin2hex(random_bytes(16))
                ];
                // Panggil model
                $usersModel = new UsersModel();
                // Simpan Data
                $proses_simpan = $usersModel->insert($simpan_data);
                if ($proses_simpan){
                    // Prosess Simpan data berhasil
                    return redirect()->to($this->urlName)->with('success','Data berhasil disimpan.');
                }else{
                    //Simpan data tidak berhasil
                    return redirect()->to($this->urlName)->with('error','Maaf, Data tidak berhasil disimpan.');
                }
            }
        }
    }
    // EDIT DATA
    public function edit($id)
    {
        if ($id === null) {
        // Redirect atau tampilkan error
        return redirect()->to($this->urlName)->with('error', 'ID tidak ditemukan');
        }

        $model = new UsersModel();
        $data = $model->find($id);

        helper('form');
        $this->data['pdn_title']        = 'Edit '.$this->pdnTitle;
        $this->data[$this->menuActive]  = 'active';
        $this->data['update_id']        = $data->id;

        $this->data['id'] = [
            'name'    => 'id',
            'id'      => 'id',
            'type'    => 'hidden',
            'required'=> 'required',
            'value'   => $data->id
        ];

        $this->data['first_name'] = [
            'name'    => 'first_name',
            'id'      => 'first_name',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('first_name', $data->first_name),
        ];
        $this->data['last_name'] = [
            'name'    => 'last_name',
            'id'      => 'last_name',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('last_name', $data->last_name),
        ];
        $this->data['email'] = [
            'name'    => 'email',
            'id'      => 'email',
            'type'    => 'email',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('email', $data->email),
        ];

        $this->data['users_level'] = form_dropdown(
            'users_level',
            ['Admin' => 'Admin','Guest' => 'Guest'],
            $data->role,
            ['class' => 'form-control', 'id' => 'users_level']
        );

        if (! $this->request->is('post')) {
            // Tampilkan Form Edit
            return view($this->folderName.'/edit', $this->data);
        }else{
            // PROSESS UPDATE DATA
            $rules = [
                'first_name' => [
                    'label'  => 'Nama Depan',
                    'rules'  => 'required|min_length[3]|max_length[128]',
                    'errors' => [
                        'required'    => 'Nama tidak boleh kosong.',
                        'min_length'  => 'Nama terlalu pendek.',
                        'max_length'  => 'Nama terlalu panjang.',
                    ]
                ],
                'email' => [
                    'label'  => 'Email',
                    'rules'  => 'required|valid_email|is_unique[users.email,id,'.$this->request->getPost('id').']',
                    'errors' => [
                        'required'    => 'Email harus diisi.',
                        'valid_email' => 'Format email tidak valid.',
                        'is_unique'   => 'Email sudah terdaftar.',
                    ]
                ]
            ];

            $data_req = $this->request->getPost(array_keys($rules));

            if (! $this->validateData($data_req, $rules)) {
                // Jika Error dana Role Update
                return view('users/edit', $this->data);
            }else{
                // Jika tidak ada masalah, lanjut ke prosess simpan data

                $data_update = [
                    'first_name'    => $this->request->getPost('first_name'),
                    'last_name'     => $this->request->getPost('last_name'),
                    'email'         => $this->request->getPost('email'),
                    'role'          => $this->request->getPost('users_level'),
                ];
                $usersModel = new UsersModel();
                $diUpdate = $usersModel->update($this->request->getPost('id'), $data_update);
                if($diUpdate){
                    // Jika prosess Update Lancar
                    return redirect()->to($this->urlName)->with('success','Data berhasil diupdate.');
                }else{
                    // Jika Prosess Update Bermasalah
                    return redirect()->to($this->urlName)->with('error','Maaf, Data tidak berhasil diupdate.');
                }
            }
        }
        
    }
    // HAPUS DATA
    public function hapus($id)
    {
        $model = new UsersModel();
        $model->delete($id);
        return redirect()->to($this->urlName)->with('success', 'Data berhasil dihapus.');
    }
    // JOSN DATATBLES
    public function data_json()
    {
        $request = \Config\Services::request();

        // Konfigurasi datatables (fleksibel)
        $table          = 'users';
        $column_order   = ['','first_name', 'email', 'role', 'active'];
        $column_search  = ['first_name', 'email'];
        $order          = ['first_name' => 'asc'];

        $datamodel = new \App\Models\Datatables($request);
        $datamodel->setConfig($table, $column_order, $column_search, $order);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            //$no = $request->getPost('start');
            $no = $request->getPost('start') ?? 1;

            foreach ($lists as $pDn) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $pDn->first_name.' '.$pDn->last_name;
                $row[] = $pDn->email;
                $row[] = $pDn->role;
                $row[] = $pDn->active;
                $row[] = '
                    <a href="'.$this->urlName.'/edit/'.$pDn->id.'" class="btn btn-sm btn-success shadow-sm" title="Edit">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <form action="'.$this->urlName.'/hapus/'.$pDn->id.'" method="post" class="d-inline">
                        <input type="hidden" name="_method" value="DELETE">
                        '.csrf_field().'
                        <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Hapus"
                            onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                ';

                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datamodel->count_all(),
                'recordsFiltered' => $datamodel->count_filtered(),
                'data' => $data
            ];

            return $this->response->setJSON($output);
        }
    }

}
