<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Models\Archives;

class ArchiveAbout extends BaseController
{
    public function index($id)
    {
        $archivesModel = new Archives();

        $archivesModel->select('archives.*');
        $archivesModel->select('preview_file.title as preview_file_title');
        $archivesModel->select('presentation_file.title as presentation_file_title');
        $archivesModel->select('photo_file.title as photo_file_title');
        $archivesModel->join('files preview_file', 'preview_file.id=archives.preview_file_id', 'left');
        $archivesModel->join('files presentation_file', 'presentation_file.id=archives.presentation_file_id', 'left');
        $archivesModel->join('files photo_file', 'photo_file.id=archives.photo_file_id', 'left');
        $archive = $archivesModel->where('archives.id', $id)->asArray()->first();
        if(empty($archive))
            Output::output(view('errors/html/error_404'));

        if(!empty($archive['date_from']))
            $archive['date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $archive['date_from']);

        echo view('pages/admin/archive_about', $archive);
    }
}