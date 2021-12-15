<?php namespace App\Models;

use CodeIgniter\Model;

class UserBarrels extends Model
{
    protected $table = 'user_barrels';
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

    /**
     * Поиск по таблице
     * 
     * @param array $data
     * @return array
     */
    public function show_all($data = [])
    {
        if(isset($data['conference_url_segment'])) {
            $this->join('conferences c', 'c.id=conference_id', 'left');
            $this->where('c.url_segment', $data['conference_url_segment']);
        }
        if(isset($data['created_at_from']))
            $this->where('user_barrels.created_at>=', $data['created_at_from']);
        if(isset($data['created_at_to']))
            $this->where('user_barrels.created_at<=', $data['created_at_to']);
        if(isset($data['user_id']))
            $this->where('user_id', $data['user_id']);
        return $this->findAll();
    }

    /**
     * Выводит количество всех барелей на текущий день
     * 
     * @param array $data
     * @return array|object|null
     */
    public function countCreatedToday($data = [])
    {
        $this->selectCount('user_barrels.id');
        if(isset($data['conference_url_segment'])) {
            $this->join('conferences c', 'c.id=conference_id', 'left');
            $this->where('c.url_segment', $data['conference_url_segment']);
        }
        $this->where('user_barrels.created_at>=', date('Y-m-d 00:00:00'));
        return $this->first();
    }
}