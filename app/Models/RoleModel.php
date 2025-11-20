<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    // Use schema-qualified table name for PostgreSQL
    protected $table = 'auth.roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'description',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    // Note: keep validation rules without schema qualification to avoid escaping issues
    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[50]|is_unique[roles.name]',
        'description' => 'permit_empty|max_length[255]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get role by name
     */
    public function getRoleByName(string $name)
    {
        // Use fully-qualified table name to ensure correct schema is used for Postgres
        return $this->db->table('auth.roles')
                        ->where('name', $name)
                        ->get()
                        ->getRowArray();
    }

    /**
     * Get all active roles
     */
    public function getActiveRoles()
    {
        // Query the schema-qualified table directly to avoid identifier-escaping issues
        return $this->db->table('auth.roles')
                        ->orderBy('id', 'ASC')
                        ->get()
                        ->getResultArray();
    }
}
