<?php namespace App\Models;

use CodeIgniter\Model;

class SectionJury extends Model
{
    protected $table = 'section_jury';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\SectionJury\SectionJury';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'section_id', 'speaker'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}