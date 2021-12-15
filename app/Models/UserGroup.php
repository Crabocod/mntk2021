<?php namespace App\Models;

use CodeIgniter\Model;

class UserGroup extends Model
{
    protected $table = 'user_group';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'user_id', 'group_id', 'updated_at', 'created_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}