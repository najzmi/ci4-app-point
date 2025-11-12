<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanKelasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false; // karena tidak ada insert/update
    protected $table            = null;  // opsional, bisa diatur dalam tiap method
    protected $tbViewMurid      = 'v_murid';
    protected $tbViewSanksi     = 'v_sanksi';
    protected $tbKelas          = 'kelas';

    // tidak ingin model ini bisa digunakan untuk save, insert, update, dan delete
    public function insert($data = null, bool $returnID = true)
    {
        throw new \RuntimeException('Model ini hanya digunakan untuk READ.');
    }
    public function update($id = null, $data = null): bool
    {
        throw new \RuntimeException('Model ini hanya digunakan untuk READ.');
    }
    public function delete($id = null, bool $purge = false)
    {
        throw new \RuntimeException('Model ini hanya digunakan untuk READ.');
    }

    function getKelas($idKelas){
        if (empty($idKelas)) {
            throw new \InvalidArgumentException('ID Murid harus diisi.');
        }

        return $this->db->table($this->tbKelas)
            ->select('id, kelas_nama, kelas_subnama')
            ->where('id', $idKelas)
            ->get()
            ->getRowArray();
    }

    public function getMuridResult($idKelas){
        if (empty($idKelas)) {
            throw new \InvalidArgumentException('ID Kelas harus diisi.');
        }

        $muridList = $this->db->table($this->tbViewMurid)
        ->select('
            id,
            murid_nis,
            murid_nama,
            murid_telpon
        ')
        ->where('id_kelas', $idKelas)
        ->get()
        ->getResultArray();

        foreach ($muridList as &$m) {
            $totalSanksi = $this->getJmlPointMurid($m['id']);
            $totalRemisi = $this->getJmlRemisiMurid($m['id']);
            $m['total_point'] = $totalSanksi - $totalRemisi;
            // $m['total_point'] =  $totalSanksi;
            // $m['total_point'] =  $totalRemisi;
        }

        return $muridList;
    }

    function getJmlPointMurid($idMurid)
    {
        if (empty($idMurid)) {
            throw new \InvalidArgumentException('ID Murid harus diisi.');
        }

        $result = $this->db->table($this->tbViewSanksi)
            ->select('IFNULL(SUM(pelanggaran_point), 0) AS total_point')
            ->where('id_murid', $idMurid)
            ->groupBy('id_murid')
            ->get()
            ->getRow();

        return $result ? (int) $result->total_point : 0;
    }

    function getJmlRemisiMurid($idMurid)
    {
        if (empty($idMurid)) {
            throw new \InvalidArgumentException('ID Murid harus diisi.');
        }

        $result = $this->db->table('remisi')
            ->select('IFNULL(SUM(jml_remisi), 0) AS total_point')
            ->where('id_murid', $idMurid)
            ->groupBy('id_murid')
            ->get()
            ->getRow();

        return $result ? (int) $result->total_point : 0;
    }
}
