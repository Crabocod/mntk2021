<?php namespace App\Entities\ProfQuizAnswers;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\IncomingRequest;
use Config\Services;

class ProfQuizAnswerValid extends Entity
{
    public static function add(array $data = [], IncomingRequest $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('professional_quiz_question_id', 'ID вопроса', 'required|is_natural_no_zero');
        $valid->setRule('text', 'Комментарий', 'required|min_length[3]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('file');
        if(!empty($file) and $file->isFile() !== false) {
            $valid = Services::validation();
            $valid->setRules([
                'file' => [
                    'label' => 'Файл',
                    'rules' => 'max_size[file,102400]',
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
}