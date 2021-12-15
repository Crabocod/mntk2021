<?php namespace App\Entities\News;

use CodeIgniter\Entity;
use App\Libraries\DateTime;

class NewsView extends Entity
{
    public static function getNewsCardsIndex($news, $url_segment)
    {
        $cards = '';
        foreach ($news as $item) {
            $item = $item->toRawArray();
            $cards .= self::getNewsCardIndex($item, $url_segment);
        }
        return $cards;
    }

    public static function getNewsCardIndex(array $item): string
    {
        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern('d MMMM');
        $item['date'] = $formatter->format(new \DateTime($item['date']));

        return view('templates/conference/index/news_item', $item);
    }

    public static function getNewsCards($news)
    {
        $cards = '';
        foreach ($news as $item) {
            $item = $item->toRawArray();
            $cards .= self::getNewsCard($item);
        }
        return $cards;
    }

    public static function getNewsCard(array $item)
    {
        return view('templates/admin/news/news-card', $item);
    }

    public static function getEditorTableRows(array $news, $url_segment)
    {
        $rows = '';
        foreach ($news as $item) {
            $item = $item->toRawArray();
            $rows .= self::getEditorTableRow($item, $url_segment);
        }
        return $rows;
    }

    public static function getEditorTableRow(array $item, $url_segment)
    {
        $item['date'] =  DateTime::formatRu($item['date'], 'd MMMM YYYY г.');
        $item['url_segment'] = $url_segment;

        return view('templates/editor/news/table_row', $item);
    }
}