<?php namespace App\Entities\Acquaintances;

use CodeIgniter\Entity;
use Config\Services;

class AcquaintancesValid extends Entity
{
    public static function upadte($data)
    {
        $valid = Services::validation();
        $valid->setRule('youtube_iframe', 'Youtube iframe', 'string|max_length[512]');
        $valid->setRule('title', 'Заголовок', 'required|max_length[512]');
        $valid->setRule('text', 'Описание', 'required|max_length[512]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}