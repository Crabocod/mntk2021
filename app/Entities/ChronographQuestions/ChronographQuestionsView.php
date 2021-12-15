<?php namespace App\Entities\ChronographQuestions;


use CodeIgniter\Entity;

class ChronographQuestionsView extends Entity
{
    public static function getAdminQuestionsRows($questions)
    {
        $res = '';
        foreach ($questions as $question) {
            $question = $question->toRawArray();
            $res .= self::getAdminQuestionRow($question);
        }
        return $res;
    }

    public static function getAdminQuestionRow(array $question)
    {
        $question['img_title'] = 'Прикрепить изображение';
        $question['audio_title'] = 'Прикрепить аудио';
        $question['file_title'] = 'Прикрепить файлы';
        foreach ($question['files'] as $file){
            if ($file->type_id == 1)
                $question['audio_title'] = $file->file_title;
            if ($file->type_id == 2)
                $question['file_title'] = $file->file_title;
            if ($file->type_id == 3)
                $question['img_title'] = $file->file_title;
        }
        return view('templates/admin/chronograph/question_row', $question);
    }

    public static function getQuestionsRows($questions)
    {
        $res = '';
        foreach ($questions as $question) {
            $question = $question->toRawArray();
            $res .= self::getQuestionRow($question);
        }
        return $res;
    }

    public static function getQuestionRow(array $question)
    {
        return view('templates/conference/chronograph/question_row', $question);
    }

}