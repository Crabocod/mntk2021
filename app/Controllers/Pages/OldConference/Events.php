<?php namespace App\Controllers\Pages\OldConference;

use App\Entities\Events\EventView;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Entities\Users\UserSession;

class Events extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $eventsModel = new \App\Models\Events();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $this->conference;

        $dateFrom = date('Y-m-d 00:00:00', DateTime::timeByUserTimeZone(UserSession::getUser(), '+1 day'));
        $eventsModel->where('date>=', $dateFrom);
        $eventsModel->where('conference_id', $data['conferences']->id);
        $eventsModel->orderBy('date', 'asc');
        $events = $eventsModel->find();
        $data['events'] = EventView::getEventsCards($events, $url_segment);

        echo view('pages/conference/events', $data);
    }

    public function about($url_segment, $event_id)
    {
        $confModel = new \App\Models\Conferences();
        $eventsModel = new \App\Models\Events();
        $userEventsModel = new \App\Models\UserEvents();

        $user = UserSession::getUser();

        $eventsModel->where('id', $event_id);
        $eventsModel->where('conference_id', $this->conference->id);
        $event = $eventsModel->first();
        if(empty($event))
            Output::output(view('errors/html/error_404'));

        $sign = $userEventsModel->where('user_id', $user->id)->where('event_id', $event->id)->first();

        $data['event'] = EventView::getEventAbout($event, $url_segment, $sign);
        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $this->conference;

        echo view('pages/conference/event_about', $data);
    }

    public function signUp()
    {
        try {
            $get = $this->request->getGet();

            $user = UserSession::getUser();
            $event_id = $get['event_id'];

            $data = [
                'user_id' => $user->id,
                'event_id' => $event_id,
                'status' => 0
            ];
            $userEventsModel = new \App\Models\UserEvents();

            $sign = $userEventsModel->where('user_id', $user->id)->where('event_id', $event_id)->first();
            if ($sign == null) {
                $userEventsModel->insert($data);
                $status = 'ok';
            } else {
                $status = 'error';
            }

            Output::ok(['status' => $status]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}