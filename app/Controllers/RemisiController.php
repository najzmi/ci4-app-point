<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RemisiModel;
use App\Models\MuridModel;
use App\Models\SanksiModel;

class RemisiController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $pdnTitle;
    protected $folderName;
    protected $mainModel;
    protected $muridModel;
    protected $sanksiModel;

    public function __construct()
    {
        $this->data         = [];
        $this->menuActive   = 'menuremisi';
        $this->pdnTitle     = 'Remisi';
        $this->urlName      = 'remisi';
        $this->folderName   = 'remisi';
        $this->mainModel    = new RemisiModel();
        $this->muridModel   = new MuridModel();
        $this->sanksiModel  = new SanksiModel();
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
        $dataMurid = $this->muridModel->select('id, murid_nama, murid_nis')->findAll();

        $resMurid = [];
        if (is_array($dataMurid) || is_object($dataMurid)) {
            foreach ($dataMurid as $row){
                $resMurid[$row->id] = $row->murid_nama.' - '.$row->murid_nis;
            }
        }
        $this->data['id_murid'] = form_dropdown('id_murid', $resMurid, '', ['id'=>'id_murid', 'class'=>'form-control']);

        // JML REMISI
        $resRemisi = ['15'=>'Remisi 15%', '25'=>'Remisi 25%', '50'=>'Remisi 50%'];
        $this->data['jml_remisi'] = form_dropdown('jml_remisi', $resRemisi, '', ['id'=>'jml_remisi', 'class'=>'form-control']);

        $this->data['tanggal'] = [
            'name'    => 'tanggal',
            'id'      => 'tanggal',
            'type'    => 'date',
            'class'   => 'form-control',
            'required'=> 'required',
            'value'   => set_value('tanggal'),
        ];

        if (! $this->request->is('post')) {
            // Tampilkan Form Tambahnya
            return view($this->folderName.'/tambah', $this->data);
        }else{
            // Prosess POST Simpan data
            $rules = [
                'tanggal' => [
                    'label'  => 'Tanggal',
                    'rules'  => 'trim|required|min_length[2]|max_length[32]',
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
                //$jmlPoint   = $this->sanksiModel->jmlPoint($this->request->getPost('id_murid'));
                $jmlPoint       = $this->sanksiModel->JmlPointUntukRemisi($this->request->getPost('id_murid'), $this->request->getPost('tanggal')); // Jumlahkan remisi sampai tanggal yg ditentukan
                $jmlRemisi      = $this->mainModel->jmlRemisi($this->request->getPost('id_murid')); // hitung, udah ada berapa poin remisi murid tersebut
                $tempJmlPoint   = $jmlPoint - $jmlRemisi; // Point dikurangi remisi
                $remisi         = $this->request->getPost('jml_remisi'); // Digunakan untuk persentase remisi
                $nilai_remisi   =($remisi/100)*$tempJmlPoint; // Cari nilai persentase nya dari jumlah point
                $hasilRemisi    = floor($nilai_remisi); // Bulatkan kebawah

                if ($tempJmlPoint == 0){
                    // Jika data Poin nya ternyata 0
                    return redirect()->to($this->urlName)->with('error','Maaf, Data murid tidak memiliki Jumlah Point.');
                }
                // echo $jmlPoint;
                // echo '<br/>';
                // echo $jmlRemisi;
                // die();
                // Prosess Simpan Data
                $simpan_data = [
                    'id_murid'       => $this->request->getPost('id_murid'),
                    'tanggal'        => $this->request->getPost('tanggal'),
                    'jml_remisi'     => $hasilRemisi,
                    'keterangan'     => 'Sudah dilakukan remisi sebanyak '.$remisi.' %, Dari jumlah point '.$tempJmlPoint,
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
        $table          = 'v_remisi';
        $column_order   = ['','tanggal', 'murid_nis','murid_nama','kelas_nama','jml_remisi','keterangan'];
        $column_search  = ['tanggal', 'murid_nis','murid_nama','kelas_nama','kelas_subnama','keterangan','jml_remisi'];
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
                $row[] = $pDn->tanggal;
                $row[] = $pDn->murid_nis;
                $row[] = $pDn->murid_nama;
                $row[] = $pDn->kelas_nama.' '.$pDn->kelas_subnama;
                $row[] = $pDn->jml_remisi;
                $row[] = $pDn->keterangan;
                
                $row[] = '
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
