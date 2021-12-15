<?php namespace App\Models;

use CodeIgniter\Model;

class RadioSchedule extends Model
{
    protected $table = 'radio_schedule';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\RadioSchedules\RadioSchedule';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'conference_id', 'date', 'title', 'img', 'date_from', 'date_to', 'speaker', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}