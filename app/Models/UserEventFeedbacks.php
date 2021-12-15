<?php namespace App\Models;

use CodeIgniter\Model;

class UserEventFeedbacks extends Model
{
    protected $table = 'user_event_feedbacks';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'user_id', 'event_id', 'grade', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}