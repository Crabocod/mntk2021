<?php


namespace App\Entities\ChronographQuestionAnswers;


use CodeIgniter\Entity;

class ChronographQuestionAnswersView extends Entity
{

    public static function getAnswersRows($questions)
    {
        $res = '';
        $userArr = [];
        foreach ($questions as $item) {
            $userArr[$item->user_email]['name'] = $item->user_name;
            if (!isset($userArr[$item->user_email]['text'])) {
                $userArr[$item->user_email]['text'] = 'Вопрос:<br>' . $item->question_text . '<br>';
            } else {
                $userArr[$item->user_email]['text'] .= 'Вопрос:<br>' . $item->question_text . '<br>';
            }
            $userArr[$item->user_email]['text'] .= 'Ответ:<br>' . $item->text . '<br>';
        }

        foreach ($userArr as $key => $item){
            $res .= self::getAnswerRow($item, $key);
        }
        return $res;
    }

    public static function getAnswerRow(array $question, $email)
    {
        $question['email'] = $email;
        return view('templates/admin/chronograph/answer_row', $question);
    }

}