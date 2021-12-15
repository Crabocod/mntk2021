<?php namespace App\Entities\News;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Request;
use Config\Services;

class NewsValid extends Entity
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
        $valid->setRule('text', 'Короткий текст новости', 'required|string');
        if (isset($data['full_text']))
            $valid->setRule('full_text', 'Полный текст новости', 'required|string');
        $valid->setRule('title', 'Заголовок новости', 'required|max_length[512]');
        $valid->setRule('iframe', 'Iframe ютуб', 'required|max_length[512]');

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
                    'label' => 'Обложка новости',
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

    public static function publication($data = [])
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID новости', 'required|is_natural_no_zero');
        $valid->setRule('is_publication', 'Публикация', 'required|in_list[0,1]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}