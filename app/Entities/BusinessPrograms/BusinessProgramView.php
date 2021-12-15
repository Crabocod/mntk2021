<?php namespace App\Entities\BusinessPrograms;


use CodeIgniter\Entity;

class BusinessProgramView extends Entity
{
    public static function getProgramCards($news)
    {
        $cards = '';
        foreach ($news as $item) {
            $item = $item->toRawArray();
            $cards .= self::getProgramsCard($item);
        }
        return $cards;
    }

    public static function getProgramsCard(array $item)
    {
        return view('templates/admin/programs/program-card', $item);
    }
}