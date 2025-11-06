<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\KelasModel;
use App\Models\MuridModel;

class MuridController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $pdnTitle;
    protected $folderName;
    protected $mainModel;
    protected $KelasModel;

    public function __construct()
    {
        $this->data         = [];
        $this->menuActive   = 'menumurid';
        $this->pdnTitle     = 'Murid';
        $this->urlName      = 'murid';
        $this->folderName   = 'murid';
        $this->mainModel    = new MuridModel();
        $this->kelasModel   = new KelasModel();
    }

    public function index()
    {
        $this->data['pdn_title']         = 'Data '.$this->pdnTitle;
        $this->data['pdn_url']           = $this->urlName;
        $this->data[$this->menuActive]   = 'active';
        return view($this->folderName.'/content', $this->data);
    }
    // SIMPAN DATA
    public function tambah()
    {
        helper('form');
        $this->data['pdn_title']         = 'Tambah Data '.$this->pdnTitle;
        $this->data['pdn_url']           = $this->urlName;
        $this->data[$this->menuActive]   = 'active';
        $dataKelas = $this->kelasModel->select('id, kelas_nama, kelas_subnama')->findAll();

        $resKelas = [];
        if (is_array($dataKelas) || is_object($dataKelas)) {
            foreach ($dataKelas as $row){
                $resKelas[$row->id] = $row->kelas_nama.' - '.$row->kelas_subnama;
            }
        }
        $this->data['id_kelas'] = form_dropdown('id_kelas',$resKelas,'',['id'=>'id_kelas', 'class'=>'form-control']);

        $this->data['murid_nis'] = [
            'name'    => 'murid_nis',
            'id'      => 'murid_nis',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('murid_nis'),
        ];
        $this->data['murid_nama'] = [
            'name'    => 'murid_nama',
            'id'      => 'murid_nama',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('murid_nama'),
        ];
        $this->data['murid_telpon'] = [
            'name'    => 'murid_telpon',
            'id'      => 'murid_telpon',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('murid_telpon'),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Tambahnya
            return view($this->folderName.'/tambah', $this->data);
        }else{
            // Prosess POST Simpan data
            $rules = [
                'id_kelas' => [
                    'label'  => 'Kelas',
                    'rules'  => 'required',
                    'errors' => [
                        'required'    => 'Kelas tidak boleh kosong.',
                    ]
                ],
                'murid_nis' => [
                    'label'  => 'NIS Murid',
                    'rules'  => 'trim|required|min_length[2]|max_length[60]|is_unique[murid.murid_nis]',
                    'errors' => [
                        'required'    => 'NIS Murid tidak boleh kosong.',
                        'min_length'  => 'NIS Murid terlalu pendek.',
                        'max_length'  => 'NIS Murid terlalu panjang.',
                        'is_unique'   => 'NIS Murid sudah terdaftar.',
                    ]
                ],
                'murid_nama' => [
                    'label'  => 'Nama Murid',
                    'rules'  => 'required|min_length[3]|max_length[128]',
                    'errors' => [
                        'required'    => 'Nama Murid tidak boleh kosong.',
                        'min_length'  => 'Nama Murid terlalu pendek.',
                        'max_length'  => 'Nama Murid terlalu panjang.',
                    ]
                ]
            ];

            $data_req = $this->request->getPost(array_keys($rules));
            if (! $this->validateData($data_req, $rules)) {
                // Kembalikan dan berikan informasi errornya
                return view($this->folderName.'/tambah', $this->data);
            }else{
                // Prosess Simpan Data
                $simpan_data = [
                    'id_kelas'        => $this->request->getPost('id_kelas'),
                    'murid_nis'       => $this->request->getPost('murid_nis'),
                    'murid_nama'      => $this->request->getPost('murid_nama'),
                    'murid_telpon'    => $this->request->getPost('murid_telpon')
                ];

                // Simpan Data
                $proses_simpan = $this->mainModel->insert($simpan_data);
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

        $data = $this->mainModel->find($id);

        helper('form');
        $this->data['pdn_title']        = 'Edit '.$this->pdnTitle;
        $this->data['pdn_url']          = $this->urlName;
        $this->data[$this->menuActive]  = 'active';
        $this->data['update_id']        = $data->id;
        $dataKelas = $this->kelasModel->select('id, kelas_nama, kelas_subnama')->findAll();

        $resKelas = [];
        if (is_array($dataKelas) || is_object($dataKelas)) {
            foreach ($dataKelas as $row){
                $resKelas[$row->id] = $row->kelas_nama.' - '.$row->kelas_subnama;
            }
        }
        $this->data['id_kelas'] = form_dropdown('id_kelas',$resKelas, $data->id_kelas, ['id'=>'id_kelas', 'class'=>'form-control']);

        $this->data['id'] = [
            'name'    => 'id',
            'id'      => 'id',
            'type'    => 'hidden',
            'required'=> 'required',
            'value'   => $data->id
        ];

        $this->data['murid_nis'] = [
            'name'    => 'murid_nis',
            'id'      => 'murid_nis',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('murid_nis', $data->murid_nis),
        ];

        $this->data['murid_nama'] = [
            'name'    => 'murid_nama',
            'id'      => 'murid_nama',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('murid_nama', $data->murid_nama),
        ];

        $this->data['murid_telpon'] = [
            'name'    => 'murid_telpon',
            'id'      => 'murid_telpon',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('murid_telpon', $data->murid_telpon),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Edit
            return view($this->folderName.'/edit', $this->data);
        }else{
            // PROSESS UPDATE DATA
            $rules = [
                'murid_nis' => [
                    'label'  => 'NIS Murid',
                    'rules'  => 'trim|required|min_length[3]|max_length[128]|is_unique[murid.murid_nis,id,'.$this->request->getPost('id').']',
                    'errors' => [
                        'required'    => 'NIS Murid tidak boleh kosong.',
                        'min_length'  => 'NIS Murid terlalu pendek.',
                        'max_length'  => 'NIS Murid terlalu panjang.',
                        'is_unique'   => 'NIS Murid sudah terdaftar.',
                    ]
                ],
                'murid_nama' => [
                    'label'  => 'Nama Murid',
                    'rules'  => 'required|min_length[3]|max_length[128]',
                    'errors' => [
                        'required'    => 'Nama Murid tidak boleh kosong.',
                        'min_length'  => 'Nama Murid terlalu pendek.',
                        'max_length'  => 'Nama Murid terlalu panjang.',
                    ]
                ]
            ];

            $data_req = $this->request->getPost(array_keys($rules));

            if (! $this->validateData($data_req, $rules)) {
                // Jika Error dan Role Update
                return view($this->folderName.'/edit', $this->data);
            }else{
                // Jika tidak ada masalah, lanjut ke prosess simpan data

                $data_update = [
                    'id_kelas'        => $this->request->getPost('id_kelas'),
                    'murid_nis'       => $this->request->getPost('murid_nis'),
                    'murid_nama'      => $this->request->getPost('murid_nama'),
                    'murid_telpon'    => $this->request->getPost('murid_telpon')
                ];

                $diUpdate = $this->mainModel->update($this->request->getPost('id'), $data_update);
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
        $this->mainModel->delete($id);
        return redirect()->to($this->urlName)->with('success', 'Data berhasil dihapus.');
    }

    // JOSN DATATBLES
    public function data_json()
    {
        $request = \Config\Services::request();

        // Konfigurasi datatables (fleksibel)
        $table          = 'v_murid';
        $column_order   = ['','murid_nis', 'murid_nama','murid_telpon','kelas_nama'];
        $column_search  = ['murid_nis', 'murid_nama','murid_telpon','kelas_nama','kelas_subnama'];
        $order          = ['murid_nama' => 'asc'];

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
                $row[] = $pDn->murid_nis;
                $row[] = $pDn->murid_nama;
                $row[] = $pDn->murid_telpon;
                $row[] = $pDn->kelas_nama.' - '.$pDn->kelas_subnama;
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
