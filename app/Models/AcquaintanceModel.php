<?php namespace App\Models;

use CodeIgniter\Model;

class AcquaintanceModel extends Model
{
    protected $table = 'acquaintance';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Acquaintances\Acquaintance';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'title', 'text', 'youtube_iframe'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}