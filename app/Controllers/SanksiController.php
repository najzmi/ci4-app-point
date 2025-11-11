<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SanksiModel;
use App\Models\MuridModel;
use App\Models\PelanggaranModel;

class SanksiController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $pdnTitle;
    protected $folderName;
    protected $mainModel;
    protected $muridModel;
    protected $pelanggaranModel;

    public function __construct()
    {
        $this->data             = [];
        $this->menuActive       = 'menusanksi';
        $this->pdnTitle         = 'Sanksi';
        $this->urlName          = 'sanksi';
        $this->folderName       = 'sanksi';
        $this->mainModel        = new SanksiModel();
        $this->muridModel       = new MuridModel();
        $this->pelanggaranModel = new PelanggaranModel();
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
        $dataMurid          = $this->muridModel->select('id, murid_nis, murid_nama')->findAll();
        $dataPelanggaran    = $this->pelanggaranModel->select('id, pelanggaran_nama, pelanggaran_point')->findAll();

        $resMurid = [];
        if (is_array($dataMurid) || is_object($dataMurid)) {
            foreach ($dataMurid as $row){
                $resMurid[$row->id] = $row->murid_nis.' - '.$row->murid_nama;
            }
        }
        $this->data['id_murid'] = form_dropdown('id_murid' ,$resMurid, '', ['id'=>'id_murid', 'class'=>'form-control']);

        $resPelanggaran = [];
        if (is_array($dataPelanggaran) || is_object($dataPelanggaran)) {
            foreach ($dataPelanggaran as $row){
                $resPelanggaran[$row->id] = $row->pelanggaran_nama.' - ( '.$row->pelanggaran_point.' )';
            }
        }
        $this->data['id_pelanggaran'] = form_dropdown('id_pelanggaran' ,$resPelanggaran, '', ['id'=>'id_pelanggaran', 'class'=>'form-control']);

        $this->data['tanggal'] = [
            'name'    => 'tanggal',
            'id'      => 'tanggal',
            'type'    => 'date',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => date('Y-m-d'),
        ];
        $this->data['nama_pelapor'] = [
            'name'    => 'nama_pelapor',
            'id'      => 'nama_pelapor',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('nama_pelapor'),
        ];
        $this->data['catatan'] = form_textarea([
            'name'        => 'catatan',
            'id'          => 'catatan',
            'rows'        => '5',
            'cols'        => '10',
            'class'       => 'form-control',
            'value'       => set_value('catatan'),
        ]);

        if (! $this->request->is('post')) {
            // Tampilkan Form Tambahnya
            return view($this->folderName.'/tambah', $this->data);
        }else{
            // Prosess POST Simpan data
            $rules = [
                'id_murid' => [
                    'label'  => 'ID Murid',
                    'rules'  => 'trim|required',
                    'errors' => [
                        'required'    => 'ID Murid tidak boleh kosong.',
                    ]
                ],
                'id_pelanggaran' => [
                    'label'  => 'ID Pelanggaran',
                    'rules'  => 'trim|required',
                    'errors' => [
                        'required'    => 'ID Pelanggaran tidak boleh kosong.',
                    ]
                ],
                'tanggal' => [
                    'label'  => 'Tanggal',
                    'rules'  => 'required|min_length[1]|max_length[32]',
                    'errors' => [
                        'required'    => 'Tanggal tidak boleh kosong.',
                        'min_length'  => 'Tanggal terlalu pendek.',
                        'max_length'  => 'Tanggal terlalu panjang.',
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
                    'id_murid'        => $this->request->getPost('id_murid'),
                    'id_pelanggaran'  => $this->request->getPost('id_pelanggaran'),
                    'tanggal'         => $this->request->getPost('tanggal'),
                    'nama_pelapor'    => $this->request->getPost('nama_pelapor'),
                    'catatan'         => $this->request->getPost('catatan')
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
        $dataMurid          = $this->muridModel->select('id, murid_nis, murid_nama')->findAll();
        $dataPelanggaran    = $this->pelanggaranModel->select('id, pelanggaran_nama, pelanggaran_point')->findAll();

        $resMurid = [];
        if (is_array($dataMurid) || is_object($dataMurid)) {
            foreach ($dataMurid as $row){
                $resMurid[$row->id] = $row->murid_nis.' - '.$row->murid_nama;
            }
        }
        $this->data['id_murid'] = form_dropdown('id_murid' ,$resMurid, $data->id_murid, ['id'=>'id_murid', 'class'=>'form-control']);

        $resPelanggaran = [];
        if (is_array($dataPelanggaran) || is_object($dataPelanggaran)) {
            foreach ($dataPelanggaran as $row){
                $resPelanggaran[$row->id] = $row->pelanggaran_nama.' - ( '.$row->pelanggaran_point.' )';
            }
        }
        $this->data['id_pelanggaran'] = form_dropdown('id_pelanggaran' ,$resPelanggaran, $data->id_pelanggaran, ['id'=>'id_pelanggaran', 'class'=>'form-control']);

        $this->data['id'] = [
            'name'    => 'id',
            'id'      => 'id',
            'type'    => 'hidden',
            'required'=> 'required',
            'value'   => $data->id
        ];

        $this->data['tanggal'] = [
            'name'    => 'tanggal',
            'id'      => 'tanggal',
            'type'    => 'date',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('tanggal', $data->tanggal),
        ];

        $this->data['nama_pelapor'] = [
            'name'    => 'nama_pelapor',
            'id'      => 'nama_pelapor',
            'type'    => 'text',
            'class'   => 'form-control',
            'value'   => set_value('nama_pelapor', $data->nama_pelapor),
        ];

        $this->data['catatan'] = form_textarea([
            'name'        => 'catatan',
            'id'          => 'catatan',
            'rows'        => '5',
            'cols'        => '10',
            'class'       => 'form-control',
            'value'       => set_value('catatan', $data->catatan),
        ]);

        if (! $this->request->is('post')) {
            // Tampilkan Form Edit
            return view($this->folderName.'/edit', $this->data);
        }else{
            // PROSESS UPDATE DATA
            $rules = [
                'id_murid' => [
                    'label'  => 'ID Murid',
                    'rules'  => 'trim|required',
                    'errors' => [
                        'required'    => 'ID Murid tidak boleh kosong.',
                    ]
                ],
                'id_pelanggaran' => [
                    'label'  => 'ID Pelanggaran',
                    'rules'  => 'trim|required',
                    'errors' => [
                        'required'    => 'ID Pelanggaran tidak boleh kosong.',
                    ]
                ],
                'tanggal' => [
                    'label'  => 'Tanggal',
                    'rules'  => 'required|min_length[1]|max_length[32]',
                    'errors' => [
                        'required'    => 'Tanggal tidak boleh kosong.',
                        'min_length'  => 'Tanggal terlalu pendek.',
                        'max_length'  => 'Tanggal terlalu panjang.',
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
                    'id_murid'        => $this->request->getPost('id_murid'),
                    'id_pelanggaran'  => $this->request->getPost('id_pelanggaran'),
                    'tanggal'         => $this->request->getPost('tanggal'),
                    'nama_pelapor'    => $this->request->getPost('nama_pelapor'),
                    'catatan'         => $this->request->getPost('catatan')
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
        $table          = 'v_sanksi';
        $column_order   = ['','tanggal','murid_nis', 'murid_nama','kelas_nama','pelanggaran_nama','pelanggaran_point'];
        $column_search  = ['tanggal','murid_nis', 'murid_nama','pelanggaran_nama','pelanggaran_point','kelas_nama','kelas_subnama'];
        $order          = ['tanggal' => 'desc'];

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
                $row[] = pdn_tgl_default($pDn->tanggal);
                $row[] = $pDn->murid_nis;
                $row[] = $pDn->murid_nama;
                $row[] = $pDn->kelas_nama.' - '.$pDn->kelas_subnama;
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
