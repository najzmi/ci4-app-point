<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\GuruModel;
use App\Models\MapelModel;

class GuruController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $pdnTitle;
    protected $folderName;
    protected $mainModel;
    protected $mapelModel;

    public function __construct()
    {
        $this->data         = [];
        $this->menuActive   = 'menuguru';
        $this->pdnTitle     = 'Guru';
        $this->urlName      = 'guru';
        $this->folderName   = 'guru';
        $this->mainModel    = new GuruModel();
        $this->mapelModel   = new MapelModel();
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
        $dataMapel = $this->mapelModel->select('id, mapel_nama')->findAll();

        $resMapel = [];
        if (is_array($dataMapel) || is_object($dataMapel)) {
            foreach ($dataMapel as $row){
                $resMapel[$row->id] = $row->mapel_nama;
            }
        }
        $this->data['id_mapel'] = form_dropdown('id_mapel',$resMapel,'',['id'=>'id_mapel', 'class'=>'form-control']);

        $this->data['guru_nama'] = [
            'name'    => 'guru_nama',
            'id'      => 'guru_nama',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('guru_nama'),
        ];
        $this->data['guru_telpon'] = [
            'name'    => 'guru_telpon',
            'id'      => 'guru_telpon',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('guru_telpon'),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Tambahnya
            return view($this->folderName.'/tambah', $this->data);
        }else{
            // Prosess POST Simpan data
            $rules = [
                'guru_nama' => [
                    'label'  => 'Nama Guru',
                    'rules'  => 'required|min_length[3]|max_length[128]',
                    'errors' => [
                        'required'    => 'Nama Guru tidak boleh kosong.',
                        'min_length'  => 'Nama Guru terlalu pendek.',
                        'max_length'  => 'Nama Guru terlalu panjang.',
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
                    'id_mapel'        => $this->request->getPost('id_mapel'),
                    'guru_nama'       => $this->request->getPost('guru_nama'),
                    'guru_telpon'     => $this->request->getPost('guru_telpon')
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
        $dataMapel = $this->mapelModel->select('id, mapel_nama')->findAll();

        $resMapel = [];
        if (is_array($dataMapel) || is_object($dataMapel)) {
            foreach ($dataMapel as $row){
                $resMapel[$row->id] = $row->mapel_nama;
            }
        }
        $this->data['id_mapel'] = form_dropdown('id_mapel', $resMapel, $data->id_mapel, ['id'=>'id_mapel', 'class'=>'form-control']);

        $this->data['id'] = [
            'name'    => 'id',
            'id'      => 'id',
            'type'    => 'hidden',
            'required'=> 'required',
            'value'   => $data->id
        ];

        $this->data['guru_nama'] = [
            'name'    => 'guru_nama',
            'id'      => 'guru_nama',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('guru_nama', $data->guru_nama),
        ];

        $this->data['guru_telpon'] = [
            'name'    => 'guru_telpon',
            'id'      => 'guru_telpon',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('guru_telpon', $data->guru_telpon),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Edit
            return view($this->folderName.'/edit', $this->data);
        }else{
            // PROSESS UPDATE DATA
            $rules = [
                'guru_nama' => [
                    'label'  => 'Nama Guru',
                    'rules'  => 'required|min_length[3]|max_length[128]|is_unique[guru.guru_nama,id,'.$this->request->getPost('id').']',
                    'errors' => [
                        'required'    => 'Nama Guru tidak boleh kosong.',
                        'min_length'  => 'Nama Guru terlalu pendek.',
                        'max_length'  => 'Nama Guru terlalu panjang.',
                        'is_unique'   => 'Nama Guru sudah terdaftar.',
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
                    'id_mapel'        => $this->request->getPost('id_mapel'),
                    'guru_nama'       => $this->request->getPost('guru_nama'),
                    'guru_telpon'     => $this->request->getPost('guru_telpon')
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
        $table          = 'v_guru';
        $column_order   = ['','guru_nama', 'mapel_nama','guru_telpon'];
        $column_search  = ['guru_nama', 'mapel_nama','guru_telpon'];
        $order          = ['guru_nama' => 'asc'];

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
                $row[] = $pDn->guru_nama;
                $row[] = $pDn->mapel_nama;
                $row[] = $pDn->guru_telpon;
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
