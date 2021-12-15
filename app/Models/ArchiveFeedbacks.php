<?php namespace App\Models;

use CodeIgniter\Model;

class ArchiveFeedbacks extends Model
{
    protected $table = 'archive_feedbacks';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ArchiveFeedbacks\ArchiveFeedback';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'archive_id', 'user_id', 'text'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function show_all($data = [])
    {
        $this->select('archive_feedbacks.*');
        if(isset($data['with_user'])) {
            $this->select('u.name as user_name');
            $this->select('u.surname as user_surname');
            $this->join('users u', 'u.id=archive_feedbacks.user_id', 'left');
        }
        if(isset($data['archive_id']))
            $this->where('archive_feedbacks.archive_id', $data['archive_id']);
        $this->orderBy('archive_feedbacks.created_at', 'desc');
        return $this->find();
    }
}