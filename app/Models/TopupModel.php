<?php

namespace App\Models;

use CodeIgniter\Model;

class TopupModel extends Model
{
    protected $table            = 'transaksi.topup';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'jumlah',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
        'diverifikasi_oleh',
        'waktu_verifikasi',
        'alasan_penolakan',
        'kadaluarsa_pada'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id'           => 'required|integer',
        'jumlah'            => 'required|decimal|greater_than[0]',
        'metode_pembayaran' => 'required|in_list[qris]',
        'bukti_pembayaran'  => 'required|string|max_length[500]',
        'status'            => 'permit_empty|in_list[pending,berhasil,ditolak,kadaluarsa]'
    ];

    protected $validationMessages = [
        'metode_pembayaran' => [
            'in_list' => 'Metode pembayaran hanya tersedia QRIS'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setKadaluarsa'];

    /**
     * Set waktu kadaluarsa (24 jam dari sekarang)
     */
    protected function setKadaluarsa(array $data)
    {
        if (!isset($data['data']['kadaluarsa_pada'])) {
            $data['data']['kadaluarsa_pada'] = date('Y-m-d H:i:s', strtotime('+24 hours'));
        }
        return $data;
    }

    /**
     * Get topup dengan detail user
     */
    public function getTopupWithUser($topupId = null)
    {
        $builder = $this->db->table($this->table . ' t')
            ->select('t.*, u.nama_lengkap, u.email, u.no_telp, u.foto_profil')
            ->join('auth.users u', 't.user_id = u.id', 'left');

        if ($topupId !== null) {
            $builder->where('t.id', $topupId);
            return $builder->get()->getRowArray();
        }

        return $builder->orderBy('t.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get topup by user
     */
    public function getTopupByUser($userId, $status = null)
    {
        $builder = $this->where('user_id', $userId);

        if ($status !== null) {
            $builder->where('status', $status);
        }

        return $builder->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Get topup pending (untuk admin)
     */
    public function getPendingTopup()
    {
        return $this->db->table($this->table . ' t')
            ->select('t.*, u.nama_lengkap, u.email, u.no_telp')
            ->join('auth.users u', 't.user_id = u.id', 'left')
            ->where('t.status', 'pending')
            ->where('t.kadaluarsa_pada >', date('Y-m-d H:i:s'))
            ->orderBy('t.created_at', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Verifikasi topup (approve)
     */
    public function approveTopup($topupId, $adminId)
    {
        $topup = $this->find($topupId);
        
        if (!$topup || $topup['status'] !== 'pending') {
            return ['success' => false, 'message' => 'Top-up tidak ditemukan atau sudah diproses'];
        }

        // Check if expired
        if (strtotime($topup['kadaluarsa_pada']) < time()) {
            $this->update($topupId, ['status' => 'kadaluarsa']);
            return ['success' => false, 'message' => 'Top-up sudah kadaluarsa'];
        }

        $this->db->transStart();

        // Update topup status
        $this->update($topupId, [
            'status' => 'berhasil',
            'diverifikasi_oleh' => $adminId,
            'waktu_verifikasi' => date('Y-m-d H:i:s')
        ]);

        // Add poin to user
        $userModel = new \App\Models\UserModel();
        $userModel->addPoin($topup['user_id'], $topup['jumlah']);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return ['success' => false, 'message' => 'Gagal memproses top-up'];
        }

        return ['success' => true, 'message' => 'Top-up berhasil diverifikasi'];
    }

    /**
     * Tolak topup
     */
    public function rejectTopup($topupId, $adminId, $alasan)
    {
        $topup = $this->find($topupId);
        
        if (!$topup || $topup['status'] !== 'pending') {
            return ['success' => false, 'message' => 'Top-up tidak ditemukan atau sudah diproses'];
        }

        $result = $this->update($topupId, [
            'status' => 'ditolak',
            'diverifikasi_oleh' => $adminId,
            'waktu_verifikasi' => date('Y-m-d H:i:s'),
            'alasan_penolakan' => $alasan
        ]);

        if ($result) {
            return ['success' => true, 'message' => 'Top-up berhasil ditolak'];
        }

        return ['success' => false, 'message' => 'Gagal menolak top-up'];
    }

    /**
     * Check dan update topup yang kadaluarsa
     */
    public function checkExpiredTopup()
    {
        return $this->where('status', 'pending')
            ->where('kadaluarsa_pada <', date('Y-m-d H:i:s'))
            ->set(['status' => 'kadaluarsa'])
            ->update();
    }

    /**
     * Get statistik topup
     */
    public function getStatistik($filters = [])
    {
        $builder = $this->db->table($this->table);

        if (isset($filters['start_date'])) {
            $builder->where('created_at >=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $builder->where('created_at <=', $filters['end_date']);
        }

        if (isset($filters['user_id'])) {
            $builder->where('user_id', $filters['user_id']);
        }

        return [
            'total' => $builder->countAllResults(false),
            'pending' => $builder->where('status', 'pending')->countAllResults(false),
            'berhasil' => $builder->where('status', 'berhasil')->countAllResults(false),
            'ditolak' => $builder->where('status', 'ditolak')->countAllResults(false),
            'kadaluarsa' => $builder->where('status', 'kadaluarsa')->countAllResults(false),
            'total_topup_berhasil' => $this->db->table($this->table)
                ->selectSum('jumlah')
                ->where('status', 'berhasil')
                ->get()
                ->getRow()
                ->jumlah ?? 0
        ];
    }

    /**
     * Get all topup requests for admin
     */
    public function getAllTopupRequests()
    {
        return $this->db->table($this->table . ' t')
            ->select('t.*, u.nama_lengkap, u.email, u.username')
            ->join('auth.users u', 't.user_id = u.id', 'left')
            ->orderBy('t.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
