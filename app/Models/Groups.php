<?php namespace App\Models;

use CodeIgniter\Model;

class Groups extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Groups\Group';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'conference_id', 'title', 'sync_at', 'deleted_at', 'updated_at', 'created_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}