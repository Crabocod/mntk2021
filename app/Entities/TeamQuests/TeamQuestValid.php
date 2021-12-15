<?php namespace App\Entities\TeamQuests;

use Config\Services;
use CodeIgniter\Entity;

class TeamQuestValid extends Entity
{
    public static function save($data)
    {
        $valid = Services::validation();
        if (isset($data['id']))
            $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        $valid->setRule('title', 'Название команды', 'required|max_length[1024]');
        $valid->setRule('points', 'Количество баллов', 'required|max_length[1024]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

    }
}
