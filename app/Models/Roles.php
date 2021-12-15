<?php namespace App\Models;

use CodeIgniter\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'title'];

    protected $useTimestamps = false;

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $afterFind = ['afterFindAll'];
    protected $handleById = false;

    public function handleById($is = true)
    {
        $this->handleById = $is;
        return $this;
    }

    public function afterFindAll($data = [])
    {
        if (isset($data['data']) and $this->handleById === true) {
            $roles = Array();
            foreach ($data['data'] as $role) {
                $roles[$role['id']] = $role;
            }
            $data['data'] = $roles;
        }
        return $data;
    }
}
