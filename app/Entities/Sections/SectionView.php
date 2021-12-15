<?php namespace App\Entities\Sections;

use App\Entities\Users\UserSession;
use CodeIgniter\Entity;
use App\Libraries\DateTime;

class SectionView extends Entity
{
    public static function getAdminSectionsCards($sections, $users, $sectionJury)
    {
        $cards = '';
        foreach ($sections as $section) {
            $section = $section->toRawArray();

            $memberCount = 0;
            $juryCount = 0;
            foreach ($users as $user){
                $user = $user->toRawArray();
                if($user['section_id'] == $section['id'])
                    $memberCount++;
            }
            foreach ($sectionJury as $item){
                $item = $item->toRawArray();
                if($item['section_id'] == $section['id'])
                    $juryCount++;
            }


            $cards .= self::getAdminsectionCard($section, $memberCount, $juryCount);
        }
        return $cards;
    }

    public static function getAdminsectionCard(array $section, $memberCount, $juryCount)
    {
        $section['formatted_date_from'] = '';
        if(!empty($section['protection_date'])) {
            $section['protection_date'] = DateTime::byUserTimeZone(UserSession::getUser(), $section['protection_date']);
            $section['formatted_date_from'] = DateTime::formatRu($section['protection_date'], 'd MMMM');
        }
        $section['time_from'] = DateTime::formatRu($section['protection_date'], 'HH:mm');
        $section['memberCount'] = $memberCount;
        $section['juryCount'] = $juryCount;

        return view('templates/admin/sections/section_card', $section);
    }

    public static function getSectionCards($sections, $url_segment)
    {
        $cards = '';
        foreach ($sections as $item) {
            $item = $item->toRawArray();
            $cards .= self::getSectionCard($item, $url_segment);
        }
        return $cards;
    }

    public static function getSectionCard(array $item, $url_segment)
    {
        $item['protection_date'] = DateTime::byUserTimeZone(UserSession::getUser(), $item['protection_date']);
        $item['protection_day'] = DateTime::formatRu($item['protection_date'], 'd');
        $item['protection_month'] = DateTime::formatRu($item['protection_date'], 'MMMM');
        $item['protection_time'] = date('H:i', strtotime($item['protection_date']));
        $item['url_segment'] = $url_segment;

        return view('templates/conference/sections/section_item', $item);
    }

    public static function getEditorTableRows(array $sections, $url_segment)
    {
        $rows = '';
        foreach ($sections as $item) {
            $item = $item->toRawArray();
            $rows .= self::getEditorTableRow($item, $url_segment);
        }
        return $rows;
    }

    public static function getEditorTableRow(array $item, $url_segment)
    {
        $protection_date = DateTime::byUserTimeZone(UserSession::getUser(), $item['protection_date']);
        $item['protection_date'] = DateTime::formatRu($protection_date, 'd MMMM YYYY г.');
        $item['protection_time'] = date('H:i', strtotime($protection_date));
        $item['url_segment'] = $url_segment;

        return view('templates/editor/sections/table_row', $item);
    }
}