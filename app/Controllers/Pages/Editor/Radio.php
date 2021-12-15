<?php namespace App\Controllers\Pages\Editor;


use App\Entities\Conferences\ConferenceValid;
use App\Entities\RadioArchives\RadioArchive;
use App\Entities\RadioArchives\RadioArchiveValid;
use App\Entities\RadioArchives\RadioArchiveView;
use App\Entities\RadioSchedules\RadioScheduleValid;
use App\Entities\RadioSchedules\RadioScheduleView;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Conferences;
use App\Models\RadioSchedule;
use CodeIgniter\Model;

class Radio  extends BaseController
{
    public function index($conference_id)
    {
        $radioScheduleModel = new \App\Models\RadioSchedule();
        $radioArchiveModel = new \App\Models\RadioArchive();

        $radioArchive = $radioArchiveModel->where('conference_id', $conference_id)->findAll();
        $radioSchedule = $radioScheduleModel->where('conference_id', $conference_id)->findAll();

        $data['archives'] = RadioArchiveView::getEditorArchiveCards($radioArchive);
        $data['schedules'] = RadioScheduleView::getEditorScheduleCards($radioSchedule);
        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        echo view('pages/editor/radio', $data);
    }

    public function saveLive($conference_id)
    {
        try {
            $radioScheduleModel = new \App\Models\RadioSchedule();
            $radioSchedule = new \App\Entities\RadioSchedules\RadioSchedule();

            $file = $this->request->getFile('img');

            // Валидация
            $post = $this->request->getPost();
            RadioScheduleValid::save($post, $this->request);

            // Сохранение
            if($radioSchedule->saveImage($file) === false)
                $radioSchedule->img = '';
            $radioSchedule->fill($post);
            $radioSchedule->date = date('Y-m-d H:i:s', strtotime($post['date']));
            $time = DateTime::setTime($post['date'], $post['date_from']);
            $radioSchedule->date_from = DateTime::fromUserTimeZone(UserSession::getUser(), $time);
            $time = DateTime::setTime($post['date'], $post['date_to']);
            $radioSchedule->date_to = DateTime::fromUserTimeZone(UserSession::getUser(), $time);
            $radioSchedule->conference_id = $this->conference->id;
            $radioScheduleModel->save($radioSchedule);

            $radioSchedule->id = $radioScheduleModel->getInsertID();
            Output::ok([
                'html' => RadioScheduleView::getEditorScheduleCard($radioSchedule->toArray()),
                'message' => SuccessMessages::get(1700)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function updateLive($conference_id)
    {
        try {
            $radioScheduleModel = new \App\Models\RadioSchedule();
            $radioSchedule = new \App\Entities\RadioSchedules\RadioSchedule();

            $file = $this->request->getFile('img');

            // Валидация
            $post = $this->request->getPost();
            RadioScheduleValid::save($post, $this->request);

            // Сохранение
            if(!empty($post['deleted_img']))
                $radioSchedule->img = '';
            if($radioSchedule->saveImage($file) === false and empty($post['id']))
                $radioSchedule->img = '';
            $radioSchedule->fill($post);
            $radioSchedule->date = date('Y:m:d', strtotime($post['date']));
            $time = DateTime::setTime($post['date'], $post['date_from']);
            $radioSchedule->date_from = DateTime::fromUserTimeZone(UserSession::getUser(), $time);
            $time = DateTime::setTime($post['date'], $post['date_to']);
            $radioSchedule->date_to = DateTime::fromUserTimeZone(UserSession::getUser(), $time);
            $radioSchedule->conference_id = $this->conference->id;
            $radioScheduleModel->save($radioSchedule);

            Output::ok([
                'html' => RadioScheduleView::getEditorScheduleCard($radioSchedule->toArray()),
                'message' => SuccessMessages::get(1701)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveMainSchedule($conference_id) {
        try {
            $confereceModel = new Conferences();

            $image_1 = $this->request->getFile('radio_main_schedule_img1');
            $image_2 = $this->request->getFile('radio_main_schedule_img2');

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            ConferenceValid::saveRadioMainSchedule($post, $this->request);

            // Сохранение
            if(!empty($post['deleted_image_1']))
                $this->conference->radio_main_schedule_img1 = '';
            if(!empty($post['deleted_image_2']))
                $this->conference->radio_main_schedule_img2 = '';
            $this->conference->saveRadioMainScheduleImage1($image_1);
            $this->conference->saveRadioMainScheduleImage2($image_2);
            $this->conference->radio_main_schedule_text = $post['radio_main_schedule_text'];

            if ($this->conference->hasChanged())
                $confereceModel->save($this->conference);

            Output::ok(['message' => SuccessMessages::get(307)]);
        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveArchive($conference_id)
    {
        try {
            $radioArchiveModel = new \App\Models\RadioArchive();
            $radioArchive = new \App\Entities\RadioArchives\RadioArchive();


            $file = $this->request->getFile('audio');
            $fileName = $file->getName();

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            RadioArchiveValid::saveRadioItems($post, $this->request);

            // Сохранение
            $radioArchive->saveAudioFile($file);
            $radioArchive->audio_name = $fileName;
            $radioArchive->fill($post);
            $radioArchive->date = date('Y-m-d H:i:s', strtotime($post['date']));
            $radioArchive->conference_id = $this->conference->id;

            if ($radioArchive->hasChanged())
                $radioArchiveModel->save($radioArchive);

            $radioArchive->id = $radioArchiveModel->getInsertID();
            Output::ok([
                'message' => SuccessMessages::get(1800),
                'html' => RadioArchiveView::getEditorArchiveCard($radioArchive->toArray())
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function updateArchive($conference_id)
    {
        try {
            $radioArchiveModel = new \App\Models\RadioArchive();
            $radioArchive = new \App\Entities\RadioArchives\RadioArchive();


            $file = $this->request->getFile('audio');
            $fileName = $file->getName();

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            RadioArchiveValid::saveRadioItems($post, $this->request);

            // Сохранение
            $radioArchive->id = $post['id'];
            if ($post['audio_change'] == 1) {
                $radioArchive->saveAudioFile($file);
                $radioArchive->audio_name = $fileName;
            }

            $radioArchive->fill($post);
            $radioArchive->date = date('Y:m:d', strtotime($post['date']));
            $radioArchive->conference_id = $this->conference->id;

            if ($radioArchive->hasChanged())
                $radioArchiveModel->save($radioArchive);

            Output::ok([
                'message' => SuccessMessages::get(1801),
                'html' => RadioArchiveView::getEditorArchiveCard($radioArchive->toArray())
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteLive($conference_id)
    {
        try {
            $radioScheduleModel = new \App\Models\RadioSchedule();
            $post = $this->request->getPost();
            $radioScheduleModel->where('conference_id', $conference_id)->where('id', $post['id'])->delete();
            Output::ok(['message' => SuccessMessages::get(1702)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteArchive($conference_id)
    {
        try {
            $radioArchiveModel = new \App\Models\RadioArchive();
            $post = $this->request->getPost();
            $radioArchiveModel->where('conference_id', $conference_id)->where('id', $post['id'])->delete();
            Output::ok(['message' => SuccessMessages::get(1802)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveRadio($conference_id)
    {
        try {
            $confereceModel = new Conferences();

            $file = $this->request->getFile('radio_audio');

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            ConferenceValid::saveRadioItems($post, $this->request);

            // Сохранение
            $this->conference->saveAudioFile($file);
            if(!empty($post['deleted_audio'])) {
                $this->conference->radio_audio = '';
                $this->conference->radio_audio_name = '';
            }
            $this->conference->radio_title = $post['radio_title'];
            if (isset($post['radio_iframe']))
                $this->conference->radio_iframe = $post['radio_iframe'];
            if (!empty($post['radio_date_from'])) {
                $time = DateTime::setTime(date('Y-m-d'), $post['radio_date_from']);
                $this->conference->radio_date_from = DateTime::fromUserTimeZone(UserSession::getUser(), $time);
            }
            if (!empty($post['radio_date_to'])) {
                $time = DateTime::setTime(date('Y-m-d'), $post['radio_date_to']);
                $this->conference->radio_date_to = DateTime::fromUserTimeZone(UserSession::getUser(), $time);
            }
            if ($this->conference->hasChanged())
                $confereceModel->save($this->conference);

            Output::ok(['message' => SuccessMessages::get(307)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}