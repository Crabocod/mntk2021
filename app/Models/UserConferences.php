<?php namespace App\Models;

use CodeIgniter\Model;

class UserConferences extends Model
{
    protected $table = 'user_conferences';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'conference_id', 'user_id'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function handleById($is = true)
    {
        $this->handleById = $is;
        return $this;
    }

    public function afterFindAll($data = [])
    {
        if (isset($data['data']) and $this->handleById === true) {
            $exts = Array();
            foreach ($data['data'] as $ext) {
                $exts[$ext['id']] = $ext;
            }
            $data['data'] = $exts;
        }
        return $data;
    }
}