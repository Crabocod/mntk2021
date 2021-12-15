<?php namespace App\Models;

use CodeIgniter\Model;

class ChronographQuestionAnswers extends Model
{
    protected $table = 'chronograph_question_answers';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ChronographQuestionAnswers\ChronographQuestionAnswers';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'user_id', 'chronograph_question_id', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}