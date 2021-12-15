<?php namespace App\Entities\RadioSchedules;

use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use CodeIgniter\Entity;

class RadioScheduleView extends Entity
{
    public static function getScheduleCards($schedule)
    {
        $cards = '';
        foreach ($schedule as $item) {
            $item = $item->toRawArray();
            $cards .= self::getScheduleCard($item);
        }
        return $cards;
    }

    public static function getScheduleCard(array $item)
    {
        $item['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date']);
        $item['date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date_from']);
        $item['date_to'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date_to']);
        $item['date'] = DateTime::formatRu($item['date'], 'd MMMM');
        $item['date_from'] = DateTime::formatRu($item['date_from'], 'HH:mm');
        $item['date_to'] = DateTime::formatRu($item['date_to'], 'HH:mm');
        return view('templates/conference/radio/schedule_item', $item);
    }

    public static function getEditorScheduleCards($schedule)
    {
        $cards = '';
        foreach ($schedule as $item) {
            $item = $item->toRawArray();
            $cards .= self::getEditorScheduleCard($item);
        }
        return $cards;
    }

    public static function getEditorScheduleCard(array $item)
    {
        $item['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date']);
        $item['date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date_from']);
        $item['date_to'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date_to']);

        $item['date_from'] = DateTime::formatRu($item['date_from'], 'HH:mm');
        $item['date_to'] = DateTime::formatRu($item['date_to'], 'HH:mm');
        return view('templates/editor/radio/editor_schedule_item', $item);
    }
}