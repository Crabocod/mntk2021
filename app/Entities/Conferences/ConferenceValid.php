<?php namespace App\Entities\Conferences;

use App\Entities\FileExts\FileExtsStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\Request;
use Config\Services;

class ConferenceValid extends Entity
{
    public static function save(array $data)
    {
        $valid = Services::validation();
        if(isset($data['id']))
            $valid->setRule('id', 'ID конференции', 'required|is_natural_no_zero');
        $valid->setRule('title', 'Наименование конференции', 'required|min_length[3]');
        $valid->setRule('title_head', 'Наименование конференции в шапке сайта', 'required|min_length[3]');
        $valid->setRule('url_segment', 'Ссылка конференции', 'required|alpha_numeric');
        if(!empty($data['eventicious_api_key']))
            $valid->setRule('eventicious_api_key', 'Ключ API', 'required|string|max_length[256]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function saveMainItems(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('conference_id', 'ID конференции', 'required|is_natural_no_zero');
        if(!empty($data['widget']))
            $valid->setRule('widget', 'HTML-код виджета', 'required');
        if(!empty($data['ticker']))
            $valid->setRule('ticker', 'Текст бегущей строки', 'required');
        if(isset($data['show_main_block']))
            $valid->setRule('show_main_block', 'Приветствие и баррель', 'in_list[0,1]');
        if(isset($data['show_timer_block']))
            $valid->setRule('show_timer_block', 'Таймер', 'in_list[0,1]');
        if(isset($data['show_ether_block']))
            $valid->setRule('show_ether_block', 'Прямой эфир', 'in_list[0,1]');
        if(isset($data['show_eventsnews_block']))
            $valid->setRule('show_eventsnews_block', 'Прямой эфир', 'in_list[0,1]');
        if(isset($data['timer_datetime']))
            $valid->setRule('timer_datetime', 'Таймер', 'valid_date[Y-m-d H:i:s]');
        if(isset($data['ether_iframe']))
            $valid->setRule('ether_iframe', 'Iframe youtube на видео', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function saveBarrels(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('barrels_max', 'Максимальное количество кликов на «БАРРЕЛЬ»', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function saveGrItems(array $data, Request $request = null)
    {
        $valid = Services::validation();
        if(isset($data['id']))
            $valid->setRule('id', 'ID конференции', 'required|is_natural_no_zero');
        $valid->setRule('gr_title', 'Заголовок', 'required|min_length[3]');
//        $valid->setRule('gr_video', 'Iframe youtube на видео-приветствие', 'required');
        $valid->setRule('gr_text', 'Текст', 'required');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        if($request->getFile('gr_logo')->isFile() === false)
            return;

        $valid = Services::validation();
        $valid->setRules([
            'gr_logo' => [
                'label' => 'Логотип',
                'rules' => 'is_image[gr_logo]|max_size[gr_logo,102400]',
            ]
        ]);
        if (!$valid->withRequest($request)->run())
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('gr_logo');
        if (!$file->isValid())
            throw new \Exception(ErrorMessages::get(76));
        if($file->hasMoved())
            throw new \Exception(ErrorMessages::get(77));
        if(FileExtsStorage::getByExtension($file->getClientExtension()) === false)
            throw new \Exception(ErrorMessages::get(76));

    }

    public static function saveRadioItems(array $data, Request $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('radio_title', 'Заголовок', 'required|min_length[3]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('radio_audio');
        if(!empty($file) and $file->isFile() !== false) {
            if ($file->isFile() === false)
                throw new \Exception(ErrorMessages::get(75));

            $valid = Services::validation();
            $valid->setRules([
                'radio_audio' => [
                    'label' => 'Файл',
                    'rules' => 'max_size[radio_audio,102400]',
                ]
            ]);
            if (!$valid->withRequest($request)->run())
                throw new \Exception($valid->listErrors('modal_errors'));

            if (!$file->isValid())
                throw new \Exception(ErrorMessages::get(76));
            if ($file->hasMoved())
                throw new \Exception(ErrorMessages::get(77));
        }
    }

    public static function saveOgItems(array $data, Request $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('og_text', 'Текст', 'string');
        $valid->setRule('og_video', 'Iframe youtube на видео-приветствие', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        if($request->getFile('og_logo')->isFile() === false)
            return;

        $valid = Services::validation();
        $valid->setRules([
            'gr_logo' => [
                'label' => 'Логотип',
                'rules' => 'is_image[og_logo]|max_size[og_logo,102400]',
            ]
        ]);
        if (!$valid->withRequest($request)->run())
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('og_logo');
        if (!$file->isValid())
            throw new \Exception(ErrorMessages::get(76));
        if($file->hasMoved())
            throw new \Exception(ErrorMessages::get(77));
        if(FileExtsStorage::getByExtension($file->getClientExtension()) === false)
            throw new \Exception(ErrorMessages::get(76));

    }


    public static function saveGfItems(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('gf_text', 'Текст перед ссылкой', 'string');
        if(!empty($data['gf_url']))
            $valid->setRule('gf_url', 'Ссылка', 'required|valid_url');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

    }

    public static function saveWtbItems(array $data)
    {
        $valid = Services::validation();
        if(isset($data['id']))
            $valid->setRule('id', 'ID конференции', 'required|is_natural_no_zero');
        $valid->setRule('wtb_text', 'Текст-описание', 'required|min_length[3]');
        $valid->setRule('wtb_email', 'Email-адрес для отправки заявок', 'required|min_length[3]|valid_email');

        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function delete(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID конференции', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function saveCkeditorImage(Request $request = null)
    {
        $valid = Services::validation();
        $file = $request->getFile('upload');
        if(empty($file))
            throw new \Exception(ErrorMessages::$messages[75]);
        if ($file->isFile() === false)
            throw new \Exception(ErrorMessages::$messages[75]);

        $valid->reset();
        $valid->setRules(
            [
                'upload' => [
                    'label' => 'Изображение',
                    'rules' => 'is_image[upload]|max_size[upload,20000]',
                ]
            ],
            [
                'upload' => [
                    'is_image' => ErrorMessages::$messages[80],
                    'max_size' => ErrorMessages::$messages[81],
                ]
            ]
        );
        if (!$valid->withRequest($request)->run())
            throw new \Exception($valid->listErrors('list_errors'));
        if (!$file->isValid())
            throw new \Exception(ErrorMessages::$messages[76]);
        if ($file->hasMoved())
            throw new \Exception(ErrorMessages::$messages[77]);
        if (FileExtsStorage::getByExtension($file->getClientExtension()) === false)
            throw new \Exception(ErrorMessages::$messages[76]);
    }

    public static function saveProfQuiz(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('prof_quiz_text', 'Текст', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function saveRegionQuiz(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('region_quiz_text', 'Текст', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function saveManagementItems(array $data)
    {
        $valid = Services::validation();
        $valid->setRule('management_title', 'Заголовок', 'required|min_length[3]');
        $valid->setRule('management_text', 'Текст', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function saveRadioMainSchedule(array $data, Request $request = null)
    {
        $valid = Services::validation();
        $valid->setRule('conference_id', 'ID', 'required|is_natural_no_zero');
        $valid->setRule('radio_main_schedule_text', 'Текст', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        $radio_main_schedule_img1 = $request->getFile('radio_main_schedule_img1');
        $radio_main_schedule_img2 = $request->getFile('radio_main_schedule_img2');

        if(!empty($radio_main_schedule_img1) and $radio_main_schedule_img1->isFile() !== false) {
            $valid->reset();
            $valid->setRules(
                [
                    'radio_main_schedule_img1' => [
                        'label' => 'Изображение',
                        'rules' => 'is_image[radio_main_schedule_img1]|max_size[radio_main_schedule_img1,20000]',
                    ]
                ],
                [
                    'radio_main_schedule_img1' => [
                        'is_image' => ErrorMessages::$messages[80],
                        'max_size' => ErrorMessages::$messages[81],
                    ]
                ]
            );
            if (!$valid->withRequest($request)->run())
                throw new \Exception($valid->listErrors('list_errors'));
            if (!$radio_main_schedule_img1->isValid())
                throw new \Exception(ErrorMessages::$messages[76]);
            if ($radio_main_schedule_img1->hasMoved())
                throw new \Exception(ErrorMessages::$messages[77]);
            if (FileExtsStorage::getByExtension($radio_main_schedule_img1->getClientExtension()) === false)
                throw new \Exception(ErrorMessages::$messages[76]);
        }

        if(!empty($radio_main_schedule_img2) and $radio_main_schedule_img2->isFile() !== false) {
            $valid->reset();
            $valid->setRules(
                [
                    'radio_main_schedule_img2' => [
                        'label' => 'Изображение',
                        'rules' => 'is_image[radio_main_schedule_img2]|max_size[radio_main_schedule_img2,20000]',
                    ]
                ],
                [
                    'radio_main_schedule_img2' => [
                        'is_image' => ErrorMessages::$messages[80],
                        'max_size' => ErrorMessages::$messages[81],
                    ]
                ]
            );
            if (!$valid->withRequest($request)->run())
                throw new \Exception($valid->listErrors('list_errors'));
            if (!$radio_main_schedule_img2->isValid())
                throw new \Exception(ErrorMessages::$messages[76]);
            if ($radio_main_schedule_img2->hasMoved())
                throw new \Exception(ErrorMessages::$messages[77]);
            if (FileExtsStorage::getByExtension($radio_main_schedule_img2->getClientExtension()) === false)
                throw new \Exception(ErrorMessages::$messages[76]);
        }
    }

    public static function hideBlock($data = [])
    {
        $valid = Services::validation();
        $valid->setRule('id', 'id', 'required|is_natural_no_zero');
        $valid->setRule('hide', 'hide', 'required|in_list[1,0]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function updateTimer($data = [])
    {
        $valid = Services::validation();
        $valid->setRule('timer', 'timer', 'required|valid_date[Y-m-d H:i]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function updateMainBlock($data = [], $files = [])
    {
        $valid = Services::validation();
        $valid->setRule('title', 'Заголовок', 'string');
        $valid->setRule('sub_title', 'Подзаголовок', 'string');
        $valid->setRule('date', 'Дата', 'string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));

        if(!empty($files)) {
            $file = $files['logo'];
            if (($file instanceof UploadedFile) === false)
                throw new \Exception(ErrorMessages::get(76));
            if ($file->isFile() === false)
                throw new \Exception(ErrorMessages::get(76));

            $valid->reset();
            $valid->setRules([
                'logo' => [
                    'label' => 'Логотип',
                    'rules' => 'is_image[logo]|max_size[logo,102400]',
                ]
            ]);
            if (!$valid->run(['logo' => $file]))
                throw new \Exception($valid->listErrors('modal_errors'));

            if(FileExtsStorage::getByExtension($file->getClientExtension()) === false)
                throw new \Exception(ErrorMessages::get(81), 81);
            if (!$file->isValid())
                throw new \Exception(ErrorMessages::get(76), 76);
            if ($file->hasMoved())
                throw new \Exception(ErrorMessages::get(77), 77);
        }
    }
}