<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriTukangModel extends Model
{
    protected $table            = 'transaksi.kategori_tukang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tukang_id',
        'kategori_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules = [
        'tukang_id'   => 'required|integer',
        'kategori_id' => 'required|integer'
    ];

    protected $validationMessages = [
        'tukang_id' => [
            'required' => 'Tukang harus dipilih',
            'integer'  => 'ID Tukang tidak valid'
        ],
        'kategori_id' => [
            'required' => 'Kategori harus dipilih',
            'integer'  => 'ID Kategori tidak valid'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Assign kategori ke tukang (replace existing)
     * 
     * @param int $tukangId
     * @param array $kategoriIds
     * @return bool
     */
    public function assignKategori(int $tukangId, array $kategoriIds): bool
    {
        $db = $this->db;
        $db->transStart();

        try {
            // Delete existing categories for this tukang
            $this->where('tukang_id', $tukangId)->delete();

            // Insert new categories
            if (!empty($kategoriIds)) {
                $data = [];
                foreach ($kategoriIds as $kategoriId) {
                    $data[] = [
                        'tukang_id'   => $tukangId,
                        'kategori_id' => (int)$kategoriId,
                        'created_at'  => date('Y-m-d H:i:s')
                    ];
                }

                if (!empty($data)) {
                    $this->insertBatch($data);
                }
            }

            $db->transComplete();

            return $db->transStatus();
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error in assignKategori: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all tukang by kategori
     * 
     * @param int $kategoriId
     * @return array
     */
    public function getTukangByKategori(int $kategoriId): array
    {
        return $this->where('kategori_id', $kategoriId)->findAll();
    }

    /**
     * Get all kategori by tukang with kategori details
     * 
     * @param int $tukangId
     * @return array
     */
    public function getKategoriByTukang(int $tukangId): array
    {
        try {
            $builder = $this->db->table('transaksi.kategori_tukang kt');
            
            $builder->select('kt.kategori_id, k.nama, k.deskripsi');
            $builder->join('transaksi.kategori k', 'kt.kategori_id = k.id', 'left');
            $builder->where('kt.tukang_id', $tukangId);
            $builder->where('k.is_active', true);

            return $builder->get()->getResultArray();
        } catch (\Exception $e) {
            log_message('error', 'Error in getKategoriByTukang: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if tukang has specific kategori
     * 
     * @param int $tukangId
     * @param int $kategoriId
     * @return bool
     */
    public function hasTukangKategori(int $tukangId, int $kategoriId): bool
    {
        return $this->where([
            'tukang_id'   => $tukangId,
            'kategori_id' => $kategoriId
        ])->countAllResults() > 0;
    }

    /**
     * Get all assignments with tukang and kategori details
     * 
     * @return array
     */
    public function getAllAssignmentsWithDetails(): array
    {
        try {
            $builder = $this->db->table('transaksi.kategori_tukang kt');

            $builder->select("
                kt.id,
                kt.tukang_id,
                kt.kategori_id,
                TO_CHAR(kt.created_at, 'DD-MM-YYYY HH24:MI:SS') as created_at,
                COALESCE(u.username, 'User Tidak Ditemukan') as tukang_username,
                COALESCE(k.nama, 'Kategori Tidak Ditemukan') as kategori_nama
            ");

            // LEFT JOIN to ensure we get data even if related records are missing
            $builder->join('auth.users u', 'u.id = kt.tukang_id', 'left');
            $builder->join('transaksi.kategori k', 'k.id = kt.kategori_id', 'left');

            // Order by newest first
            $builder->orderBy('kt.created_at', 'DESC');

            $result = $builder->get()->getResultArray();

            log_message('info', 'getAllAssignmentsWithDetails returned ' . count($result) . ' records');

            return $result;

        } catch (\Exception $e) {
            log_message('error', 'Error in getAllAssignmentsWithDetails: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return [];
        }
    }

    /**
     * Get assignment detail by ID
     * 
     * @param int $id
     * @return array|null
     */
    public function getAssignmentDetail(int $id): ?array
    {
        try {
            $builder = $this->db->table('transaksi.kategori_tukang kt');

            $builder->select("
                kt.id,
                kt.tukang_id,
                kt.kategori_id,
                kt.created_at,
                u.username as tukang_username,
                u.email as tukang_email,
                k.nama as kategori_nama,
                k.deskripsi as kategori_deskripsi
            ");

            $builder->join('auth.users u', 'u.id = kt.tukang_id', 'left');
            $builder->join('transaksi.kategori k', 'k.id = kt.kategori_id', 'left');
            $builder->where('kt.id', $id);

            return $builder->get()->getRowArray();

        } catch (\Exception $e) {
            log_message('error', 'Error in getAssignmentDetail: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get total assignments for a tukang
     * 
     * @param int $tukangId
     * @return int
     */
    public function countTukangKategori(int $tukangId): int
    {
        return $this->where('tukang_id', $tukangId)->countAllResults();
    }

    /**
     * Delete all kategori for a tukang
     * 
     * @param int $tukangId
     * @return bool
     */
    public function deleteAllByTukang(int $tukangId): bool
    {
        try {
            $this->where('tukang_id', $tukangId)->delete();
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error in deleteAllByTukang: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get tukang IDs that have specific kategori
     * 
     * @param int $kategoriId
     * @return array
     */
    public function getTukangIdsHavingKategori(int $kategoriId): array
    {
        $result = $this->select('tukang_id')
            ->where('kategori_id', $kategoriId)
            ->findAll();

        return array_column($result, 'tukang_id');
    }

    /**
     * Check if assignment exists
     * 
     * @param int $tukangId
     * @param int $kategoriId
     * @return bool
     */
    public function assignmentExists(int $tukangId, int $kategoriId): bool
    {
        return $this->where([
            'tukang_id' => $tukangId,
            'kategori_id' => $kategoriId
        ])->first() !== null;
    }
}