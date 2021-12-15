<?php namespace App\Entities\Conferences;

use App\Libraries\DateTime;
use CodeIgniter\Entity;

class ConferenceView extends Entity
{
    public static function getBarrelBlock($count, $thisUserClicked = false, $barrels_max)
    {
        if ($barrels_max <= 0)
            $barrels_max = 1000;
        $data = [
            'percent' => ($count/$barrels_max)*100,
            'thisUserClicked' => $thisUserClicked
        ];
        return view('templates/conference/index/barrel-block', $data);
    }

    public static function getOptions(array $conferences)
    {
        $items = '';
        foreach ($conferences as $conference) {
            $items .= self::getOption($conference->toArray());
        }
        return $items;
    }

    public static function getOption(array $conference)
    {
        return '<option value="'.$conference['url_segment'].'">'.$conference['title'].'</option>';
    }

    public static function getTableRows(array $conferences)
    {
        $items = '';
        foreach ($conferences as $conference) {
            $items .= self::getTableRow($conference->toArray());
        }
        return $items;
    }

    public static function getTableRow(array $conference)
    {
        return view('templates/admin/index/table_row', $conference);
    }

    public static function getRadioHead(array $conference)
    {
        if ($conference['radio_date_from'] != null && $conference['radio_date_to'] != null) {
            $conference['radio_date_from'] = DateTime::formatRu($conference['radio_date_from'], 'HH:mm');
            $conference['radio_date_to'] = DateTime::formatRu($conference['radio_date_to'], 'HH:mm');
        }
        return view('templates/conference/radio/head', $conference);
    }


}