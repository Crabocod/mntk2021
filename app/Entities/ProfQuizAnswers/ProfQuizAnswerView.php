<?php namespace App\Entities\ProfQuizAnswers;

use CodeIgniter\Entity;

class ProfQuizAnswerView extends Entity
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
        return view('templates/editor/prof-quiz/answers-table-row', $item);
    }
}