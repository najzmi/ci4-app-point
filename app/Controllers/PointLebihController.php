<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PointLebihController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $subMenuActive;
    protected $pdnTitle;
    protected $folderName;

    public function __construct()
    {
        $this->data             = [];
        $this->menuActive       = 'menupointlebih';
        $this->subMenuActive    = 'menu_data_laporan';
        $this->pdnTitle         = 'Point Tinggi';
        $this->urlName          = 'pointlebih';
        $this->folderName       = 'pointlebih';
    }

    public function index()
    {
        $this->data['pdn_title']            = 'Data '.$this->pdnTitle;
        $this->data['pdn_url']              = $this->urlName;
        $this->data[$this->menuActive]      = 'active';
        $this->data[$this->subMenuActive]   = ['active','show'];
        return view($this->folderName.'/content', $this->data);
    }

    // JOSN DATATBLES
    public function data_json()
    {
        $request = \Config\Services::request();

        // Konfigurasi datatables (fleksibel)
        $table          = 'v_total_point';
        $column_order   = ['','murid_nis', 'murid_nama','kelas_nama','total_point'];
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
                $row[] = $pDn->total_point;

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
