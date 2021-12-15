<?php namespace App\Entities\MemberGroups;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\HTTP\Request;
use Config\Services;
use CodeIgniter\Entity;

class MemberGroupValid extends Entity
{
    public static function add(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('member_group_id', 'ID группы', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function save($data, Request $request = null)
    {
        $valid = Services::validation();
        if (isset($data['id']))
            $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        $valid->setRule('text', 'Текст', 'required|max_length[1024]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('img_link');
        if(empty($file))
            return true;
        if ($file->isFile() === false)
            return true;

        $valid = Services::validation();
        $valid->setRules([
            'img_link' => [
                'label' => 'Логотип',
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
