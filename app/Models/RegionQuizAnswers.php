<?php namespace App\Models;

use CodeIgniter\Model;

class RegionQuizAnswers extends Model
{
    protected $table = 'region_quiz_answers';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\RegionQuizAnswers\RegionQuizAnswer';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'region_quiz_question_id', 'user_id', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}