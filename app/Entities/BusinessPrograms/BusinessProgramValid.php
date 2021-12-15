<?php namespace App\Entities\BusinessPrograms;


use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Request;
use Config\Services;

class BusinessProgramValid extends Entity
{
    public static function delete($data)
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function save($data, Request $request = null)
    {
        $valid = Services::validation();
        if (isset($data['id']))
            $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        $valid->setRule('date', 'Дата', 'required|valid_date[Y-m-d]');
        $valid->setRule('text', 'Текст', 'string|max_length[512]');
        $valid->setRule('title', 'Заголовок', 'required|max_length[512]');
        $valid->setRule('iframe', 'Iframe ютуб', 'string|max_length[512]');

        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('img_link');
        if (!isset($data['id']) || (isset($data['id']) && !empty($file))) {
            if (empty($file))
                return true;
            if ($file->isFile() === false)
                return true;

            $valid = Services::validation();
            $valid->setRules([
                'img_link' => [
                    'label' => 'Обложка',
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
    }
}