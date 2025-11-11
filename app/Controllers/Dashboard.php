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

    public function index(): string
    {
        $this->data['pdn_title']            = $this->pdnTitle;
        $this->data['pdn_url']              = $this->pdnUrl;
        $this->data[$this->menuActive ]     = 'active';

        $this->data['pdn_jml_kelas']        = $this->mainModel->getCountKelas();
        $this->data['pdn_jml_pelanggaran']  = $this->mainModel->getCountPelanggaran();
        $this->data['pdn_jml_murid']        = $this->mainModel->getCountMurid();

        // Tampilkan Views
        return view($this->folderName.'/dashboard', $this->data);
    }
}
