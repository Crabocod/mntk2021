<?php namespace App\Entities\SectionJury;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

class SectionJuryValid extends Entity
{
    public static function add(array $data, $files = [])
    {
        $valid = Services::validation();

        if (isset($data['title']))
            $valid->setRule('title', 'Заголовок', 'required|min_length[3]');
        if (isset($data['speaker']))
            $valid->setRule('speaker', 'Спикер', 'required|min_length[3]');
        $valid->setRule('date_from', 'Дата', 'required|valid_date[Y-m-d H:i:s]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        if(!empty($files)) {
            if(!empty($files['preview_file']))
                self::checkImageFile($files['preview_file'], 'preview_file');
            if(!empty($files['presentation_file']))
                self::checkImageFile($files['presentation_file'], 'presentation_file');
            if(!empty($files['photo_file']))
                self::checkImageFile($files['photo_file'], 'photo_file');
        }
    }

    public static function save(array $data = [])
    {
        $valid = Services::validation();
        if(isset($data['id']))
            $valid->setRule('id', 'ID жюри', 'required|is_natural_no_zero');
        $valid->setRule('speaker', 'Имя', 'required|max_length[256]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function delete(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID жюри', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
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

    public static function checkPowerpoint($file, $file_name)
    {
        $valid = Services::validation();
        if (($file instanceof UploadedFile) === false)
            return;
        if ($file->isFile() === false)
            return;

        $valid->setRules([
            $file_name => [
                'label' => 'Логотип',
                'rules' => 'max_size['.$file_name.',102400]',
            ]
        ]);
        if (!$valid->run([$file_name => $file]))
            throw new \Exception($valid->listErrors('modal_errors'));

        if(!in_array(mb_strtolower($file->getClientExtension()), ['pptx', 'pptm', 'ppt', 'pdf', 'potx', 'potm', 'ppsx', 'odp']))
            throw new \Exception(ErrorMessages::get(80), 80);
        if (!$file->isValid())
            throw new \Exception(ErrorMessages::get(76), 76);
        if ($file->hasMoved())
            throw new \Exception(ErrorMessages::get(77), 77);
    }
}