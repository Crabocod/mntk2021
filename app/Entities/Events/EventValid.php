<?php namespace App\Entities\Events;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\Request;
use Config\Services;

class EventValid extends Entity
{
    public static function add(array $data, $files = [])
    {
        $valid = Services::validation();

        if (isset($data['event_type_id']))
            $valid->setRule('event_type_id', 'Тип мероприятия', 'required|is_natural_no_zero');
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

    public static function save(array $data, $files = [])
    {
        $valid = Services::validation();

        if (isset($data['event_type_id']))
            $valid->setRule('event_type_id', 'Тип мероприятия', 'required|is_natural_no_zero');
        if (isset($data['title']))
            $valid->setRule('title', 'Заголовок', 'required|min_length[3]');
        if (isset($data['speaker']))
            $valid->setRule('speaker', 'Спикер', 'required|min_length[3]');
        $valid->setRule('date_from', 'Дата', 'required|valid_date[Y-m-d]');
        $valid->setRule('date_to', 'Дата', 'required|valid_date[Y-m-d]');
        $valid->setRule('time_from', 'Дата', 'required|valid_date[H:i]');
        $valid->setRule('time_to', 'Дата', 'required|valid_date[H:i]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        if(!empty($files)) {
            if(!empty($files['preview_file']))
                self::checkImageFile($files['preview_file'], 'preview_file');
            if(!empty($files['presentation_file']))
                self::checkPowerpoint($files['presentation_file'], 'presentation_file');
            if(!empty($files['photo_file']))
                self::checkImageFile($files['photo_file'], 'photo_file');
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

    public static function saveEventItems(array $data, Request $request = null)
    {
        $valid = Services::validation();
        if (isset($data['title']))
            $valid->setRule('title', 'Заголовок', 'required|min_length[3]');
        if (isset($data['speaker']))
            $valid->setRule('speaker', 'Спикер', 'required|min_length[3]');
        if (isset($data['date']))
            $valid->setRule('date', 'Дата', 'required|valid_date[Y-m-d H:i:s]');
        if (isset($data['show_button']))
            $valid->setRule('show_button', 'Включить кнопку записаться', 'required|in_list[0,1]');

        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        if ($request->getFile('event_preview')->isFile() === false)
            return;

        $valid = Services::validation();
        $valid->setRules([
            'event_preview' => [
                'label' => 'Превью',
                'rules' => 'is_image[event_preview]|max_size[event_preview,102400]',
            ]
        ]);
        if (!$valid->withRequest($request)->run())
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('event_preview');
        if (!$file->isValid())
            throw new \Exception(ErrorMessages::get(76));
        if ($file->hasMoved())
            throw new \Exception(ErrorMessages::get(77));
        if (FileExtsStorage::getByExtension($file->getClientExtension()) === false)
            throw new \Exception(ErrorMessages::get(76));

    }

    public static function addFeedback(array $data)
    {
        $valid = Services::validation();

        $valid->setRule('text', 'текст', 'required|min_length[3]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}
