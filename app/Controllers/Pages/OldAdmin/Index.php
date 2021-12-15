<?php namespace App\Controllers\Pages\OldAdmin;

use App\Entities\Conferences\Conference;
use App\Entities\Conferences\ConferenceValid;
use App\Entities\Conferences\ConferenceView;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Archives;
use App\Models\Conferences;
use App\Models\Events;
use App\Models\Sections;

class Index extends BaseController
{
    public function index()
    {
        $conferencesModel = new Conferences();

        $conferences = $conferencesModel->findAll();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['table_rows'] = ConferenceView::getTableRows($conferences);
        echo view('pages/admin/index', $data);
    }

    public function saveConference()
    {
        try {
            $conferencesModel = new Conferences();

            // Валидация
            $post = $this->request->getPost();
            ConferenceValid::save($post);

            // Проверка на дублирование
            if(isset($post['id']))
                $conferencesModel->where('id!=', $post['id']);
            $conferencesModel->where('url_segment', $post['url_segment']);
            $result = $conferencesModel->first();
            if(!empty($result))
                throw new \Exception(ErrorMessages::get(301));

            // Проверяем на служебные пути верхнего уровня
            if(in_array($post['url_segment'], ['admin', 'editor']))
                throw new \Exception(ErrorMessages::get(305));

            // Сохранение конференции
            $conference = new Conference();
            $conference->fill($post);
            $conferencesModel->save($conference);

            if(empty($conference->id))
                $conference->id = $conferencesModel->getInsertID();
            
            $html = ConferenceView::getTableRow($conference->toArray());
            Output::ok(['html' => $html, 'message' => SuccessMessages::get(300)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteConference()
    {
        try {
            $conferencesModel = new Conferences();
            $archivesModel = new Archives();
            $eventsModel = new Events();
            $sectionsModel = new Sections();

            // Валидация
            $post = $this->request->getPost();
            ConferenceValid::delete($post);

            // Проверка на различные сущности
            if($eventsModel->where('conference_id', $post['id'])->first())
                throw new \Exception(ErrorMessages::get(302));
            if($archivesModel->where('conference_id', $post['id'])->first())
                throw new \Exception(ErrorMessages::get(303));
            if($sectionsModel->where('conference_id', $post['id'])->first())
                throw new \Exception(ErrorMessages::get(304));

            // Удаление
            $conferencesModel->delete($post['id']);

            Output::ok(['message' => SuccessMessages::get(301)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}