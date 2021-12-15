<?php namespace App\Entities\SectionFeedbacks;

use App\Entities\Users\UserSession;
use CodeIgniter\Entity;
use App\Libraries\DateTime;

class SectionFeedbackView extends Entity
{
    public static function getFeedbackCards($feeds, $url_segment)
    {
        $cards = '';
        foreach ($feeds as $item) {
            $item = $item->toRawArray();
            $cards .= self::getFeedbackCard($item, $url_segment);
        }
        return $cards;
    }

    public static function getFeedbackCard(array $item, $url_segment)
    {
        $item['created_at'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['created_at']);
        if(strtotime($item['created_at']) > strtotime(date('Y-m-d 00:00:00')))
            $date = 'сегодня';
        else
            $date = DateTime::formatRu($item['created_at'], 'd MMMM');
        $time = date('H:i', strtotime($item['created_at']));
        $item['created_at'] = $date.' в '.$time;
        $item['url_segment'] = $url_segment;

        return view('templates/conference/sections/section_feedback', $item);
    }

    public static function getEditorTableRows($feeds, $url_segment)
    {
        $rows = '';
        foreach ($feeds as $item) {
            $item = $item->toRawArray();
            $rows .= self::getEditorTableRow($item, $url_segment);
        }
        return $rows;
    }

    public static function getEditorTableRow(array $item, $url_segment)
    {
        $item['created_at'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['created_at']);
        $date = DateTime::formatRu($item['created_at'], 'd MMMM');
        $time = date('H:i', strtotime($item['created_at']));
        $item['created_at'] = $date.' в '.$time;
        $item['url_segment'] = $url_segment;

        return view('templates/editor/sections/section_feedback', $item);
    }
}