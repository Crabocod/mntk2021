<?php namespace App\Models;

use CodeIgniter\Model;

class UserEvents extends Model
{
    protected $table = 'user_events';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Users\UserEvents';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'user_id', 'event_id', 'status'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}