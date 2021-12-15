<?php namespace App\Entities\Groups;

use Config\Services;
use CodeIgniter\Entity;

class GroupValid extends Entity
{
    public static function add(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('title', 'Название группы', 'required|max_length[1024]|min_length[2]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function update($data)
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        $valid->setRule('title', 'Название группы', 'required|max_length[1024]|min_length[2]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}
