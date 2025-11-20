<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'auth.users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'email',
        'no_telp',
        'password_hash',
        'nama_lengkap',
        'foto_profil',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'poin',
        'is_active',
        'is_verified',
        'id_role'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'username'      => 'required|string|max_length[50]',
        'email'         => 'required|valid_email|max_length[100]',
        'no_telp'       => 'permit_empty|string|max_length[20]',
        'password_hash' => 'required|string|max_length[255]',
        'nama_lengkap'  => 'permit_empty|string|max_length[255]',
        'id_role'       => 'required|integer',
        'poin'          => 'permit_empty|integer|greater_than_equal_to[0]'
    ];

    protected $validationMessages = [
        'username' => [
            'required'   => 'Username wajib diisi'
        ],
        'email' => [
            'required'     => 'Email wajib diisi',
            'valid_email'  => 'Format email tidak valid'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    /**
     * Get user berdasarkan username
     */
    public function getUserByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Get user berdasarkan email
     */
    public function getUserByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get user dengan role
     */
    public function getUserWithRole($userId = null)
    {
        $builder = $this->db->table($this->table . ' u')
            ->select('u.*, r.name as role_name, r.description as role_description')
            ->join('auth.roles r', 'u.id_role = r.id', 'left');

        if ($userId !== null) {
            $builder->where('u.id', $userId);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Get users by role
     */
    public function getUsersByRole($roleId)
    {
        return $this->where('id_role', $roleId)
            ->where('is_active', true)
            ->findAll();
    }

    /**
     * Get clients (role_id = 2)
     */
    public function getClients()
    {
        return $this->getUsersByRole(2);
    }

    /**
     * Get tukangs (role_id = 3)
     */
    public function getTukangs($verified = null)
    {
        $builder = $this->where('id_role', 3);

        if ($verified !== null) {
            $builder->where('is_verified', $verified);
        }

        return $builder->where('is_active', true)->findAll();
    }

    /**
     * Verify user (untuk tukang)
     */
    public function verifyUser($userId)
    {
        return $this->update($userId, ['is_verified' => true]);
    }

    /**
     * Unverify user
     */
    public function unverifyUser($userId)
    {
        return $this->update($userId, ['is_verified' => false]);
    }

    /**
     * Activate user
     */
    public function activateUser($userId)
    {
        return $this->update($userId, ['is_active' => true]);
    }

    /**
     * Deactivate user
     */
    public function deactivateUser($userId)
    {
        return $this->update($userId, ['is_active' => false]);
    }

    /**
     * Add poin to user (untuk top-up atau terima pembayaran poin)
     */
    public function addPoin($userId, $jumlah)
    {
        $user = $this->find($userId);
        if (!$user) {
            return false;
        }

        $newPoin = $user['poin'] + $jumlah;
        return $this->update($userId, ['poin' => $newPoin]);
    }

    /**
     * Deduct poin from user (untuk pembayaran atau withdrawal)
     */
    public function deductPoin($userId, $jumlah)
    {
        $user = $this->find($userId);
        if (!$user) {
            return false;
        }

        // Check if sufficient balance
        if ($user['poin'] < $jumlah) {
            return false;
        }

        $newPoin = $user['poin'] - $jumlah;
        return $this->update($userId, ['poin' => $newPoin]);
    }

    /**
     * Check poin balance
     */
    public function checkPoinBalance($userId)
    {
        $user = $this->find($userId);
        return $user ? $user['poin'] : 0;
    }

    /**
     * Set poin (untuk admin manual adjustment)
     */
    public function setPoin($userId, $jumlah)
    {
        return $this->update($userId, ['poin' => $jumlah]);
    }

    /**
     * Search users
     */
    public function searchUsers($keyword, $roleId = null)
    {
        $builder = $this->groupStart()
            ->like('nama_lengkap', $keyword)
            ->orLike('username', $keyword)
            ->orLike('email', $keyword)
            ->orLike('no_telp', $keyword)
            ->groupEnd();

        if ($roleId !== null) {
            $builder->where('id_role', $roleId);
        }

        return $builder->where('is_active', true)->findAll();
    }

    /**
     * Get user statistics
     */
    public function getStatistik()
    {
        return [
            'total' => $this->countAll(),
            'aktif' => $this->where('is_active', true)->countAllResults(false),
            'verified' => $this->where('is_verified', true)->countAllResults(false),
            'clients' => $this->where('id_role', 2)->countAllResults(false),
            'tukangs' => $this->where('id_role', 3)->countAllResults(false),
            'tukangs_verified' => $this->where([
                'id_role' => 3,
                'is_verified' => true
            ])->countAllResults(false),
            'total_poin' => $this->selectSum('poin')->get()->getRow()->poin ?? 0
        ];
    }

    /**
     * Get tukang with wallet info
     */
    public function getTukangWithWallet()
    {
        return $this->db->table($this->table . ' u')
            ->select('u.id, u.username, u.email, u.nama_lengkap, u.poin, u.is_active, u.created_at')
            ->where('u.id_role', 3) // Role tukang
            ->where('u.is_active', true)
            ->get()
            ->getResultArray();
    }
}