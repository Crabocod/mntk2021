<?php namespace App\Models;

use CodeIgniter\Model;

class Events extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Events\Event';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'event_type_id', 'title', 'speaker', 'date_from', 'date_to', 'about_speaker', 'short_text', 'full_text', 'preview_file_id', 'presentation_file_id', 'photo_file_id',  'preview_min_file_id', 'presentation_min_file_id', 'photo_min_file_id', 'youtube_iframe', 'show_button'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}