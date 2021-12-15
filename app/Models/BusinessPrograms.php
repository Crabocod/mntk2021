<?php namespace App\Models;

use CodeIgniter\Model;

class BusinessPrograms extends Model
{
    protected $table = 'business_programs';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\BusinessPrograms\BusinessProgram';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'title', 'text', 'is_published', 'youtube_iframe', 'date', 'photo_file_id', 'photo_min_file_id'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}