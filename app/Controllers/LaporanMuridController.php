<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LaporanMuridModel;

class LaporanMuridController extends BaseController
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
        $this->menuActive       = 'menulaporanmurid';
        $this->subMenuActive    = 'menu_data_laporan';
        $this->pdnTitle         = 'Laporan Murid';
        $this->urlName          = 'laporanmurid';
        $this->folderName       = 'laporanmurid';
        $this->mainModel        = new LaporanMuridModel();
    }

    public function index()
    {
        $this->data['pdn_title']            = 'Data '.$this->pdnTitle;
        $this->data['pdn_url']              = $this->urlName;
        $this->data[$this->menuActive]      = 'active';
        $this->data[$this->subMenuActive]   = ['active','show'];
        return view($this->folderName.'/content', $this->data);
    }

    public function cetak($id)
    {
        if ($id === null) {
        // Redirect atau tampilkan error
        return redirect()->to($this->urlName)->with('error', 'ID tidak ditemukan');
        }

        $this->data['pdn_title']            = 'Data '.$this->pdnTitle;
        $this->data['pdn_url']              = $this->urlName;
        $this->data[$this->menuActive]      = 'active';
        $this->data[$this->subMenuActive]   = ['active','show'];

        $this->data['pdn_rowMurid']         = $this->mainModel->getMuridRow($id);
        $this->data['pdn_dataSanksi']       = $this->mainModel->getSaksiResult($id);
        $this->data['pdn_jmlPoint']         = $this->mainModel->getJmlPoint($id);
        $this->data['pdn_dataRemisi']       = $this->mainModel->getRemisiResult($id);
        $this->data['pdn_jmlRemisi']        = $this->mainModel->getJmlRemisi($id);
        $this->data['pdn_totalPoint']       = $this->data['pdn_jmlPoint'] - $this->data['pdn_jmlRemisi']; // Point dikurangi Remisi

        return view($this->folderName.'/cetak', $this->data);
    }

    // JOSN DATATBLES
    public function data_json()
    {
        $request = \Config\Services::request();

        // Konfigurasi datatables (fleksibel)
        $table          = 'v_murid';
        $column_order   = ['','murid_nis', 'murid_nama','kelas_nama'];
        $column_search  = ['murid_nis', 'murid_nama','kelas_nama','kelas_subnama'];
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
