<?php namespace App\Models;

use CodeIgniter\Model;

class FileExts extends Model
{
    protected $table = 'file_ext';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'title', 'file_extension'];

    protected $useTimestamps = false;

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