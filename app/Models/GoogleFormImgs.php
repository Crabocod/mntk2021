<?php namespace App\Models;

use CodeIgniter\Model;

class GoogleFormImgs extends Model
{
    protected $table = 'google_form_imgs';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\GoogleFormImgs\GoogleFormImg';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'sort_num', 'conference_id', 'img', 'img_min'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}