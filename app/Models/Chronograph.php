<?php namespace App\Models;

use CodeIgniter\Model;

class Chronograph extends Model
{
    protected $table = 'chronograph';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Chronograph\Chronograph';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}