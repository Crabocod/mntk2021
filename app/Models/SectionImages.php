<?php namespace App\Models;

use CodeIgniter\Model;

class SectionImages extends Model
{
    protected $table = 'section_images';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\SectionImages\SectionImage';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'sort_num', 'section_id', 'img_min_file_id', 'img_file_id'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}