<?php namespace App\Entities\Sections;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

class SectionValid extends Entity
{
    public static function delete(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID секции', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function save(array $data, $files = [])
    {
        $valid = Services::validation();

        if (isset($data['title']))
            $valid->setRule('title', 'Заголовок', 'required|min_length[3]');
        $valid->setRule('date_from', 'Дата', 'required|valid_date[Y-m-d]');
        $valid->setRule('time_from', 'Дата', 'required|valid_date[H:i]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        if(!empty($files)) {
            if(!empty($files['preview_file']))
                self::checkImageFile($files['preview_file'], 'preview_file');
        }
    }

    public static function checkImageFile($file, $file_name)
    {
        $valid = Services::validation();
        if (($file instanceof UploadedFile) === false)
            return;
        if ($file->isFile() === false)
            return;

        $valid->setRules([
            $file_name => [
                'label' => 'Логотип',
                'rules' => 'is_image['.$file_name.']|max_size['.$file_name.',102400]',
            ]
        ]);
        if (!$valid->run([$file_name => $file]))
            throw new \Exception($valid->listErrors('modal_errors'));

        if(FileExtsStorage::getByExtension($file->getClientExtension()) === false)
            throw new \Exception(ErrorMessages::get(81), 81);
        if (!$file->isValid())
            throw new \Exception(ErrorMessages::get(76), 76);
        if ($file->hasMoved())
            throw new \Exception(ErrorMessages::get(77), 77);
    }

    public static function publication(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID секции', 'required|is_natural_no_zero');
        $valid->setRule('is_publication', 'Публикация', 'required|in_list[0,1]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}
