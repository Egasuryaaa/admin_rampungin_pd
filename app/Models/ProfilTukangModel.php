<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilTukangModel extends Model
{
    protected $table            = 'auth.profil_tukang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'pengalaman_tahun',
        'tarif_per_jam',
        'status_ketersediaan',
        'radius_layanan_km',
        'bio',
        'keahlian',
        'rata_rata_rating',
        'total_rating',
        'total_pekerjaan_selesai',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id'              => 'required|integer|is_unique[auth.profil_tukang.user_id,id,{id}]',
        'pengalaman_tahun'     => 'permit_empty|integer|greater_than_equal_to[0]',
        'tarif_per_jam'        => 'permit_empty|decimal|greater_than_equal_to[0]',
        'status_ketersediaan'  => 'permit_empty|in_list[tersedia,sibuk,offline]',
        'radius_layanan_km'    => 'permit_empty|integer|greater_than_equal_to[1]',
        'bio'                  => 'permit_empty|string|max_length[1000]',
        'nama_bank'            => 'permit_empty|string|max_length[100]',
        'nomor_rekening'       => 'permit_empty|string|max_length[50]',
        'nama_pemilik_rekening'=> 'permit_empty|string|max_length[255]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required'   => 'User ID wajib diisi',
            'is_unique'  => 'Profil tukang untuk user ini sudah ada'
        ],
        'status_ketersediaan' => [
            'in_list' => 'Status harus tersedia, sibuk, atau offline'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['encodeKeahlian'];
    protected $beforeUpdate   = ['encodeKeahlian'];
    protected $afterFind      = ['decodeKeahlian'];

    /**
     * Encode keahlian array ke JSON sebelum insert/update
     */
    protected function encodeKeahlian(array $data)
    {
        if (isset($data['data']['keahlian']) && is_array($data['data']['keahlian'])) {
            $data['data']['keahlian'] = json_encode($data['data']['keahlian']);
        }
        return $data;
    }

    /**
     * Decode keahlian JSON ke array setelah find
     */
    protected function decodeKeahlian(array $data)
    {
        if (isset($data['data'])) {
            // Single record
            if (isset($data['data']['keahlian']) && is_string($data['data']['keahlian'])) {
                $data['data']['keahlian'] = json_decode($data['data']['keahlian'], true);
            }
        } elseif (isset($data['rows'])) {
            // Multiple records
            foreach ($data['rows'] as &$row) {
                if (isset($row['keahlian']) && is_string($row['keahlian'])) {
                    $row['keahlian'] = json_decode($row['keahlian'], true);
                }
            }
        }
        return $data;
    }

    /**
     * Get tukang dengan detail user
     */
    public function getTukangWithUser($tukangId = null)
    {
        $builder = $this->db->table($this->table . ' pt')
            ->select('pt.id, pt.user_id, pt.pengalaman_tahun, pt.tarif_per_jam, pt.status_ketersediaan, 
                     pt.radius_layanan_km, pt.bio, pt.keahlian, pt.rata_rata_rating, pt.total_rating, 
                     pt.total_pekerjaan_selesai, pt.nama_bank, pt.nomor_rekening, pt.nama_pemilik_rekening, 
                     pt.created_at, pt.updated_at, 
                     u.id as user_id_from_users, u.nama_lengkap, u.email, u.no_telp, u.foto_profil, 
                     u.alamat, u.kota, u.provinsi, u.poin, u.is_verified')
            ->join('auth.users u', 'pt.user_id = u.id', 'left');

        if ($tukangId !== null) {
            $builder->where('pt.id', $tukangId);
            $result = $builder->get()->getRowArray();
            
            // Pastikan user_id tersedia untuk query rating
            if ($result && isset($result['user_id'])) {
                $result['user_id_for_rating'] = $result['user_id'];
            }
            
            return $result;
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Get tukang berdasarkan kategori
     */
    public function getTukangByKategori($kategoriId, $filters = [])
    {
        $builder = $this->db->table($this->table . ' pt')
            ->select('pt.*, u.id as user_id, u.nama_lengkap, u.email, u.no_telp, u.foto_profil, u.kota, u.provinsi')
            ->join('auth.users u', 'pt.user_id = u.id', 'left')
            ->join('transaksi.kategori_tukang kt', 'u.id = kt.tukang_id', 'left')
            ->where('kt.kategori_id', $kategoriId)
            ->where('u.is_active', true)
            ->where('u.is_verified', true);

        // Filter by availability
        if (isset($filters['status_ketersediaan'])) {
            $builder->where('pt.status_ketersediaan', $filters['status_ketersediaan']);
        }

        // Filter by kota
        if (isset($filters['kota'])) {
            $builder->where('u.kota', $filters['kota']);
        }

        // Filter by rating
        if (isset($filters['min_rating'])) {
            $builder->where('pt.rata_rata_rating >=', $filters['min_rating']);
        }

        // Filter by max tarif
        if (isset($filters['max_tarif'])) {
            $builder->where('pt.tarif_per_jam <=', $filters['max_tarif']);
        }

        // Sorting
        $orderBy = $filters['order_by'] ?? 'rata_rata_rating';
        $orderDir = $filters['order_dir'] ?? 'DESC';
        $builder->orderBy('pt.' . $orderBy, $orderDir);

        return $builder->get()->getResultArray();
    }

    /**
     * Update status ketersediaan tukang
     */
    public function updateKetersediaan($userId, $status)
    {
        return $this->where('user_id', $userId)
            ->set(['status_ketersediaan' => $status])
            ->update();
    }

    /**
     * Update rating tukang setelah dapat rating baru
     */
    public function updateRating($tukangId, $newRating)
    {
        $tukang = $this->where('user_id', $tukangId)->first();
        
        if (!$tukang) {
            return false;
        }

        $totalRating = $tukang['total_rating'] + 1;
        $currentTotal = $tukang['rata_rata_rating'] * $tukang['total_rating'];
        $newAverage = ($currentTotal + $newRating) / $totalRating;

        return $this->where('user_id', $tukangId)
            ->set([
                'rata_rata_rating' => round($newAverage, 2),
                'total_rating' => $totalRating
            ])
            ->update();
    }

    /**
     * Increment total pekerjaan selesai
     */
    public function incrementPekerjaanSelesai($tukangId)
    {
        return $this->where('user_id', $tukangId)
            ->set('total_pekerjaan_selesai', 'total_pekerjaan_selesai + 1', false)
            ->update();
    }

    /**
     * Search tukang by nama atau keahlian
     */
    public function searchTukang($keyword, $filters = [])
    {
        $builder = $this->db->table($this->table . ' pt')
            ->select('pt.*, u.id as user_id, u.nama_lengkap, u.email, u.no_telp, u.foto_profil, u.kota, u.provinsi')
            ->join('auth.users u', 'pt.user_id = u.id', 'left')
            ->where('u.is_active', true)
            ->where('u.is_verified', true)
            ->groupStart()
                ->like('u.nama_lengkap', $keyword)
                ->orLike('pt.bio', $keyword)
                ->orLike('pt.keahlian::text', $keyword)
            ->groupEnd();

        // Apply additional filters
        if (isset($filters['kota'])) {
            $builder->where('u.kota', $filters['kota']);
        }

        if (isset($filters['status_ketersediaan'])) {
            $builder->where('pt.status_ketersediaan', $filters['status_ketersediaan']);
        }

        return $builder->get()->getResultArray();
    }
}
