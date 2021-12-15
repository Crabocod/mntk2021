<?php namespace App\Models;

use CodeIgniter\Model;

class SectionFeedbacks extends Model
{
    protected $table = 'section_feedbacks';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\SectionFeedbacks\SectionFeedback';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'grade', 'section_id', 'user_id', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}