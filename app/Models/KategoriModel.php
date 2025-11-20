<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'transaksi.kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',
        'deskripsi',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama'      => 'required|string|max_length[255]|is_unique[transaksi.kategori.nama,id,{id}]',
        'deskripsi' => 'permit_empty|string',
        'is_active' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'nama' => [
            'required'   => 'Nama kategori wajib diisi',
            'is_unique'  => 'Kategori dengan nama ini sudah ada'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get kategori aktif saja
     */
    public function getActiveCategories()
    {
        return $this->where('is_active', true)
            ->orderBy('nama', 'ASC')
            ->findAll();
    }

    /**
     * Get kategori dengan jumlah tukang
     */
    public function getKategoriWithTukangCount()
    {
        return $this->db->table($this->table . ' k')
            ->select('k.*, COUNT(kt.tukang_id) as jumlah_tukang')
            ->join('transaksi.kategori_tukang kt', 'k.id = kt.kategori_id', 'left')
            ->groupBy('k.id')
            ->orderBy('k.nama', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get kategori tukang tertentu
     */
    public function getKategoriByTukang($tukangId)
    {
        return $this->db->table($this->table . ' k')
            ->select('k.*')
            ->join('transaksi.kategori_tukang kt', 'k.id = kt.kategori_id', 'inner')
            ->where('kt.tukang_id', $tukangId)
            ->where('k.is_active', true)
            ->get()
            ->getResultArray();
    }
}
