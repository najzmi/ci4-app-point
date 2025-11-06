<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    protected $data;
    protected $menuActive;
    protected $pdnUrl;
    protected $pdnTitle;
    protected $folderName;

    public function __construct()
    {
        $this->data       = [];
        $this->menuActive = 'menudashboard';
        $this->pdnUrl     = 'dashboard';
        $this->pdnTitle   = 'Dashboard';
        $this->folderName = 'home';
    }

    public function index(): string
    {
        $this->data['pdn_title']            = $this->pdnTitle;
        $this->data['pdn_url']              = $this->pdnUrl;
        $this->data[$this->menuActive ]     = 'active';

        // Tampilkan Views
        return view($this->folderName.'/dashboard', $this->data);
    }
}
