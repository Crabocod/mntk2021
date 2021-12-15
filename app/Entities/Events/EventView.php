<?php namespace App\Entities\Events;

use App\Entities\Users\UserSession;
use CodeIgniter\Entity;
use App\Libraries\DateTime;
use Config\Services;

class EventView extends Entity
{
    public static function getEventsCards($events, $url_segment)
    {
        $cards = '';
        foreach ($events as $event) {
            $event = $event->toRawArray();
            $cards .= self::getEventCard($event, $url_segment);
        }
        return $cards;
    }

    public static function getEventCard(array $event, $url_segment)
    {
        $event['url_segment'] = $url_segment;
        $event['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $event['date']);
        $event['time'] = date('H:i', strtotime($event['date']));
        $event['date'] = self::getRuDate($event['date']);

        return view('templates/conference/events/event_card', $event);
    }


    public static function getEventAbout($event, $url_segment, $sign){
        $event = $event->toRawArray();
        $event['url_segment'] = $url_segment;
        $event['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $event['date']);
        $event['time'] = date('H:i', strtotime($event['date']));
        $event['date'] = self::getRuDate($event['date']);
        if ($sign == null) {
            $event['sign_class'] = '';
            $event['sign_text'] = 'Записаться';
        }
        elseif ($sign->status == 0) {
            $event['sign_class'] = 'sign1';
            $event['sign_text'] = 'Записаться';
        }
        elseif ($sign->status == 1){
            $event['sign_class'] = 'sign2';
            $event['sign_text'] = 'Успешно';
        }

        elseif ($sign->status == 2){
            $event['sign_class'] = 'sign3';
            $event['sign_text'] = 'Отказано';
        }



        return view('templates/conference/events/event_about', $event);
    }

    public static function getRuDate($date)
    {
        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern('d MMMM');
        return $formatter->format(new \DateTime($date));
    }


    public static function getEventsCardsIndex($events, $url_segment)
    {
        $cards = '';
        foreach ($events as $event) {
            $event = $event->toRawArray();
            $cards .= self::getEventCardIndex($event, $url_segment);
        }
        return $cards;
    }

    public static function getEventCardIndex(array $event, $url_segment)
    {
        $event['date'] = self::getRuDate($event['date']);

        $event['url_segment'] = $url_segment;
        return view('templates/conference/index/event_card', $event);
    }

    public static function getEditorEventsCards($events, $userEvents, $event_type_segment = '')
    {
        $cards = '';
        foreach ($events as $event) {
            $event = $event->toRawArray();

            $memberCount = 0;
            $waitingCount = 0;
            foreach ($userEvents as $userEvent){
                $userEvent = $userEvent->toRawArray();
                if($userEvent['event_id'] == $event['id'] && $userEvent['status'] == 1)
                    $memberCount++;
                if($userEvent['event_id'] == $event['id'] && $userEvent['status'] == 0)
                    $waitingCount++;
            }

            $cards .= self::getEditorEventCard($event, $memberCount, $waitingCount, $event_type_segment);
        }
        return $cards;
    }

    public static function getEditorEventCard(array $event, $memberCount, $waitingCount, $event_type_segment = '')
    {
        $event['date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $event['date_from']);
        $event['formatted_date_from'] = DateTime::formatRu($event['date_from'], 'd MMMM');
        $event['time_from'] = DateTime::formatRu($event['date_from'], 'HH:mm');
        $event['memberCount'] = $memberCount;
        $event['waitingCount'] = $waitingCount;
        $event['event_type_segment'] = $event_type_segment;

        return view('templates/editor/events/event_card', $event);
    }

    public static function getEditorEventAbout($event, $userEvents)
    {
        $event = $event->toRawArray();
        $event['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $event['date']);

        $userCards = '';
        foreach ($userEvents as $userEvent){
            $userEvent = $userEvent->toRawArray();
            $userCards .= self::getUserEventCard($userEvent);
        }

        $event['userCards'] = $userCards;
        return view('templates/editor/events/event_about_card', $event);
    }

    public static function getUserEventCard($userEvent){
        return view('templates/editor/events/user_event_card', $userEvent);
    }
}
