<?php namespace App\Entities\ProfQuizQuestions;

use CodeIgniter\Entity;

class ProfQuizQuestionView extends Entity
{
    public static function getQuestionCards($questions)
    {
        $cards = '';
        foreach ($questions as $item) {
            $item = $item->toRawArray();
            $cards .= self::getQuestionCard($item);
        }
        return $cards;
    }

    public static function getQuestionCard(array $item)
    {
        return view('templates/conference/prof_quiz/question_item', $item);
    }

    public static function getEditorTableRows(array $questions)
    {
        $cards = '';
        foreach ($questions as $item) {
            $item = $item->toRawArray();
            $cards .= self::getEditorTableRow($item);
        }
        return $cards;
    }

    public static function getEditorTableRow(array $item)
    {
        return view('templates/editor/prof-quiz/questions-table-row', $item);
    }
}