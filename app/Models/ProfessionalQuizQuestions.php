<?php namespace App\Models;

use CodeIgniter\Model;

class ProfessionalQuizQuestions extends Model
{
    protected $table = 'professional_quiz_questions';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ProfQuizQuestions\ProfQuizQuestion';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'id',
        'conference_id',
        'number',
        'youtube_iframe',
        'img',
        'text',
        'visibility',
        'audio',
        'audio_title',
        'file',
        'file_title'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}