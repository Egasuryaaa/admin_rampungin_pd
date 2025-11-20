<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table            = 'transaksi.rating';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'transaksi_id',
        'client_id',
        'tukang_id',
        'rating',
        'ulasan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'transaksi_id' => 'required|integer',
        'client_id'    => 'required|integer',
        'tukang_id'    => 'required|integer',
        'rating'       => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'ulasan'       => 'permit_empty|string'
    ];

    protected $validationMessages = [
        'rating' => [
            'required' => 'Rating wajib diisi',
            'greater_than_equal_to' => 'Rating minimal 1',
            'less_than_equal_to' => 'Rating maksimal 5'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $afterInsert    = ['updateTukangRating'];

    /**
     * Update rating tukang setelah insert rating baru
     */
    protected function updateTukangRating(array $data)
    {
        if (isset($data['id']) && isset($data['data']['tukang_id']) && isset($data['data']['rating'])) {
            $profilTukangModel = new \App\Models\ProfilTukangModel();
            $profilTukangModel->updateRating($data['data']['tukang_id'], $data['data']['rating']);
        }
        return $data;
    }

    /**
     * Get rating dengan detail transaksi dan user
     */
    public function getRatingWithDetails($ratingId = null)
    {
        $builder = $this->db->table($this->table . ' r')
            ->select('r.*, 
                c.nama_lengkap as nama_client, c.foto_profil as foto_client,
                tk.nama_lengkap as nama_tukang, tk.foto_profil as foto_tukang,
                t.nomor_pesanan, t.judul_layanan')
            ->join('auth.users c', 'r.client_id = c.id', 'left')
            ->join('auth.users tk', 'r.tukang_id = tk.id', 'left')
            ->join('transaksi.transaksi t', 'r.transaksi_id = t.id', 'left');

        if ($ratingId !== null) {
            $builder->where('r.id', $ratingId);
            return $builder->get()->getRowArray();
        }

        return $builder->orderBy('r.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get rating by tukang
     */
    public function getRatingByTukang($tukangId)
    {
        return $this->db->table($this->table . ' r')
            ->select('r.*, 
                c.nama_lengkap as nama_client, c.foto_profil as foto_client,
                t.nomor_pesanan, t.judul_layanan')
            ->join('auth.users c', 'r.client_id = c.id', 'left')
            ->join('transaksi.transaksi t', 'r.transaksi_id = t.id', 'left')
            ->where('r.tukang_id', $tukangId)
            ->orderBy('r.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get rating by client
     */
    public function getRatingByClient($clientId)
    {
        return $this->db->table($this->table . ' r')
            ->select('r.*, 
                tk.nama_lengkap as nama_tukang, tk.foto_profil as foto_tukang,
                t.nomor_pesanan, t.judul_layanan')
            ->join('auth.users tk', 'r.tukang_id = tk.id', 'left')
            ->join('transaksi.transaksi t', 'r.transaksi_id = t.id', 'left')
            ->where('r.client_id', $clientId)
            ->orderBy('r.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Check if transaksi sudah diberi rating
     */
    public function hasRating($transaksiId)
    {
        return $this->where('transaksi_id', $transaksiId)->countAllResults() > 0;
    }

    /**
     * Create rating untuk transaksi
     */

    //di taruh ke controller
    public function createRating($data)
    {
        // Validate transaksi
        $transaksiModel = new \App\Models\TransaksiModel();
        $transaksi = $transaksiModel->find($data['transaksi_id']);

        if (!$transaksi) {
            return ['success' => false, 'message' => 'Transaksi tidak ditemukan'];
        }

        if ($transaksi['status'] !== 'selesai') {
            return ['success' => false, 'message' => 'Hanya transaksi yang selesai yang bisa diberi rating'];
        }

        if ($this->hasRating($data['transaksi_id'])) {
            return ['success' => false, 'message' => 'Transaksi ini sudah diberi rating'];
        }

        // Auto-fill client_id dan tukang_id dari transaksi
        $data['client_id'] = $transaksi['client_id'];
        $data['tukang_id'] = $transaksi['tukang_id'];

        $result = $this->insert($data);

        if ($result) {
            // Increment total_pekerjaan_selesai tukang
            $profilTukangModel = new \App\Models\ProfilTukangModel();
            $profilTukangModel->incrementPekerjaanSelesai($transaksi['tukang_id']);

            return ['success' => true, 'message' => 'Rating berhasil diberikan', 'id' => $result];
        }

        return ['success' => false, 'message' => 'Gagal memberikan rating'];
    }

    /**
     * Get statistik rating tukang
     */
    public function getStatistikByTukang($tukangId)
    {
        $ratings = $this->where('tukang_id', $tukangId)->findAll();
        
        $total = count($ratings);
        if ($total === 0) {
            return [
                'total' => 0,
                'rata_rata' => 0,
                'bintang_5' => 0,
                'bintang_4' => 0,
                'bintang_3' => 0,
                'bintang_2' => 0,
                'bintang_1' => 0
            ];
        }

        $stats = [
            'total' => $total,
            'rata_rata' => 0,
            'bintang_5' => 0,
            'bintang_4' => 0,
            'bintang_3' => 0,
            'bintang_2' => 0,
            'bintang_1' => 0
        ];

        $sum = 0;
        foreach ($ratings as $rating) {
            $sum += $rating['rating'];
            $stats['bintang_' . $rating['rating']]++;
        }

        $stats['rata_rata'] = round($sum / $total, 2);

        return $stats;
    }

    public function GetDataFeedback(){
        $builder = $this->db->table('transaksi.rating r');
        $builder->select('
            r.rating,
            r.ulasan,
            r.created_at,
            r.transaksi_id,
            t.nomor_pesanan,
            t.judul_layanan,
            c.id as client_id,
            c.nama_lengkap as nama_client,
            c.foto_profil as client_foto,
            tk.id as tukang_id,
            tk.nama_lengkap as nama_tukang
        ');
        $builder->join('transaksi.transaksi t', 'r.transaksi_id = t.id', 'left');
        $builder->join('auth.users c', 'r.client_id = c.id', 'left');
        $builder->join('auth.users tk', 'r.tukang_id = tk.id', 'left');
        $builder->orderBy('r.created_at', 'DESC');

        $data['ratings'] = $builder->get()->getResultArray();
        return $data;
    }
}
