<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi.transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_pesanan',
        'client_id',
        'tukang_id',
        'kategori_id',
        'judul_layanan',
        'deskripsi_layanan',
        'lokasi_kerja',
        'tanggal_jadwal',
        'waktu_jadwal',
        'estimasi_durasi_jam',
        'waktu_mulai_aktual',
        'waktu_selesai_aktual',
        'harga_dasar',
        'biaya_tambahan',
        'total_biaya',
        'metode_pembayaran',
        'poin_terpotong',
        'sudah_dibayar_tunai',
        'waktu_konfirmasi_pembayaran_tunai',
        'status',
        'alasan_pembatalan',
        'alasan_penolakan',
        'dibatalkan_oleh',
        'catatan_client',
        'catatan_tukang',
        'waktu_diterima',
        'waktu_ditolak',
        'waktu_mulai',
        'waktu_selesai',
        'waktu_dibatalkan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'client_id'         => 'required|integer',
        'tukang_id'         => 'required|integer',
        'judul_layanan'     => 'required|string|max_length[255]',
        'lokasi_kerja'      => 'required|string',
        'tanggal_jadwal'    => 'required|valid_date',
        'waktu_jadwal'      => 'required',
        'harga_dasar'       => 'required|decimal|greater_than_equal_to[0]',
        'total_biaya'       => 'required|decimal|greater_than_equal_to[0]',
        'metode_pembayaran' => 'required|in_list[poin,tunai]',
        'status'            => 'permit_empty|in_list[pending,diterima,ditolak,dalam_proses,selesai,dibatalkan]'
    ];

    protected $validationMessages = [
        'metode_pembayaran' => [
            'in_list' => 'Metode pembayaran harus poin atau tunai'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generateNomorPesanan'];

    /**
     * Generate nomor pesanan otomatis
     */
    protected function generateNomorPesanan(array $data)
    {
        if (!isset($data['data']['nomor_pesanan']) || empty($data['data']['nomor_pesanan'])) {
            $date = date('Ymd');
            
            // Get last order number for today
            $lastOrder = $this->like('nomor_pesanan', 'TRX-' . $date)
                ->orderBy('id', 'DESC')
                ->first();

            if ($lastOrder) {
                $lastNumber = intval(substr($lastOrder['nomor_pesanan'], -4));
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            $data['data']['nomor_pesanan'] = 'TRX-' . $date . '-' . $newNumber;
        }
        return $data;
    }

    /**
     * Get transaksi dengan detail lengkap
     */
    public function getTransaksiWithDetails($transaksiId = null)
    {
        $builder = $this->db->table($this->table . ' t')
            ->select('t.*, 
                c.nama_lengkap as nama_client, c.email as email_client, c.no_telp as no_telp_client, c.foto_profil as foto_client,
                tk.nama_lengkap as nama_tukang, tk.email as email_tukang, tk.no_telp as no_telp_tukang, tk.foto_profil as foto_tukang,
                pt.tarif_per_jam, pt.rata_rata_rating,
                k.nama as nama_kategori')
            ->join('auth.users c', 't.client_id = c.id', 'left')
            ->join('auth.users tk', 't.tukang_id = tk.id', 'left')
            ->join('auth.profil_tukang pt', 'tk.id = pt.user_id', 'left')
            ->join('transaksi.kategori k', 't.kategori_id = k.id', 'left');

        if ($transaksiId !== null) {
            $builder->where('t.id', $transaksiId);
            return $builder->get()->getRowArray();
        }

        return $builder->orderBy('t.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get transaksi by client
     */
    public function getTransaksiByClient($clientId, $status = null)
    {
        $builder = $this->db->table($this->table . ' t')
            ->select('t.*, 
                tk.nama_lengkap as nama_tukang, tk.foto_profil as foto_tukang,
                pt.rata_rata_rating,
                k.nama as nama_kategori')
            ->join('auth.users tk', 't.tukang_id = tk.id', 'left')
            ->join('auth.profil_tukang pt', 'tk.id = pt.user_id', 'left')
            ->join('transaksi.kategori k', 't.kategori_id = k.id', 'left')
            ->where('t.client_id', $clientId);

        if ($status !== null) {
            $builder->where('t.status', $status);
        }

        return $builder->orderBy('t.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get transaksi by tukang
     */
    public function getTransaksiByTukang($tukangId, $status = null)
    {
        $builder = $this->db->table($this->table . ' t')
            ->select('t.*, 
                c.nama_lengkap as nama_client, c.foto_profil as foto_client, c.no_telp as no_telp_client,
                k.nama as nama_kategori')
            ->join('auth.users c', 't.client_id = c.id', 'left')
            ->join('transaksi.kategori k', 't.kategori_id = k.id', 'left')
            ->where('t.tukang_id', $tukangId);

        if ($status !== null) {
            $builder->where('t.status', $status);
        }

        return $builder->orderBy('t.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Update status transaksi dengan logging
     */
    public function updateStatus($transaksiId, $newStatus, $userId, $keterangan = null)
    {
        $transaksi = $this->find($transaksiId);
        if (!$transaksi) {
            return false;
        }

        $oldStatus = $transaksi['status'];
        $updateData = ['status' => $newStatus];

        // Set timestamp berdasarkan status
        switch ($newStatus) {
            case 'diterima':
                $updateData['waktu_diterima'] = date('Y-m-d H:i:s');
                break;
            case 'ditolak':
                $updateData['waktu_ditolak'] = date('Y-m-d H:i:s');
                break;
            case 'dalam_proses':
                $updateData['waktu_mulai'] = date('Y-m-d H:i:s');
                $updateData['waktu_mulai_aktual'] = date('Y-m-d H:i:s');
                break;
            case 'selesai':
                $updateData['waktu_selesai'] = date('Y-m-d H:i:s');
                $updateData['waktu_selesai_aktual'] = date('Y-m-d H:i:s');
                break;
            case 'dibatalkan':
                $updateData['waktu_dibatalkan'] = date('Y-m-d H:i:s');
                $updateData['dibatalkan_oleh'] = $userId;
                break;
        }

        // Update transaksi
        $this->update($transaksiId, $updateData);

        // Log to riwayat_status_transaksi
        $this->db->table('transaksi.riwayat_status_transaksi')->insert([
            'transaksi_id' => $transaksiId,
            'status_dari'  => $oldStatus,
            'status_ke'    => $newStatus,
            'diubah_oleh'  => $userId,
            'keterangan'   => $keterangan,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        return true;
    }

    /**
     * Proses pembayaran poin (potong saldo client)
     */
    public function processPaymentPoin($transaksiId)
    {
        $transaksi = $this->find($transaksiId);
        if (!$transaksi || $transaksi['metode_pembayaran'] !== 'poin') {
            return false;
        }

        // Check if already deducted
        if ($transaksi['poin_terpotong']) {
            return true;
        }

        $userModel = new \App\Models\UserModel();
        
        // Deduct poin from client
        $result = $userModel->deductPoin($transaksi['client_id'], $transaksi['total_biaya']);
        
        if ($result) {
            // Mark as deducted
            $this->update($transaksiId, ['poin_terpotong' => true]);
            return true;
        }

        return false;
    }

    /**
     * Transfer poin ke tukang setelah selesai
     */
    public function transferPoinToTukang($transaksiId)
    {
        $transaksi = $this->find($transaksiId);
        if (!$transaksi || $transaksi['metode_pembayaran'] !== 'poin' || $transaksi['status'] !== 'selesai') {
            return false;
        }

        $userModel = new \App\Models\UserModel();
        
        // Add poin to tukang
        return $userModel->addPoin($transaksi['tukang_id'], $transaksi['total_biaya']);
    }

    /**
     * Refund poin ke client (jika transaksi ditolak/dibatalkan)
     */
    public function refundPoinToClient($transaksiId)
    {
        $transaksi = $this->find($transaksiId);
        if (!$transaksi || $transaksi['metode_pembayaran'] !== 'poin' || !$transaksi['poin_terpotong']) {
            return false;
        }

        $userModel = new \App\Models\UserModel();
        
        // Return poin to client
        $result = $userModel->addPoin($transaksi['client_id'], $transaksi['total_biaya']);
        
        if ($result) {
            // Mark as not deducted
            $this->update($transaksiId, ['poin_terpotong' => false]);
            return true;
        }

        return false;
    }

    /**
     * Konfirmasi pembayaran tunai
     */
    public function confirmPaymentTunai($transaksiId)
    {
        $transaksi = $this->find($transaksiId);
        if (!$transaksi || $transaksi['metode_pembayaran'] !== 'tunai') {
            return false;
        }

        return $this->update($transaksiId, [
            'sudah_dibayar_tunai' => true,
            'waktu_konfirmasi_pembayaran_tunai' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get statistik transaksi
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

        if (isset($filters['client_id'])) {
            $builder->where('client_id', $filters['client_id']);
        }

        if (isset($filters['tukang_id'])) {
            $builder->where('tukang_id', $filters['tukang_id']);
        }

        return [
            'total' => $builder->countAllResults(false),
            'pending' => $builder->where('status', 'pending')->countAllResults(false),
            'diterima' => $builder->where('status', 'diterima')->countAllResults(false),
            'dalam_proses' => $builder->where('status', 'dalam_proses')->countAllResults(false),
            'selesai' => $builder->where('status', 'selesai')->countAllResults(false),
            'dibatalkan' => $builder->where('status', 'dibatalkan')->countAllResults(false),
            'ditolak' => $builder->where('status', 'ditolak')->countAllResults(false),
            'total_pendapatan' => $this->db->table($this->table)
                ->selectSum('total_biaya')
                ->where('status', 'selesai')
                ->get()
                ->getRow()
                ->total_biaya ?? 0
        ];
    }
}
