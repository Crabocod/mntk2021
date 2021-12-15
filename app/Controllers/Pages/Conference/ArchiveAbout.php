<?php namespace App\Controllers\Pages\Conference;

use App\Entities\Users\UserSession;
use App\Libraries\DateFormatter;
use App\Libraries\DateTime;
use App\Libraries\Output;

class ArchiveAbout extends BaseController
{
    public function index($id)
    {
        $dateFormatter = new DateFormatter();
        $archiveModel = new \App\Models\Archives();

        $archiveModel->select('archives.*');
        $archiveModel->select('photo_file.link as photo_file_link');
        $archiveModel->select('photo_min_file.link as photo_min_file_link');
        $archiveModel->join('files photo_file', 'photo_file.id=archives.photo_file_id', 'left');
        $archiveModel->join('files photo_min_file', 'photo_min_file.id=archives.photo_min_file_id', 'left');
        $data['archive'] = $archiveModel->asArray()->where('archives.id', $id)->where('is_published', 1)->first();
        if(empty($data['archive']))
            Output::output(view('errors/html/error_404'));

        if(!empty($data['date_from']))
            $data['date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $data['date_from']);

        if(!empty($data['archive']['date_from']))
            $data['archive']['formatted_date_from'] = $dateFormatter->withRelativeDate()->format_3($data['archive']['date_from']);

        $data['archive']['photo_link'] = '';
        if(!empty($data['archive']['photo_min_file_link']))
            $data['archive']['photo_link'] = $data['archive']['photo_min_file_link'];
        elseif(!empty($data['archive']['photo_file_link']))
            $data['archive']['photo_link'] = $data['archive']['photo_file_link'];

        echo view('pages/conference/archive-about', $data);
    }
}