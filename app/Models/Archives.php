<?php namespace App\Models;

use CodeIgniter\Model;

class Archives extends Model
{
    protected $table = 'archives';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Archives\Archive';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'title', 'date_from', 'full_text', 'short_text', 'date_to', 'speaker', 'preview_file_id', 'preview_min_file_id', 'presentation_file_id', 'presentation_min_file_id', 'photo_file_id', 'photo_min_file_id', 'youtube_iframe', 'is_published'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function show_all($data = []) {
        $this->select('archives.*');
        $this->select('preview_file.link as preview_file_link');
        $this->select('presentation_file.link as presentation_file_link');
        $this->select('photo_file.link as photo_file_link');
        $this->join('files preview_file','preview_file.id=archives.preview_file_id', 'left');
        $this->join('files presentation_file','presentation_file.id=archives.presentation_file_id', 'left');
        $this->join('files photo_file','photo_file.id=archives.photo_file_id', 'left');
        if(isset($data['is_published']))
            $this->where('is_published', $data['is_published']);
        $this->asArray();
        return $this->find();
    }
}