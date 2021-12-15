<?php namespace App\Entities\RadioArchives;

use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use CodeIgniter\Entity;

class RadioArchiveView extends Entity
{
    public static function getArchiveCards($archive)
    {
        $cards = '';
        $count = 0;
        foreach ($archive as $item) {
            $count++;
            $itemCount = ceil($count/3);
            $item = $item->toRawArray();
            $cards .= self::getArchiveCard($item, $itemCount);
        }
        return $cards;
    }

    public static function getArchiveCard(array $item, $count)
    {
        $item['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date']);
        $item['date'] = DateTime::formatRu($item['date'], 'd MMMM');
        $item['count'] = $count;
        return view('templates/conference/radio/archive_item', $item);
    }

    public static function getArchivePages($count)
    {
        $cards = '';
        for($i = 1; $i <= $count+1; $i++) {
            if ($i == 1)
                $cards .= '<a class="pages page_active" href="#" onclick="return page(this, '.$i.')">'.$i.'</a>';
            else
                $cards .= '<a class="pages" href="#" onclick="return page(this, '.$i.')">'.$i.'</a>';

        }
        return $cards;
    }

    public static function getEditorArchiveCards($archive)
    {
        $cards = '';
        foreach ($archive as $item) {
            $item = $item->toRawArray();
            $cards .= self::getEditorArchiveCard($item);
        }
        return $cards;
    }

    public static function getEditorArchiveCard(array $item)
    {
        $item['date'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['date']);
        return view('templates/editor/radio/archive_item', $item);
    }
}