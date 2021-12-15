<?php namespace App\Entities\GoogleFormImgs;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Request;
use Config\Services;

class GoogleFormImgValid extends Entity
{
    public static function save($data, Request $request = null)
    {
        $file = $request->getFile('img');
        if (empty($file))
            throw new \Exception(ErrorMessages::get(75));
        if ($file->isFile() === false)
            throw new \Exception(ErrorMessages::get(75));

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

    public static function delete($data)
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID изображения', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function sort($data)
    {
        $valid = Services::validation();
        foreach ($data['sort'] as $item) {
            $valid->reset();
            $valid->setRule('id', 'ID изображения', 'required|is_natural_no_zero');
            $valid->setRule('sort_num', 'Номер сортировки', 'required|is_natural_no_zero');
            if (!$valid->run($item))
                throw new \Exception($valid->listErrors('modal_errors'));
        }
    }
}