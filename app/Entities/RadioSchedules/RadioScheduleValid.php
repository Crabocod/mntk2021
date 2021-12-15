<?php namespace App\Entities\RadioSchedules;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\HTTP\Request;
use Config\Services;
use CodeIgniter\Entity;

class RadioScheduleValid extends Entity
{
    public static function save(array $data, Request $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('title', 'Название', 'required|string');
        $valid->setRule('date', 'Дата', 'required|valid_date[d.m.Y]');
        $valid->setRule('date_from', 'Время начало', 'required|valid_date[H:i]');
        $valid->setRule('date_to', 'Время конца', 'required|valid_date[H:i]');
        $valid->setRule('speaker', 'Спикер', 'required|string');
        $valid->setRule('text', 'Текст', 'required|string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('img');
        if(empty($file))
            return true;
        if ($file->isFile() === false)
            return true;

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
}