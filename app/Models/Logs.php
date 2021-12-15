<?php namespace App\Models;

use CodeIgniter\Model;

class Logs extends Model
{
    protected $table = 'logs';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Logs\Log';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'user_id', 'request', 'data'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}