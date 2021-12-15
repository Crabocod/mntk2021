<?php namespace App\Models;

use CodeIgniter\Model;

class AcquaintanceFeedback extends Model
{
    protected $table = 'acquaintance_feedback';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'user_id', 'grade', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}