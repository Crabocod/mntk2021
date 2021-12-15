<?php namespace App\Models;

use CodeIgniter\Model;

class MemberGroups extends Model
{
    protected $table = 'member_groups';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\MemberGroups\MemberGroup';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'conference_id', 'text', 'img'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}