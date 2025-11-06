<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MapelModel;

class MapelController extends BaseController
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
        $this->menuActive   = 'menumapel';
        $this->pdnTitle     = 'Mapel';
        $this->urlName      = 'mapel';
        $this->folderName   = 'mapel';
        $this->mainModel    = new MapelModel();
    }

    public function index()
    {
        $this->data['pdn_title']         = 'Data Mapel';
        $this->data['pdn_url']           = $this->urlName;
        $this->data[$this->menuActive]   = 'active';
        return view($this->folderName.'/content', $this->data);
    }
    // SIMPAN DATA
    public function tambah()
    {
        helper('form');
        $this->data['pdn_title']         = 'Data Mapel';
        $this->data['pdn_url']           = $this->urlName;
        $this->data[$this->menuActive]   = 'active';

        $this->data['mapel_nama'] = [
            'name'    => 'mapel_nama',
            'id'      => 'mapel_nama',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('mapel_nama'),
        ];
        $this->data['mapel_keterangan'] = [
            'name'    => 'mapel_keterangan',
            'id'      => 'mapel_keterangan',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('mapel_keterangan'),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Tambahnya
            return view($this->folderName.'/tambah', $this->data);
        }else{
            // Prosess POST Simpan data
            $rules = [
                'mapel_nama' => [
                    'label'  => 'Nama Mapel',
                    'rules'  => 'required|min_length[3]|max_length[128]',
                    'errors' => [
                        'required'    => 'Nama Mapel tidak boleh kosong.',
                        'min_length'  => 'Nama Mapel terlalu pendek.',
                        'max_length'  => 'Nama Mapel terlalu panjang.',
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
                    'mapel_nama'        => $this->request->getPost('mapel_nama'),
                    'keterangan'        => $this->request->getPost('mapel_keterangan')
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

        $this->data['mapel_nama'] = [
            'name'    => 'mapel_nama',
            'id'      => 'mapel_nama',
            'type'    => 'text',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('mapel_nama', $data->mapel_nama),
        ];

        $this->data['mapel_keterangan'] = [
            'name'    => 'mapel_keterangan',
            'id'      => 'mapel_keterangan',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('mapel_keterangan', $data->keterangan),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Edit
            return view($this->folderName.'/edit', $this->data);
        }else{
            // PROSESS UPDATE DATA
            $rules = [
                'mapel_nama' => [
                    'label'  => 'Nama Mapel',
                    'rules'  => 'required|min_length[3]|max_length[128]|is_unique[mapel.mapel_nama,id,'.$this->request->getPost('id').']',
                    'errors' => [
                        'required'    => 'Nama Mapel tidak boleh kosong.',
                        'min_length'  => 'Nama Mapel terlalu pendek.',
                        'max_length'  => 'Nama Mapel terlalu panjang.',
                        'is_unique'   => 'Nama Mapel sudah terdaftar.',
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
                    'mapel_nama'        => $this->request->getPost('mapel_nama'),
                    'keterangan'        => $this->request->getPost('mapel_keterangan')
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
        $table          = 'mapel';
        $column_order   = ['','mapel_nama', 'keterangan'];
        $column_search  = ['mapel_nama', 'keterangan'];
        $order          = ['mapel_nama' => 'asc'];

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
                $row[] = $pDn->mapel_nama;
                $row[] = $pDn->keterangan;
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
