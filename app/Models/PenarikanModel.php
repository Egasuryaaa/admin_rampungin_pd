<?php

namespace App\Models;

use CodeIgniter\Model;

class PenarikanModel extends Model
{
    protected $table            = 'transaksi.penarikan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tukang_id',
        'jumlah',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'biaya_admin',
        'jumlah_bersih',
        'status',
        'diproses_oleh',
        'waktu_diproses',
        'alasan_penolakan',
        'bukti_transfer'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'tukang_id'             => 'required|integer',
        'jumlah'                => 'required|decimal|greater_than[0]',
        'nama_bank'             => 'required|string|max_length[100]',
        'nomor_rekening'        => 'required|string|max_length[50]',
        'nama_pemilik_rekening' => 'required|string|max_length[255]',
        'biaya_admin'           => 'permit_empty|decimal|greater_than_equal_to[0]',
        'jumlah_bersih'         => 'required|decimal|greater_than[0]',
        'status'                => 'permit_empty|in_list[pending,diproses,selesai,ditolak]'
    ];

    protected $validationMessages = [];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['calculateJumlahBersih'];
    protected $beforeUpdate   = ['calculateJumlahBersih'];

    /**
     * Calculate jumlah bersih (jumlah - biaya_admin)
     */
    protected function calculateJumlahBersih(array $data)
    {
        if (isset($data['data']['jumlah'])) {
            $biayaAdmin = $data['data']['biaya_admin'] ?? 0;
            $data['data']['jumlah_bersih'] = $data['data']['jumlah'] - $biayaAdmin;
        }
        return $data;
    }

    /**
     * Get penarikan dengan detail tukang
     */
    public function getPenarikanWithTukang($penarikanId = null)
    {
        $builder = $this->db->table($this->table . ' p')
            ->select('p.*, u.nama_lengkap, u.email, u.no_telp, u.foto_profil, u.poin')
            ->join('auth.users u', 'p.tukang_id = u.id', 'left');

        if ($penarikanId !== null) {
            $builder->where('p.id', $penarikanId);
            return $builder->get()->getRowArray();
        }

        return $builder->orderBy('p.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get penarikan by tukang
     */
    public function getPenarikanByTukang($tukangId, $status = null)
    {
        $builder = $this->where('tukang_id', $tukangId);

        if ($status !== null) {
            $builder->where('status', $status);
        }

        return $builder->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Get penarikan pending (untuk admin)
     */
    public function getPendingPenarikan()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, u.nama_lengkap, u.email, u.no_telp, u.poin')
            ->join('auth.users u', 'p.tukang_id = u.id', 'left')
            ->where('p.status', 'pending')
            ->orderBy('p.created_at', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Request penarikan (dari tukang)
     */
    public function requestPenarikan($data)
    {
        $userModel = new \App\Models\UserModel();
        $tukang = $userModel->find($data['tukang_id']);

        if (!$tukang) {
            return ['success' => false, 'message' => 'Tukang tidak ditemukan'];
        }

        // Check saldo poin
        if ($tukang['poin'] < $data['jumlah']) {
            return ['success' => false, 'message' => 'Saldo poin tidak mencukupi'];
        }

        // Check minimum withdrawal (optional)
        $minWithdraw = 50000; // Minimum 50k
        if ($data['jumlah'] < $minWithdraw) {
            return ['success' => false, 'message' => 'Minimal penarikan Rp ' . number_format($minWithdraw, 0, ',', '.')];
        }

        // Calculate biaya admin (contoh: 2% atau max 5000)
        $biayaAdmin = min($data['jumlah'] * 0.02, 5000);
        $data['biaya_admin'] = $biayaAdmin;
        $data['jumlah_bersih'] = $data['jumlah'] - $biayaAdmin;
        $data['status'] = 'pending';

        $result = $this->insert($data);

        if ($result) {
            return ['success' => true, 'message' => 'Permintaan penarikan berhasil diajukan', 'id' => $result];
        }

        return ['success' => false, 'message' => 'Gagal mengajukan penarikan'];
    }

    /**
     * Approve penarikan (admin)
     */
    public function approvePenarikan($penarikanId, $adminId, $buktiTransfer = null)
    {
        $penarikan = $this->find($penarikanId);
        
        if (!$penarikan || $penarikan['status'] !== 'pending') {
            return ['success' => false, 'message' => 'Penarikan tidak ditemukan atau sudah diproses'];
        }

        $userModel = new \App\Models\UserModel();
        $tukang = $userModel->find($penarikan['tukang_id']);

        // Check saldo poin tukang
        if ($tukang['poin'] < $penarikan['jumlah']) {
            return ['success' => false, 'message' => 'Saldo poin tukang tidak mencukupi'];
        }

        $this->db->transStart();

        // Update status penarikan
        $this->update($penarikanId, [
            'status' => 'selesai',
            'diproses_oleh' => $adminId,
            'waktu_diproses' => date('Y-m-d H:i:s'),
            'bukti_transfer' => $buktiTransfer
        ]);

        // Deduct poin from tukang
        $userModel->deductPoin($penarikan['tukang_id'], $penarikan['jumlah']);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return ['success' => false, 'message' => 'Gagal memproses penarikan'];
        }

        return ['success' => true, 'message' => 'Penarikan berhasil diproses'];
    }

    /**
     * Reject penarikan (admin)
     */
    public function rejectPenarikan($penarikanId, $adminId, $alasan)
    {
        $penarikan = $this->find($penarikanId);
        
        if (!$penarikan || $penarikan['status'] !== 'pending') {
            return ['success' => false, 'message' => 'Penarikan tidak ditemukan atau sudah diproses'];
        }

        $result = $this->update($penarikanId, [
            'status' => 'ditolak',
            'diproses_oleh' => $adminId,
            'waktu_diproses' => date('Y-m-d H:i:s'),
            'alasan_penolakan' => $alasan
        ]);

        if ($result) {
            return ['success' => true, 'message' => 'Penarikan berhasil ditolak'];
        }

        return ['success' => false, 'message' => 'Gagal menolak penarikan'];
    }

    /**
     * Set penarikan to diproses (admin mulai proses transfer)
     */
    public function setProsesTransfer($penarikanId, $adminId)
    {
        $penarikan = $this->find($penarikanId);
        
        if (!$penarikan || $penarikan['status'] !== 'pending') {
            return ['success' => false, 'message' => 'Penarikan tidak ditemukan atau sudah diproses'];
        }

        $result = $this->update($penarikanId, [
            'status' => 'diproses',
            'diproses_oleh' => $adminId,
            'waktu_diproses' => date('Y-m-d H:i:s')
        ]);

        if ($result) {
            return ['success' => true, 'message' => 'Penarikan sedang diproses'];
        }

        return ['success' => false, 'message' => 'Gagal memproses penarikan'];
    }

    /**
     * Get statistik penarikan
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

        if (isset($filters['tukang_id'])) {
            $builder->where('tukang_id', $filters['tukang_id']);
        }

        return [
            'total' => $builder->countAllResults(false),
            'pending' => $builder->where('status', 'pending')->countAllResults(false),
            'diproses' => $builder->where('status', 'diproses')->countAllResults(false),
            'selesai' => $builder->where('status', 'selesai')->countAllResults(false),
            'ditolak' => $builder->where('status', 'ditolak')->countAllResults(false),
            'total_penarikan' => $this->db->table($this->table)
                ->selectSum('jumlah')
                ->where('status', 'selesai')
                ->get()
                ->getRow()
                ->jumlah ?? 0
        ];
    }

    /**
     * Get all withdrawal requests for admin
     */
    public function getAllWithdrawalRequests()
    {
        return $this->db->table($this->table . ' p')
            ->select('p.*, u.nama_lengkap, u.email, u.username, u.poin')
            ->join('auth.users u', 'p.tukang_id = u.id', 'left')
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
