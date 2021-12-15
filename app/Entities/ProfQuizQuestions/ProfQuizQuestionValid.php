<?php namespace App\Entities\ProfQuizQuestions;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\HTTP\Request;
use Config\Services;
use CodeIgniter\Entity;

class ProfQuizQuestionValid extends Entity
{
    public static function add(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('professional_quiz_question_id', 'ID вопроса', 'required|is_natural_no_zero');
        $valid->setRule('text', 'Комментарий', 'required|min_length[3]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function save(array $data, Request $request = null)
    {
        $valid = Services::validation();
        if(isset($data['id']))
            $valid->setRule('id', 'ID вопроса', 'required|is_natural_no_zero|is_not_unique[professional_quiz_questions.id]');
        $valid->setRule('number', 'Номер вопроса', 'required|is_natural_no_zero');
        $valid->setRule('text', 'Текст вопроса', 'string');
        $valid->setRule('youtube_iframe', 'Код iframe', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('img');
        if(!empty($file) and $file->isFile() !== false) {
            $valid = Services::validation();
            $valid->setRules([
                'img' => [
                    'label' => 'Изображение',
                    'rules' => 'is_image[img]|max_size[img,102400]',
                ]
            ]);
            if (!$valid->withRequest($request)->run())
                throw new \Exception($valid->listErrors('modal_errors'));

            if (!$file->isValid())
                throw new \Exception(ErrorMessages::get(76));
            if ($file->hasMoved())
                throw new \Exception(ErrorMessages::get(77));
            if (FileExtsStorage::getByExtension($file->getClientExtension()) === false)
                throw new \Exception(ErrorMessages::get(76));
        }

        $file = $request->getFile('audio');
        if(!empty($file) and $file->isFile() !== false) {
            $valid = Services::validation();
            $valid->setRules([
                'audio' => [
                    'label' => 'Аудио',
                    'rules' => 'max_size[audio,102400]',
                ]
            ]);
            if (!$valid->withRequest($request)->run())
                throw new \Exception($valid->listErrors('modal_errors'));

            if (!$file->isValid())
                throw new \Exception(ErrorMessages::get(76));
            if ($file->hasMoved())
                throw new \Exception(ErrorMessages::get(77));
            if (FileExtsStorage::getByExtension($file->getClientExtension()) === false)
                throw new \Exception(ErrorMessages::get(76));
        }
    }

    public static function publication(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID викторины', 'required|is_natural_no_zero|is_not_unique[professional_quiz_questions.id]');
        $valid->setRule('visibility', 'Публикация', 'required|in_list[0,1]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function delete(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID викторины', 'required|is_natural_no_zero|is_not_unique[professional_quiz_questions.id]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}
