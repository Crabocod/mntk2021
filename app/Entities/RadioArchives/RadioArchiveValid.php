<?php namespace App\Entities\RadioArchives;


use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Request;
use Config\Services;

class RadioArchiveValid extends Entity
{
    public static function saveRadioItems(array $data, Request $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('title', 'Заголовок', 'required|min_length[3]');
        $valid->setRule('date', 'Дата', 'required|valid_date[d.m.Y]');
        $valid->setRule('speaker', 'Спикер', 'required|string');
        $valid->setRule('text', 'Текст', 'required|string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        if ($data['audio_change'] == 1) {
            $file = $request->getFile('audio');
            if (!empty($file)) {
                if ($file->isFile() === false)
                    throw new \Exception(ErrorMessages::get(75));

                $valid = Services::validation();
                $valid->setRules([
                    'audio' => [
                        'label' => 'Файл',
                        'rules' => 'max_size[audio,102400]',
                    ]
                ]);
                if (!$valid->withRequest($request)->run())
                    throw new \Exception($valid->listErrors('modal_errors'));

                if (!$file->isValid())
                    throw new \Exception(ErrorMessages::get(76));
                if ($file->hasMoved())
                    throw new \Exception(ErrorMessages::get(77));
            }
        }

    }
}