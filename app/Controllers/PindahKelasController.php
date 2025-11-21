<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MuridModel;
use App\Models\KelasModel;

class PindahKelasController extends BaseController
{
    protected $data;
    protected $urlName;
    protected $menuActive;
    protected $pdnTitle;
    protected $folderName;
    protected $modelKelas;
    protected $modelMurid;

    public function __construct()
    {
        $this->data         = [];
        $this->menuActive   = 'menupindahkelas';
        $this->pdnTitle     = 'Pindah Kelas';
        $this->urlName      = 'pindahkelas';
        $this->folderName   = 'pindahkelas';
        $this->modelKelas   = new KelasModel();
        $this->modelMurid   = new MuridModel();
    }

    public function index()
    {
        $this->data['pdn_title']         = 'Data '.$this->pdnTitle;
        $this->data['pdn_url']           = $this->urlName;
        $this->data[$this->menuActive]   = 'active';

        // Ambil semua kelas
        $kelas = $this->modelKelas->findAll();

        // Tambahkan daftar murid untuk tiap kelas
        foreach ($kelas as &$k) {
            $k->murid = $this->modelMurid
                                ->where('id_kelas', $k->id)
                                ->findAll();
        }

        $this->data['kelas'] = $kelas;

        return view($this->folderName.'/content', $this->data);
    }

    public function proses_pindah()
    {
        $muridID = $this->request->getPost('murid_id');
        $kelasTujuan = $this->request->getPost('kelas_tujuan');

        if (!$muridID) {
            return redirect()->back()->with('error', 'Tidak ada murid yang dipilih!');
        }

        if (!$kelasTujuan) {
            return redirect()->back()->with('error', 'Kelas tujuan belum dipilih!');
        }

        // Update kelas untuk murid yang dipilih
        $this->modelMurid
            ->whereIn('id', $muridID)
            ->set(['id_kelas' => $kelasTujuan])
            ->update();

        //return redirect()->back()->with('success', 'Murid berhasil dipindahkan!');
        return redirect()->to($this->urlName)->with('success','Murid berhasil dipindahkan!.');
    }

}
