<?php

namespace App\Models;

use CodeIgniter\Model;

class JwtBlacklistModel extends Model
{
    protected $table            = 'auth.jwt_blacklist';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'token_hash',
        'user_id',
        'expires_at',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = null;

    /**
     * Check if token is blacklisted
     */
    public function isBlacklisted($token)
    {
        $tokenHash = hash('sha256', $token);
        return $this->where('token_hash', $tokenHash)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->countAllResults() > 0;
    }

    /**
     * Clean expired tokens
     */
    public function cleanExpiredTokens()
    {
        return $this->where('expires_at <', date('Y-m-d H:i:s'))->delete();
    }
}
