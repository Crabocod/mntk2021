<?php namespace App\Models;

use CodeIgniter\Model;

class ArchiveFiles extends Model
{
    protected $table = 'archive_files';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ArchiveFiles\ArchiveFile';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'archive_id', 'title', 'link'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}