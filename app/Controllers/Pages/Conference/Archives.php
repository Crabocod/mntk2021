<?php namespace App\Controllers\Pages\Conference;

use App\Libraries\Output;

class Archives extends BaseController
{
    public function index()
    {
        $archiveModel = new \App\Models\Archives();

        $archiveModel->select('archives.*');
        $archiveModel->select('preview_file.link as preview_file_link');
        $archiveModel->select('preview_min_file.link as preview_min_file_link');
        $archiveModel->join('files preview_file', 'preview_file.id=archives.preview_file_id', 'left');
        $archiveModel->join('files preview_min_file', 'preview_min_file.id=archives.preview_min_file_id', 'left');
        $archiveModel->orderBy('date_from', 'DESC');
        $data['archives'] = $archiveModel->asArray()->where('is_published', 1)->find();

        echo view('pages/conference/archive', $data);
    }
}