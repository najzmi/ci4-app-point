<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PindahKelasController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $pdnTitle;
    protected $folderName;

    public function __construct()
    {
        $this->data         = [];
        $this->menuActive   = 'menupindahkelas';
        $this->pdnTitle     = 'Pindah Kelas';
        $this->urlName      = 'pindahkelas';
        $this->folderName   = 'pindahkelas';
    }

    public function index()
    {
        $this->data['pdn_title']         = 'Data '.$this->pdnTitle;
        $this->data['pdn_url']           = $this->urlName;
        $this->data[$this->menuActive]   = 'active';
        return view($this->folderName.'/content', $this->data);
    }
}
