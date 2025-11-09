<?php

namespace App\Models;

use CodeIgniter\Model;

class RemisiModel extends Model
{
    protected $table            = 'remisi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_murid','tanggal', 'jml_remisi', 'keterangan','active'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Hitung Jumlah Remisi
     */
    public function jmlRemisi($id_murid)
    {
        return $this->selectSum('remisi.jml_remisi', 'total_remisi')
            ->where('remisi.id_murid', $id_murid)
            ->first()->total_remisi ?? 0;
    }
}
