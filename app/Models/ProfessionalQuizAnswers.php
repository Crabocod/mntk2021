<?php namespace App\Models;

use CodeIgniter\Model;

class ProfessionalQuizAnswers extends Model
{
    protected $table = 'professional_quiz_answers';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ProfQuizAnswers\ProfQuizAnswer';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'professional_quiz_question_id', 'user_id', 'text', 'file', 'file_name'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}