<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LaporanKelasModel;

class LaporanKelasController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $subMenuActive;
    protected $pdnTitle;
    protected $folderName;
    protected $mainModel;

    public function __construct()
    {
        $this->data             = [];
        $this->menuActive       = 'menulaporankelas';
        $this->subMenuActive    = 'menu_data_laporan';
        $this->pdnTitle         = 'Laporan Kelas';
        $this->urlName          = 'laporankelas';
        $this->folderName       = 'laporankelas';
        $this->mainModel        = new LaporanKelasModel();
    }

    public function index()
    {
        $this->data['pdn_title']            = 'Data '.$this->pdnTitle;
        $this->data['pdn_url']              = $this->urlName;
        $this->data[$this->menuActive]      = 'active';
        $this->data[$this->subMenuActive]   = ['active','show'];
        return view($this->folderName.'/content', $this->data);
    }

    function cetak($id){
        if ($id === null) {
            // Redirect atau tampilkan error
            return redirect()->to($this->urlName)->with('error', 'ID tidak ditemukan');
        }

        $this->data['pdn_title']            = 'Data '.$this->pdnTitle;
        $this->data['pdn_url']              = $this->urlName;
        $this->data[$this->menuActive]      = 'active';
        $this->data[$this->subMenuActive]   = ['active','show'];

        $this->data['dataMurid'] = $this->mainModel->getMuridResult($id);

        // Tampilkan Viewsnya
        return view($this->folderName.'/cetak', $this->data);
    }

    function hitung_point($idMurid){
        if(empty($idMurid)){
            return 'Kesalahan';
        }

        // Panggil Point Murid
        $jmlPoint = $this->mainModel->getJmlPointMurid($idMurid);
        //Jml Remisi
        $jmlRemisi = $this->mainModel->getJmlRemisMurid($idMurid);

        $hasil = $jmlPoint - $jmlRemisi;
        return $hasil;
    }

    // JOSN DATATBLES
    public function data_json()
    {
        $request = \Config\Services::request();

        // Konfigurasi datatables (fleksibel)
        $table          = 'kelas';
        $column_order   = ['','kelas_nama'];
        $column_search  = ['kelas_nama'];
        $order          = ['kelas_nama' => 'asc'];

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
                $row[] = $pDn->kelas_nama.' - '.$pDn->kelas_subnama;
                $row[] = '
                    <a href="'.$this->urlName.'/cetak/'.$pDn->id.'" class="btn btn-sm btn-success shadow-sm" title="Cetak" target="_blank">
                        <i class="fas fa-print"></i> Cetak
                    </a>
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
