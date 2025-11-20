<?php

namespace App\Models;

use CodeIgniter\Model;

class IpBlockModel extends Model
{
    protected $table            = 'auth.ip_blocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['ip_address', 'reason', 'blocked_at', 'unblock_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
     * Check if IP address is blocked
     */
    public function isIpBlocked($ipAddress)
    {
        $blocked = $this->where('ip_address', $ipAddress)->first();
        if ($blocked) {
            // Check if unblock_at is set and has passed
            if ($blocked['unblock_at'] && strtotime($blocked['unblock_at']) < time()) {
                // Unblock time has passed, remove the block
                $this->delete($blocked['id']);
                return false;
            }
            return true;
        }
        return false;
    }
}
