<?php namespace App\Models;


use CodeIgniter\Model;

class ChronographQuestions extends Model
{
    protected $table = 'chronograph_questions';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ChronographQuestions\ChronographQuestions';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'number', 'text', 'youtube_iframe', 'show'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}