<?php namespace App\Entities\SectionImages;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use Config\Services;
use CodeIgniter\HTTP\Request;

class SectionImageValid extends Entity
{
    public static function save($data, Request $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('section_id', 'ID', 'required|is_natural_no_zero|is_not_unique[sections.id]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('img');
        if(empty($file))
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

    public static function delete(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID изображения', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function sort(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('section_id', 'Секция', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        foreach ($data['sort'] as $item) {
            $valid->reset();
            $valid->setRule('id', 'ID изображения', 'required|is_natural_no_zero');
            $valid->setRule('sort_num', 'Номер сортировки', 'required|is_natural_no_zero');
            if (!$valid->run($item))
                throw new \Exception($valid->listErrors('modal_errors'));
        }
    }
}