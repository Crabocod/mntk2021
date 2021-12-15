<?php namespace App\Models;

use CodeIgniter\Model;

class RadioArchive extends Model
{
    protected $table = 'radio_archive';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\RadioArchives\RadioArchive';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'conference_id', 'date', 'title', 'speaker', 'text', 'audio', 'audio_name'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}