<?php namespace App\Models;

use CodeIgniter\Model;

class UserSync extends Model
{
    protected $table = 'user_sync';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'user_id', 'conference_id', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

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
            $items = Array();
            foreach ($data['data'] as $item) {
                $items[$item['id']] = $item;
            }
            $data['data'] = $items;
        }
        return $data;
    }
}