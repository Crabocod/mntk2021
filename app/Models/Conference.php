<?php namespace App\Models;

use CodeIgniter\Model;

class Conference extends Model
{
    protected $table = 'conference';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Conferences\Conference';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'id',
        'title',
        'sub_title',
        'logo_file_id',
        'logo_min_file_id',
        'date',
        'specialist_num',
        'og_num',
        'experts_num',
        'sections_num',
        'projects_num',
        'timer',
        'eventicious_api_key',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}