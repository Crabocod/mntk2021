<?php namespace App\Entities\ArchiveFeedbacks;

use Config\Services;
use CodeIgniter\Entity;

class ArchiveFeedbackValid extends Entity
{
    public static function add(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('text', 'Комментарий', 'required|min_length[3]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function delete(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID комментария', 'required|is_natural_no_zero|is_not_unique[archive_feedbacks.id]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}
