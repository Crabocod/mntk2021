<?php namespace App\Entities\SectionJury;

use CodeIgniter\Entity;

class SectionJuryView extends Entity
{
    public static function getSectionJuryCards($jury)
    {
        $cards = '';
        foreach ($jury as $item) {
            $item = $item->toRawArray();
            $cards .= self::getSectionJuryCard($item);
        }
        return $cards;
    }

    public static function getSectionJuryCard(array $item)
    {
        return view('templates/conference/sections/section_jury', $item);
    }

    public static function getDateFormat($date, $pattern)
    {
        $dateTime = new \DateTime($date);
        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern($pattern);
        return $formatter->format($dateTime);
    }

    public static function getEditorTableRows(array $jury)
    {
        $rows = '';
        foreach ($jury as $item) {
            $item = $item->toRawArray();
            $rows .= self::getEditorTableRow($item);
        }
        return $rows;
    }

    public static function getEditorTableRow(array $item)
    {
        return view('templates/editor/sections/jury_row', $item);
    }

    public static function getAdminTableRow(array $item)
    {
        return view('templates/admin/sections/jury_row', $item);
    }
}