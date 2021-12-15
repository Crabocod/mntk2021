<?php namespace App\Controllers\Pages\Editor;

use App\Entities\Chess\ChessValid;
use App\Entities\Chess\ChessView;
use App\Entities\Conferences\Conference;
use App\Entities\Conferences\ConferenceValid;
use App\Entities\Files\File;
use App\Entities\Files\FileValid;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Chess;
use App\Models\Conferences;

class Index extends BaseController
{
    public function index()
    {
        $chessModel = new Chess();

        $chessModel->where('conference_id', $this->conference->id);
        $chessModel->orderBy('date', 'desc');
        $chess = $chessModel->findAll();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['conference']['radio_date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $data['conference']['radio_date_from']);
        $data['conference']['radio_date_to'] = DateTime::byUserTimeZone(UserSession::getUser(), $data['conference']['radio_date_to']);
        $data['chess'] = ChessView::getTableRows($chess);
        echo view('pages/editor/index', $data);
    }

    public function saveConference($conference_id)
    {
        try {
            $confereceModel = new Conferences();

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            ConferenceValid::saveMainItems($post);

            // Сохранение
            if(isset($post['widget']))
                $this->conference->widget = $post['widget'];
            if(isset($post['ticker']))
                $this->conference->ticker = $post['ticker'];
            if(isset($post['show_main_block']))
                $this->conference->show_main_block = $post['show_main_block'];
            if(isset($post['show_timer_block']))
                $this->conference->show_timer_block = $post['show_timer_block'];
            if(isset($post['show_ether_block']))
                $this->conference->show_ether_block = $post['show_ether_block'];
            if(isset($post['show_eventsnews_block']))
                $this->conference->show_eventsnews_block = $post['show_eventsnews_block'];
            if(isset($post['timer_datetime']))
                $this->conference->timer_datetime = DateTime::fromUserTimeZone(UserSession::getUser(), $post['timer_datetime']);
            if(isset($post['ether_iframe']))
                $this->conference->ether_iframe = $post['ether_iframe'];
            if ($this->conference->hasChanged())
                $confereceModel->save($this->conference);

            Output::ok(['message' => SuccessMessages::get(300)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveBarrels($conference_id)
    {
        try {
            $confereceModel = new Conferences();

            // Валидация
            $post = $this->request->getPost();
            ConferenceValid::saveBarrels($post);

            // Сохранение
            $this->conference->barrels_max = $post['barrels_max'];

            if ($this->conference->hasChanged())
                $confereceModel->save($this->conference);

            Output::ok(['message' => SuccessMessages::get(306)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveGr($conference_id)
    {
        try {
            $confereceModel = new Conferences();

            $file = $this->request->getFile('gr_logo');
            $fileName = $file->getName();

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            ConferenceValid::saveGrItems($post, $this->request);

            // Сохранение
            $this->conference->saveGrLogo($file);
            $this->conference->gr_logo_name = $fileName;
            $this->conference->gr_title = $post['gr_title'];
//            $this->conference->gr_video = $post['gr_video'];
            $this->conference->gr_text = $post['gr_text'];
            if ($this->conference->hasChanged())
                $confereceModel->save($this->conference);

            Output::ok(['message' => SuccessMessages::get(302)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveRadio($conference_id)
    {
        try {
            $confereceModel = new Conferences();

            $file = $this->request->getFile('radio_audio');
            $fileName = $file->getName();

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            ConferenceValid::saveRadioItems($post, $this->request);

            // Сохранение
            if (!empty($file)) {
                $this->conference->saveAudioFile($file);
                $this->conference->radio_audio_name = $fileName;
            }
            $this->conference->radio_title = $post['radio_title'];
            if (isset($post['radio_iframe']))
                $this->conference->radio_iframe = $post['radio_iframe'];
            if (isset($post['radio_date_from'])) {
                $time = DateTime::setTime(date('Y-m-d'), $post['radio_date_from']);
                $this->conference->radio_date_from = DateTime::fromUserTimeZone(UserSession::getUser(), $time);
            }
            if (isset($post['radio_date_to'])) {
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

    public function saveChess($conference_id)
    {
        try {
            $chessModel = new Chess();
            $chess = new \App\Entities\Chess\Chess();

            $file = $this->request->getFile('img_link');

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            ChessValid::save($post, $this->request);

            // Сохранение
            if(!empty($post['id']) and !empty($post['deleted_icon']))
                $chess->img_link = 'img/shahmatka.svg';
            if(($chess->saveIcon($file) === false and empty($post['id'])))
                $chess->img_link = 'img/shahmatka.svg';
            $chess->date = DateTime::fromUserTimeZone(UserSession::getUser(), $post['date']);
            $chess->type = $post['type'];
            $chess->title = $post['title'];
            $chess->page_url = $post['page_url'];
            $chess->conference_id = $this->conference->id;
            if(isset($post['id']))
                $chess->id = $post['id'];
            if ($chess->hasChanged())
                $chessModel->save($chess);
            
            $chess->id = $chessModel->getInsertID();

            Output::ok([
                'html' => ChessView::getTableRow($chess->toArray()),
                'message' => SuccessMessages::get(500)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteChess($conference_id)
    {
        try {
            $chessModel = new Chess();

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            ChessValid::delete($post);

            // Сохранение
            $chessModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(501)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveCkeditorImage()
    {
        try {
            $file = $this->request->getFile('upload');

            // Валидация
            ConferenceValid::saveCkeditorImage($this->request);

            // Сохранение
            $conference = new Conference();
            $result = $conference->saveCkeditorImage($file);
            if($result === false)
                throw new \Exception(ErrorMessages::$messages[77]);

            Output::ok(['url' => base_url($result)]);

        } catch (\Exception $e) {
            Output::error(['error' => [
                'message' => $e->getMessage()
            ]]);
        }
    }
}