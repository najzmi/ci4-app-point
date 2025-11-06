<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PelanggaranModel;

class PelanggaranController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $pdnTitle;
    protected $folderName;
    protected $mainModel;

    public function __construct()
    {
        $this->data         = [];
        $this->menuActive   = 'menupelanggaran';
        $this->pdnTitle     = 'Pelanggaran';
        $this->urlName      = 'pelanggaran';
        $this->folderName   = 'pelanggaran';
        $this->mainModel    = new PelanggaranModel();
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

        $this->data['pelanggaran_nama'] = [
            'name'    => 'pelanggaran_nama',
            'id'      => 'pelanggaran_nama',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('pelanggaran_nama'),
        ];
        $this->data['pelanggaran_point'] = [
            'name'    => 'pelanggaran_point',
            'id'      => 'pelanggaran_point',
            'type'    => 'number',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('pelanggaran_point'),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Tambahnya
            return view($this->folderName.'/tambah', $this->data);
        }else{
            // Prosess POST Simpan data
            $rules = [
                'pelanggaran_nama' => [
                    'label'  => 'Nama Pelanggaran',
                    'rules'  => 'required|min_length[3]|max_length[128]',
                    'errors' => [
                        'required'    => 'Nama Pelanggaran tidak boleh kosong.',
                        'min_length'  => 'Nama Pelanggaran terlalu pendek.',
                        'max_length'  => 'Nama Pelanggaran terlalu panjang.',
                    ]
                ],
                'pelanggaran_point' => [
                    'label'  => 'Point Pelanggaran',
                    'rules'  => 'trim|required|min_length[1]|max_length[32]',
                    'errors' => [
                        'required'    => 'Point Pelanggaran tidak boleh kosong.',
                        'min_length'  => 'Point Pelanggaran terlalu pendek.',
                        'max_length'  => 'Point Pelanggaran terlalu panjang.',
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
                    'pelanggaran_nama'        => $this->request->getPost('pelanggaran_nama'),
                    'pelanggaran_point'       => $this->request->getPost('pelanggaran_point')
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

        $this->data['id'] = [
            'name'    => 'id',
            'id'      => 'id',
            'type'    => 'hidden',
            'required'=> 'required',
            'value'   => $data->id
        ];

        $this->data['pelanggaran_nama'] = [
            'name'    => 'pelanggaran_nama',
            'id'      => 'pelanggaran_nama',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('pelanggaran_nama', $data->pelanggaran_nama),
        ];

        $this->data['pelanggaran_point'] = [
            'name'    => 'pelanggaran_point',
            'id'      => 'pelanggaran_point',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('pelanggaran_point', $data->pelanggaran_point),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Edit
            return view($this->folderName.'/edit', $this->data);
        }else{
            // PROSESS UPDATE DATA
            $rules = [
                'pelanggaran_nama' => [
                    'label'  => 'Pelanggaran Nama',
                    'rules'  => 'required|min_length[3]|max_length[128]|is_unique[pelanggaran.pelanggaran_nama,id,'.$this->request->getPost('id').']',
                    'errors' => [
                        'required'    => 'Nama Pelanggaran tidak boleh kosong.',
                        'min_length'  => 'Nama Pelanggaran terlalu pendek.',
                        'max_length'  => 'Nama Pelanggaran terlalu panjang.',
                        'is_unique'   => 'Nama Pelanggaran sudah terdaftar.',
                    ]
                ],
                'pelanggaran_point' => [
                    'label'  => 'Point Pelanggaran',
                    'rules'  => 'trim|required|min_length[1]|max_length[32]',
                    'errors' => [
                        'required'    => 'Point Pelanggaran tidak boleh kosong.',
                        'min_length'  => 'Point Pelanggaran terlalu pendek.',
                        'max_length'  => 'Point Pelanggaran terlalu panjang.',
                    ]
                ]
            ];

            $data_req = $this->request->getPost(array_keys($rules));

            if (! $this->validateData($data_req, $rules)) {
                // Jika Error dana Role Update
                return view($this->folderName.'/edit', $this->data);
            }else{
                // Jika tidak ada masalah, lanjut ke prosess simpan data

                $data_update = [
                    'pelanggaran_nama'        => $this->request->getPost('pelanggaran_nama'),
                    'pelanggaran_point'       => $this->request->getPost('pelanggaran_point')
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
        $table          = 'pelanggaran';
        $column_order   = ['','pelanggaran_nama', 'pelanggaran_point'];
        $column_search  = ['pelanggaran_nama', 'pelanggaran_point'];
        $order          = ['pelanggaran_nama' => 'asc'];

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
                $row[] = $pDn->pelanggaran_nama;
                $row[] = $pDn->pelanggaran_point;
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
