<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanMuridModel extends Model
{
    protected $DBGroup          = 'default';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false; // karena tidak ada insert/update
    protected $table            = null;  // opsional, bisa diatur dalam tiap method
    protected $tbViewMurid      = 'v_murid';
    protected $tbViewSanksi     = 'v_sanksi';
    protected $tbViewRemisi     = 'v_remisi';

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

    function getMuridRow($idMurid)
    {
        if (empty($idMurid)) {
            throw new \InvalidArgumentException('ID Murid harus diisi.');
        }

        return $this->db->table($this->tbViewMurid)
            ->select('*')
            ->where('id', $idMurid)
            ->get()
            ->getRow();
    }

    function getSaksiResult($idMurid)
    {
        if (empty($idMurid)) {
            throw new \InvalidArgumentException('ID Murid harus diisi.');
        }

        return $this->db->table($this->tbViewSanksi)
            ->select('id_murid, tanggal, pelanggaran_nama, pelanggaran_point')
            ->where('id_murid', $idMurid)
            ->get()
            ->getResult();
    }

    function getJmlPoint($idMurid)
    {
        if (empty($idMurid)) {
            throw new \InvalidArgumentException('ID Murid harus diisi.');
        }
        // ubah seperti ini agar aman di semua kondisi
        $result = $this->db->table($this->tbViewSanksi)
            ->selectSum('pelanggaran_point', 'total_point')
            ->where('id_murid', $idMurid)
            ->get()
            ->getRow();

        return $result ? (int) $result->total_point : 0;
    }

    // REMISI
    function getRemisiResult($idMurid)
    {
        if (empty($idMurid)) {
            throw new \InvalidArgumentException('ID Murid harus diisi.');
        }

        return $this->db->table($this->tbViewRemisi)
            ->select('id_murid, tanggal, jml_remisi, keterangan')
            ->where('id_murid', $idMurid)
            ->get()
            ->getResult();
    }

    function getJmlRemisi($idMurid)
    {
        if (empty($idMurid)) {
            throw new \InvalidArgumentException('ID Murid harus diisi.');
        }
        // ubah seperti ini agar aman di semua kondisi
        $result = $this->db->table($this->tbViewRemisi)
            ->selectSum('jml_remisi', 'total_remisi')
            ->where('id_murid', $idMurid)
            ->get()
            ->getRow();

        return $result ? (int) $result->total_remisi : 0;
    }

}
