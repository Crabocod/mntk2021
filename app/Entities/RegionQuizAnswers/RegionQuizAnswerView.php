<?php namespace App\Entities\RegionQuizAnswers;

use CodeIgniter\Entity;

class RegionQuizAnswerView extends Entity
{
    public static function getEditorTableRows(array $answers)
    {
        $cards = '';
        foreach ($answers as $item) {
            $cards .= self::getEditorTableRow($item);
        }
        return $cards;
    }

    public static function getEditorTableRow(array $item)
    {
        return view('templates/editor/region-quiz/answers-table-row', $item);
    }
}