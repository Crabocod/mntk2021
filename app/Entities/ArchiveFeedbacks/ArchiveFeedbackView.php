<?php namespace App\Entities\ArchiveFeedbacks;

use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use CodeIgniter\Entity;

class ArchiveFeedbackView extends Entity
{
    public static function getFeedbackCards($feedbacks)
    {
        $cards = '';
        foreach ($feedbacks as $item) {
            $item = $item->toRawArray();
            $cards .= self::getFeedbackCard($item);
        }
        return $cards;
    }

    public static function getFeedbackCard(array $item)
    {
        $item['created_at'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['created_at']);
        if(strtotime($item['created_at']) > strtotime(date('Y-m-d 00:00:00')))
            $date = 'сегодня';
        else
            $date = DateTime::formatRu($item['created_at'], 'd MMMM');
        $time = date('H:i', strtotime($item['created_at']));
        $item['created_at'] = $date.' в '.$time;

        return view('templates/conference/archives/archive_feedback', $item);
    }

    public static function getEditorTableRows(array $feedbacks)
    {
        $rows = '';
        foreach ($feedbacks as $item) {
            $item = $item->toRawArray();
            $rows .= self::getEditorTableRow($item);
        }
        return $rows;
    }

    public static function getEditorTableRow(array $item)
    {
        $item['created_at'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['created_at']);
        $item['created_at'] = DateTime::formatRu($item['created_at'], 'd MMMM yyyy в HH:mm');

        return view('templates/editor/archives/feedback_row', $item);
    }
}