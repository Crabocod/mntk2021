<?php namespace App\Entities\Files;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Request;
use Config\Services;

class FileValid extends Entity
{
    public static function addFile(Request $request)
    {
        $valid = Services::validation();
        $valid->setRules([
            'files' => [
                'label' => 'Файл',
                'rules' => 'max_size[files,102400]',
            ]
        ]);
        if (!$valid->withRequest($request)->run())
            throw new \Exception($valid->listErrors('modal_errors'));

        $files = $request->getFiles();
        foreach ($files['files'] as $file) {
            if(FileExtsStorage::getByExtension($file->getClientExtension()) === false)
                throw new \Exception(ErrorMessages::get(76));
        }
    }
}