<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Models\EventGallery;
use App\Models\UserEventFeedbacks;

class EventsAbout extends BaseController
{
    public function index($event_id)
    {
        $eventModel = new \App\Models\Events();
        $eventGalleryModel = new EventGallery();
        $userEventsModel = new \App\Models\UserEvents();
        $userEventFeedbacksModel = new UserEventFeedbacks();

        $eventModel->select('events.*');
        $eventModel->select('preview_file.title as preview_file_title');
        $eventModel->select('presentation_file.title as presentation_file_title');
        $eventModel->select('photo_file.title as photo_file_title');
        $eventModel->join('files preview_file', 'preview_file.id=events.preview_file_id', 'left');
        $eventModel->join('files presentation_file', 'presentation_file.id=events.presentation_file_id', 'left');
        $eventModel->join('files photo_file', 'photo_file.id=events.photo_file_id', 'left');
        $event = $eventModel->where('events.id', $event_id)->asArray()->first();
        if(empty($event))
            Output::output(view('errors/html/error_404'));

        if(!empty($event['date_from']))
            $event['date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $event['date_from']);
        if(!empty($event['date_to']))
            $event['date_to'] = DateTime::byUserTimeZone(UserSession::getUser(), $event['date_to']);

        $userEventsModel->select('user_events.*');
        $userEventsModel->select('users.full_name as user_full_name');
        $userEventsModel->select('users.email as user_email');
        $userEventsModel->select('users.id as user_id');
        $userEventsModel->join('users', 'users.id = user_events.user_id', 'left');
        $userEventsModel->where('event_id', $event_id);
        $event['users'] = $userEventsModel->findAll();

        $eventGalleryModel->select('event_gallery.*');
        $eventGalleryModel->select('photo_file.link as photo_file_link');
        $eventGalleryModel->select('photo_min_file.link as photo_min_file_link');
        $eventGalleryModel->join('files photo_file', 'photo_file.id=event_gallery.photo_file_id', 'left');
        $eventGalleryModel->join('files photo_min_file', 'photo_min_file.id=event_gallery.photo_min_file_id', 'left');
        $eventGalleryModel->orderBy('sort_num', 'ASC');
        $event['gallery'] = $eventGalleryModel->where('event_id', $event_id)->find();

        $userEventFeedbacksModel->select('user_event_feedbacks.*');
        $userEventFeedbacksModel->select('u.full_name as user_full_name');
        $userEventFeedbacksModel->join('users u', 'u.id=user_event_feedbacks.user_id', 'left');
        $event['feedbacks'] = $userEventFeedbacksModel->where('event_id', $event_id)->find();

        $event['url_segment'] = '';
        if($event['event_type_id'] == 1)
            $event['url_segment'] = 'master-classes';
        elseif($event['event_type_id'] == 2)
            $event['url_segment'] = 'experts';
        elseif($event['event_type_id'] == 3)
            $event['url_segment'] = 'lounge-time';
        elseif($event['event_type_id'] == 4)
            $event['url_segment'] = 'oil-english-club';

        echo view('pages/admin/events_about', $event);
    }
}