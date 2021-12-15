<?php namespace App\Controllers\Pages\Conference;

use App\Entities\Events\EventValid;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\EventGallery;
use App\Models\UserEventFeedbacks;
use App\Models\UserEvents;

class Events extends BaseController
{
    public function index($event_id)
    {
        $userEventsModel = new UserEvents();
        $userSession = UserSession::getUser();
        $eventsModel = new \App\Models\Events();
        $eventGalleryModel = new EventGallery();
        $userEventFeedbacksModel = new UserEventFeedbacks();

        $eventsModel->select('events.*');
        $eventsModel->select('preview_file.link as preview_file_link');
        $eventsModel->select('photo_file.link as photo_file_link');
        $eventsModel->select('photo_min_file.link as photo_min_file_link');
        $eventsModel->select('presentation_file.link as presentation_file_link');
        $eventsModel->select('et.title as event_type_title');
        $eventsModel->join('event_types et', 'et.id=events.event_type_id', 'left');
        $eventsModel->join('files preview_file', 'preview_file.id=events.preview_file_id', 'left');
        $eventsModel->join('files photo_file', 'photo_file.id=events.photo_file_id', 'left');
        $eventsModel->join('files photo_min_file', 'photo_min_file.id=events.photo_min_file_id', 'left');
        $eventsModel->join('files presentation_file', 'presentation_file.id=events.presentation_file_id', 'left');
        $event = $eventsModel->asArray()->where('events.id', $event_id)->first();
        if(empty($event))
            Output::output(view('errors/html/error_404'));

        if(!empty($event['date_from']))
            $event['date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $event['date_from']);
        if(!empty($event['date_to']))
            $event['date_to'] = DateTime::byUserTimeZone(UserSession::getUser(), $event['date_to']);

        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern('d MMMM');
        $event['date'] = $formatter->format(new \DateTime($event['date_from']));
        $event['duration'] = date('H:i', strtotime($event['date_from'])).' - '.date('H:i', strtotime($event['date_to']));

        $eventGalleryModel->select('event_gallery.*');
        $eventGalleryModel->select('photo_file.link as photo_file_link');
        $eventGalleryModel->select('photo_min_file.link as photo_min_file_link');
        $eventGalleryModel->join('files photo_file', 'photo_file.id=event_gallery.photo_file_id', 'left');
        $eventGalleryModel->join('files photo_min_file', 'photo_min_file.id=event_gallery.photo_min_file_id', 'left');
        $eventGalleryModel->orderBy('sort_num', 'ASC');
        $event['gallery'] = $eventGalleryModel->where('event_id', $event['id'])->find();

        $event['this_user_signed'] = false;
        $userEvent = $userEventsModel->where('user_id', $userSession->id)->where('event_id', $event_id)->first();
        if(!empty($userEvent))
            $event['this_user_signed'] = true;

        $userEventFeedbacksModel->select('user_event_feedbacks.*');
        $userEventFeedbacksModel->select('u.full_name as user_full_name');
        $userEventFeedbacksModel->join('users u', 'u.id=user_event_feedbacks.user_id', 'left');
        $event['feedbacks'] = $userEventFeedbacksModel->where('event_id', $event_id)->find();

        echo view('pages/conference/events', $event);
    }

    public function signup($event_id)
    {
        try {
            $eventsModel = new \App\Models\Events();
            $userSession = UserSession::getUser();
            $userEventsModel = new UserEvents();

            $event = $eventsModel->where('id', $event_id)->first();
            if(empty($event))
                throw new \Exception(ErrorMessages::get(1200));

            $duplicate = $userEventsModel->where('user_id', $userSession->id)->where('event_id', $event_id)->first();
            if(!empty($duplicate))
                throw new \Exception(ErrorMessages::get(1201));

            $userEventsModel->insert([
                'user_id' => $userSession->id,
                'event_id' => $event_id
            ]);

            Output::ok(['message' => SuccessMessages::get(1204)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function addFeedback($event_id)
    {
        try {
            $userSession = UserSession::getUser();
            $userEventFeedbacksModel = new UserEventFeedbacks();

            $post = $this->request->getPost();
            EventValid::addFeedback($post);

            $userEventFeedbacksModel->insert([
                'user_id' => $userSession->id,
                'event_id' => $event_id,
                'text' => $post['text'],
                'grade' => $post['grade']
            ]);

            $id = $userEventFeedbacksModel->getInsertID();

            $userEventFeedbacksModel->select('user_event_feedbacks.*');
            $userEventFeedbacksModel->select('u.full_name as user_full_name');
            $userEventFeedbacksModel->join('users u', 'u.id=user_event_feedbacks.user_id', 'left');
            $feedback = $userEventFeedbacksModel->where('user_event_feedbacks.id', $id)->first();

            $feedback = view('templates/conference/all/feedback_row', ['feedback' => $feedback]);

            Output::ok([
                'message' => SuccessMessages::get(1205),
                'html' => $feedback
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}