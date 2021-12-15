<?php namespace App\Models;

use CodeIgniter\Model;

class Sections extends Model
{
    protected $table = 'sections';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Sections\Section';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'title', 'number', 'protection_date', 'is_publication', 'preview_file_id', 'preview_min_file_id', 'youtube_iframe'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}