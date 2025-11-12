<?php

namespace App\Models;

use CodeIgniter\Model;

class PointLebihModel extends Model
{
    protected $DBGroup          = 'default';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false; // karena tidak ada insert/update
    protected $table            = null;  // opsional, bisa diatur dalam tiap method
    protected $tbViewMurid      = 'v_pointlebih';

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

    public function getMuridArray(){
        return $this->db->table($this->tbViewMurid)
        ->select('*')
        ->get()
        ->getResultArray();
    }


}
