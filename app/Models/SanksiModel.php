<?php

namespace App\Models;

use CodeIgniter\Model;

class SanksiModel extends Model
{
    protected $table            = 'sanksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_murid','id_pelanggaran', 'file_foto', 'tanggal', 'nama_pelapor', 'catatan','active'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // CUSTOMAN
    protected $tbViewSanksi = 'v_sanksi';

    /**
     * Hitung Jumlah Point
     */
    public function jmlPoint($id_murid)
    {
        return $this->selectSum('pelanggaran.pelanggaran_point', 'total_point')
            ->join('murid', 'murid.id = sanksi.id_murid')
            ->join('pelanggaran', 'pelanggaran.id = sanksi.id_pelanggaran')
            ->where('sanksi.id_murid', $id_murid)
            ->first()->total_point ?? 0;
    }
    /**
     * Hitung Jumlah Point Untuk Diremisi
     */
    public function JmlPointUntukRemisi($id_murid, $tgl_end)
    {
        // Mundur 1 tahun 3 bulan dari tanggal sekarang
        $tgl_start = date('Y-m-d', strtotime('-1 year -3 months'));
    
        return $this->selectSum('pelanggaran.pelanggaran_point', 'total_point')
            ->join('murid', 'murid.id = sanksi.id_murid')
            ->join('pelanggaran', 'pelanggaran.id = sanksi.id_pelanggaran')
            ->where('sanksi.id_murid', $id_murid)
            ->where('sanksi.tanggal >=', $tgl_start)
            ->where('sanksi.tanggal <=', $tgl_end)
            ->first()->total_point ?? 0;
    }

    function getDataBerkas($idSanksi){
        if (empty($idSanksi)) {
            throw new \InvalidArgumentException('ID Sanksi harus diisi.');
        }

        return $this->db->table($this->tbViewSanksi)
            ->where('id', $idSanksi)
            ->get()
            ->getRowArray();
    }
}
