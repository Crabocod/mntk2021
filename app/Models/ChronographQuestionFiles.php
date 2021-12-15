<?php namespace App\Models;

use CodeIgniter\Model;

class ChronographQuestionFiles extends Model
{
    protected $table = 'chronograph_question_files';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ChronographQuestionFiles\ChronographQuestionFile';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'chronograph_question_id', 'type_id', 'file_id'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}