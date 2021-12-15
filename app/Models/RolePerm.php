<?php namespace App\Models;

use CodeIgniter\Model;

class RolePerm extends Model
{
    protected $table = 'role_perm';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'role_id', 'perm_id'];

    protected $useTimestamps = false;

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getRolePermissions(int $role_id)
    {
        $this->select('p.title');
        $this->where('role_id', $role_id);
        $this->join('permissions p', 'p.id=perm_id', 'left');
        return $this->findAll();
    }
}
