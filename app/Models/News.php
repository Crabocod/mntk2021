<?php namespace App\Models;

use CodeIgniter\Model;

class News extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\News\News';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'title', 'date', 'short_text', 'full_text', 'youtube_iframe', 'photo_file_id', 'photo_min_file_id', 'is_publication'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}