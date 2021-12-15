<?php namespace App\Controllers\Pages\OldConference;

use App\Entities\Conferences\ConferenceView;
use App\Entities\RadioArchives\RadioArchiveView;
use App\Entities\RadioSchedules\RadioScheduleView;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Models\RadioSchedule;

class Radio extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $radioScheduleModel = new \App\Models\RadioSchedule();
        $radioArchiveModel = new \App\Models\RadioArchive();

        $user = UserSession::getUser();
        $data['user_surname'] = $user->surname;
        $data['user_name'] = $user->name;

        $conference = $confModel->where('url_segment', $url_segment)->first();
        $dateFrom = date('Y-m-d 0:0:0', DateTime::timeByUserTimeZone(UserSession::getUser()));
        $radioScheduleModel->where('conference_id', $conference->id)->orderBy('date', 'asc');
        $radioSchedule = $radioScheduleModel->where('date>=', $dateFrom)->findAll();

        $radioArchive = $radioArchiveModel->where('conference_id', $conference->id)->orderBy('date', 'asc')->findAll();
        $archivePages = $radioArchiveModel->where('conference_id', $conference->id)->countAllResults()/3;

        $data['radio_head'] = ConferenceView::getRadioHead($conference->toArray());
        $data['radio_schedule'] = RadioScheduleView::getScheduleCards($radioSchedule);
        $data['radio_archive'] = RadioArchiveView::getArchiveCards($radioArchive);
        $data['radio_archive_pages'] = RadioArchiveView::getArchivePages($archivePages);
        $data['conferences'] = $conference;

        echo view('pages/conference/radio', $data);
    }
}