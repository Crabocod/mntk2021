<?php namespace App\Controllers\Pages\OldConference;

use App\Entities\Chess\ChessView;
use App\Entities\Events\EventView;
use App\Entities\News\NewsView;
use App\Entities\Users\UserSession;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Models\Chess;
use App\Models\Conferences;
use App\Models\TeamQuests;
use App\Models\UserBarrels;
use App\Entities\Conferences\ConferenceView;
use App\Entities\TeamQuests\TeamQuestView;
use App\Models\News;
use App\Libraries\DateTime;

class Index extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new Conferences();
        $teamQuestsModel = new TeamQuests();
        $userBarrelsModel = new UserBarrels();
        $chessModel = new Chess();
        $eventsModel = new \App\Models\Events();
        $newsModel = new News();

        $user = UserSession::getUser();
        $searchData['conference_url_segment'] = $url_segment;
        $ubCountResult = $userBarrelsModel->countCreatedToday($searchData);

        $searchData['user_id'] = $user->id;
        $searchData['created_at_from'] = date('Y-m-d 00:00:00', DateTime::timeByUserTimeZone($user));
        $thisUserClicked = (count($userBarrelsModel->show_all($searchData)) > 0) ? true : false;

        $teamQuests = $teamQuestsModel->where('conference_id', $this->conference->id)->findAll();

        $chessModel->orderBy('date', 'asc');
        $chess = $chessModel->where('conference_id', $this->conference->id)->findAll();

        $eventsModel->where('conference_id', $this->conference->id);
        $eventsModel->limit(2);
        $eventsModel->where('date>', date('Y-m-d 23:59:59', DateTime::timeByUserTimeZone($user)));
        $eventsModel->orderBy('date', 'asc');
        $events = $eventsModel->find();

        $newsModel->where('conference_id', $this->conference->id);
        $newsModel->where('is_publication', 1);
        $newsModel->limit(2);
        $newsModel->orderBy('id', 'desc');
        $news = $newsModel->find();

        $data['user_surname'] = $user->surname;
        $data['user_name'] = $user->name;
        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $this->conference;
        $data['barrel_block'] = ConferenceView::getBarrelBlock($ubCountResult['id'], $thisUserClicked, $this->conference->barrels_max);
        $data['team_quest_section'] = TeamQuestView::getSection($teamQuests);
        $data['chess_section'] = ChessView::getChessSection($chess);
        foreach($events as $event)
            $data['event_card'][] = EventView::getEventCardIndex($event->toArray(), $url_segment);
        foreach($news as $item)
            $data['news_card'][] = NewsView::getNewsCardIndex($item->toArray(), $url_segment);

        echo view('pages/conference/index', $data);
    }

    public function addBarrel($url_segment)
    {
        try {
            $confModel = new Conferences();
            $userBarrels = new UserBarrels();
            $userBarrelsModel = new UserBarrels();
            $user = UserSession::getUser();

            // Проверяем не дублируется ли запись
            $searchData['conference_url_segment'] = $url_segment;
            $searchData['user_id'] = $user->id;
            $searchData['created_at_from'] = date('Y-m-d 00:00:00');
            $thisUserClicked = (count($userBarrelsModel->show_all($searchData)) > 0) ? true : false;
            if ($thisUserClicked)
                throw new \Exception(ErrorMessages::get(204));

            // Добавляем запись
            $insertData = [
                'user_id' => $user->id,
                'conference_id' => $this->conference->id
            ];
            $userBarrels->insert($insertData);

            // Вывод блока с баррелью
            $ubCountResult = $userBarrelsModel->countCreatedToday(['conference_url_segment' => $url_segment]);
            $percent = ($ubCountResult['id']/$this->conference->barrels_max)*100;

            Output::ok(['percent' => $percent]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}