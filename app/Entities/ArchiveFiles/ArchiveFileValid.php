<?php namespace App\Entities\ArchiveFiles;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use Config\Services;
use CodeIgniter\HTTP\Request;

class ArchiveFileValid extends Entity
{
    public static function save($data, Request $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('archive_id', 'ID архива', 'required|is_not_unique[archives.id]|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('link');
        if(empty($file))
            throw new \Exception(ErrorMessages::get(75));
        if ($file->isFile() === false)
            throw new \Exception(ErrorMessages::get(75));

        $valid = Services::validation();
        $valid->setRules([
            'link' => [
                'label' => 'Файл',
                'rules' => 'max_size[link,102400]',
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
        $valid->setRule('id', 'ID файла', 'required|is_natural_no_zero|is_not_unique[archive_files.id]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}