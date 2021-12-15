<?php namespace App\Models;

use CodeIgniter\Model;

class TeamQuests extends Model
{
    protected $table = 'team_quest';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\TeamQuests\TeamQuest';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'conference_id', 'title', 'points'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}