<?php namespace App\Models;

use CodeIgniter\Model;

class Chess extends Model
{
    protected $table = 'chess';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Chess\Chess';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'date', 'type', 'title', 'img_file_id', 'img_min_file_id', 'page_url'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}