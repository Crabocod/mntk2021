<?php namespace App\Entities\Archives;

use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use CodeIgniter\Entity;

class ArchiveView extends Entity
{
    public static function getCards($sections)
    {
        $cards = '';
        foreach ($sections as $item) {
            if($item instanceof Entity)
                $item = $item->toRawArray();
            $cards .= self::getCard($item);
        }
        return $cards;
    }

    public static function getCard(array $item)
    {
        $item['date'] = self::getDateFormat($item['date_from'], 'd MMMM ');

        return view('templates/conference/archives/archive_item', $item);
    }

    public static function getTableRows(array $archives)
    {
        $items = '';
        foreach ($archives as $item) {
            if($item instanceof Entity)
                $item = $item->toRawArray();
            $items .= self::getTableRow($item);
        }
        return $items;
    }

    public static function getTableRow(array $item)
    {
        $item['date_from'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date_from']);
        $item['formatted_date_from'] = self::getDateFormat($item['date_from'], 'd.M.Y H:mm');
        $item['preview_link'] = '';
        if(!empty($item['preview_min_file_link']))
            $item['preview_link'] = $item['preview_min_file_link'];
        elseif(!empty($item['preview_file_link']))
            $item['preview_link'] = $item['preview_file_link'];

        return view('templates/editor/archives/table_row', $item);
    }

    public static function getDateFormat($date, $pattern)
    {
        $dateTime = new \DateTime($date);
        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern($pattern);
        return $formatter->format($dateTime);
    }
}