<?php

namespace App\Controllers;
use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    protected $data;
    protected $menuActive;
    protected $pdnUrl;
    protected $pdnTitle;
    protected $folderName;
    protected $mainModel;

    public function __construct()
    {
        $this->data       = [];
        $this->menuActive = 'menudashboard';
        $this->pdnUrl     = 'dashboard';
        $this->pdnTitle   = 'Dashboard';
        $this->folderName = 'home';
        $this->mainModel  = new DashboardModel();
    }

    public function index()
    {
        $this->data['pdn_title']            = $this->pdnTitle;
        $this->data['pdn_url']              = $this->pdnUrl;
        $this->data[$this->menuActive ]     = 'active';

        $this->data['pdn_jml_kelas']        = $this->mainModel->getCountKelas();
        $this->data['pdn_jml_pelanggaran']  = $this->mainModel->getCountPelanggaran();
        $this->data['pdn_jml_murid']        = $this->mainModel->getCountMurid();
        $this->data['pdn_grafik_kelas']     = $this->mainModel->getKelasPointSummarySQL();

       

        // Tampilkan Views
        return view($this->folderName.'/dashboard', $this->data);
    }

    public function grafik_kelas()
    {
        $pdn_data = $this->mainModel->getKelasPointSummarySQL();
        $result = [];

        if (!empty($pdn_data)) {
            foreach ($pdn_data as $pdn) {
                $result[] = [
                    'nama'     => "{$pdn['kelas_nama']} {$pdn['kelas_subnama']} ({$pdn['total_point']})",
                    'jmlpoint' => (int) $pdn['total_point']
                ];
            }
        }

        // Kembalikan JSON response (CI4 way)
        return $this->response->setJSON($result);
    }
}
