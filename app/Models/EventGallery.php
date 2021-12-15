<?php namespace App\Models;

use CodeIgniter\Model;

class EventGallery extends Model
{
    protected $table = 'event_gallery';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'event_id', 'photo_file_id', 'photo_min_file_id', 'sort_num'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}