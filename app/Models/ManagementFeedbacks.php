<?php namespace App\Models;

use CodeIgniter\Model;

class ManagementFeedbacks extends Model {
    protected $table = 'management_feedbacks';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ManagementFeedbacks\ManagementFeedback';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'conference_id', 'user_id', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function show_all($data = [])
    {
        $this->select('management_feedbacks.*');
        if(isset($data['with_user'])) {
            $this->select('u.name as user_name');
            $this->select('u.surname as user_surname');
            $this->join('users u', 'u.id=management_feedbacks.user_id', 'left');
        }
        if(isset($data['conference_id']))
            $this->where('management_feedbacks.conference_id', $data['conference_id']);
        $this->orderBy('management_feedbacks.created_at', 'desc');
        return $this->find();
    }
}
