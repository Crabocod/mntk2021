<?php namespace App\Entities\Chronograph;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Request;
use Config\Services;

class ChronographValid extends Entity
{
    public static function deleteQuestion(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID вопроса', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function saveQuestion(array $data = [], Request $request = null){
        $valid = Services::validation();
        if(isset($data['id']))
            $valid->setRule('id', 'ID вопроса', 'required|is_natural_no_zero|is_not_unique[chronograph_questions.id]');
        $valid->setRule('number', 'Номер вопроса', 'required|is_natural_no_zero');
        $valid->setRule('title', 'Текст вопроса', 'string');
        $valid->setRule('text', 'Текст вопроса', 'string');
        $valid->setRule('youtube_iframe', 'Код iframe', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('img_link');
        if(!empty($file) and $file->isFile() !== false) {
            $valid = Services::validation();
            $valid->setRules([
                'img_link' => [
                    'label' => 'Изображение',
                    'rules' => 'is_image[img_link]|max_size[img_link,102400]',
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

        $file = $request->getFile('audio_link');
        if(!empty($file) and $file->isFile() !== false) {
            $valid = Services::validation();
            $valid->setRules([
                'audio_link' => [
                    'label' => 'Аудио',
                    'rules' => 'max_size[audio_link,102400]',
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

        $file = $request->getFile('file_link');
        if(!empty($file) and $file->isFile() !== false) {
            $valid = Services::validation();
            $valid->setRules([
                'file_link' => [
                    'label' => 'Аудио',
                    'rules' => 'max_size[file_link,102400]',
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

    public static function saveText(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('text', 'Текст главного блока', 'required|string');

        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}