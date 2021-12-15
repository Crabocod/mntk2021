<?php namespace App\Entities\Chess;

use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use CodeIgniter\Entity;

class ChessView extends Entity
{
    public static function getChessSection($chess)
    {
        $section = '';
        foreach ($chess as $item) {
            $item = $item->toRawArray();
            $section .= self::getChessItem($item);
        }
        return $section;
    }

    public static function getChessItem(array $item)
    {
        $item['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date']);
        $date = new \DateTime($item['date']);
        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern('d');
        $item['day'] = $formatter->format($date);
        $formatter->setPattern('MMMM');
        $item['month'] =  $formatter->format($date);
        $formatter->setPattern('HH:mm');
        $item['time'] =  $formatter->format($date);
        if(!empty($item['img_file_min_link']))
            $item['img_link'] = $item['img_file_min_link'];
        elseif(!empty($item['img_file_link']))
            $item['img_link'] = $item['img_file_link'];
        else
            $item['img_link'] = '/img/event-1.svg';
        return view('templates/conference/index/chess_item', $item);
    }

    public static function getTableRows(array $chess)
    {
        $section = '';
        foreach ($chess as $item) {
            $item = $item->toRawArray();
            $section .= self::getTableRow($item);
        }
        return $section;
    }

    public static function getTableRow(array $item)
    {
        $item['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date']);
        if(!empty($item['img_file_min_link']))
            $item['img_link'] = $item['img_file_min_link'];
        elseif(!empty($item['img_file_link']))
            $item['img_link'] = $item['img_file_link'];
        else
            $item['img_link'] = '';


        return view('templates/editor/index/chess_table_row', $item);
    }
}