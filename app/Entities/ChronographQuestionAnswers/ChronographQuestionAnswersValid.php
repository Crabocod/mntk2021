<?php namespace App\Entities\ChronographQuestionAnswers;


use CodeIgniter\Entity;
use CodeIgniter\HTTP\Request;
use Config\Services;

class ChronographQuestionAnswersValid extends Entity
{
    public static function add($data, Request $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('answer', 'Ответ', 'required|max_length[512]');
        $valid->setRule('id', 'id', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}