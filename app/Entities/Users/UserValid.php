<?php namespace App\Entities\Users;

use App\Entities\FileExts\FileExtsStorage;
use App\Entities\Roles\RoleStorage;
use App\Libraries\ErrorMessages;
use CodeIgniter\HTTP\Request;
use Config\Services;
use CodeIgniter\Entity;

/**
 * Класс для валидации пользователя
 *
 * Class UserValid
 * @package App\Entities\Users
 */
class UserValid extends Entity
{
    public static function save(array $data = [])
    {
        $valid = Services::validation();
        $valid->reset();
        if(isset($data['id']))
            $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        $valid->setRule('full_name', 'Имя', 'required|min_length[3]');
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        $valid->setRule('phone', 'Телефон', 'required|min_length[3]|is_natural_no_zero');
        $valid->setRule('og_title', 'Название ОГ', 'required|string');

        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }


    public static function saveModerator(array $data = [])
    {
        $valid = Services::validation();
        if(isset($data['id']))
            $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        $valid->setRule('full_name', 'Имя', 'required|min_length[3]');
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        $valid->setRule('role_id', 'Настройки прав доступа', 'required|is_natural_no_zero');

        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    /**
     * Валидация данных авторизации
     *
     * @param array $data
     * @throws \Exception
     */
    public static function authConference(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        $valid->setRule('password', 'Пароль', 'required');
        if(isset($data['post']))
            $valid->setRule('timezone', 'Временная зона', 'required|timezone');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function authAdminConference(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        $valid->setRule('password', 'Пароль', 'required');
        if(isset($data['post']))
            $valid->setRule('timezone', 'Временная зона', 'required|timezone');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function authEditorConference(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        $valid->setRule('password', 'Пароль', 'required');
        $valid->setRule('conference_url', 'Конференция', 'required|alpha_numeric');
        if(isset($data['post']))
            $valid->setRule('timezone', 'Временная зона', 'required|timezone');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    /**
     * Валидация данных восстановления пароля
     *
     * @param array $data
     * @throws \Exception
     */
    public static function recoveryPassword(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    /**
     * Валидация данных нового пользователя
     *
     * @param array $data
     * @throws \Exception
     */
    public static function add(array $data = [])
    {
        $valid = Services::validation();
        $valid->reset();
        $valid->setRule('name', 'Имя', 'required|min_length[3]');
        $valid->setRule('surname', 'Фамилия', 'required|min_length[3]');
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        $valid->setRule('role_id', 'Роль', 'required|is_natural_no_zero');
        if(isset($data['og_title']))
            $valid->setRule('og_title', 'Название ОГ', 'required|string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
        if (RoleStorage::get($data['role_id']) === false)
            throw new \Exception(ErrorMessages::get(202));
    }

    /**
     * Валидация регистрации
     *
     * @param array $data
     * @throws \Exception
     */
    public static function registration(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('full_name', 'ФИО', 'required|min_length[3]');
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        if(!empty($data['phone']))
            $valid->setRule('phone', 'Телефон', 'required|min_length[3]|is_natural_no_zero');
        $valid->setRule('password', 'Пароль', 'required|string');
        if (!empty($valid->getRules()) && !$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
        if(empty($valid->getRules()))
            throw new \Exception(ErrorMessages::get(204));
    }

    /**
     * Валидация данных нового пользователя из мобильного приложения
     *
     * @param array $data
     * @throws \Exception
     */
    public static function addFromEventicious(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('name', 'Имя', 'required|min_length[3]');
        $valid->setRule('surname', 'Фамилия', 'required|min_length[3]');
        $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    /**
     * Валидация данных обновления пользователя
     *
     * @param array $data
     * @throws \Exception
     */
    public static function update(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        if (isset($data['alias']))
            $valid->setRule('alias', 'Псевдоним', 'required|min_length[3]');
        if (isset($data['email']))
            $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
        if (isset($data['role_id']))
            $valid->setRule('role_id', 'Роль', 'required|is_natural_no_zero');
        if (isset($data['password']))
            $valid->setRule('password', 'Пароль', 'required|min_length[6]|regex_match[/[0-9a-zA-Z]+/]');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    /**
     * Валидация данных добавления пользователя
     *
     * @param array $data
     * @throws \Exception
     */
//    public static function save(array $data = [])
//    {
//        $valid = Services::validation();
//        if (isset($data['id']))
//            $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
//        if (isset($data['name']))
//            $valid->setRule('name', 'Имя', 'required|min_length[3]');
//        if (isset($data['surname']))
//            $valid->setRule('surname', 'Фамилия', 'required|min_length[3]');
//        if (isset($data['email']))
//            $valid->setRule('email', 'Email', 'required|min_length[3]|valid_email');
//        if (isset($data['role_id']))
//            $valid->setRule('role_id', 'Роль', 'required|is_natural_no_zero');
//        if (isset($data['password']))
//            $valid->setRule('password', 'Пароль', 'required|min_length[6]|regex_match[/[0-9a-zA-Z]+/]');
//        if (!$valid->run($data))
//            throw new \Exception($valid->listErrors('modal_errors'));
//    }

    /**
     * Валидация данных вывода пользователей
     *
     * @param array $data
     * @throws \Exception
     */
    public static function show(array $data = [])
    {
        if (empty($data)) return true;
        $valid = Services::validation();
        if (isset($data['id']))
            $valid->setRule('id', 'ID', 'is_natural_no_zero');
        if (isset($data['limit']))
            $valid->setRule('limit', 'Limit', 'is_natural_no_zero');
        if (isset($data['offset']))
            $valid->setRule('offset', 'Offset', 'is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function delete(array $data = [])
    {
        $valid = Services::validation();
        $valid->setRule('id', 'ID', 'required|is_natural_no_zero');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }

    public static function addUsersFromExcel(Request $request = null)
    {
        if($request->getFile('import-exl')->isFile() === false)
            throw new \Exception(ErrorMessages::get(78));

        $valid = Services::validation();
        $valid->setRules([
            'import-exl' => [
                'label' => 'Файл',
                'rules' => 'mime_in[import-exl,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,text/csv]|max_size[import-exl,102400]',
            ]
        ]);
        if (!$valid->withRequest($request)->run())
            throw new \Exception($valid->listErrors('modal_errors'));

        $file = $request->getFile('import-exl');
        if (!$file->isValid())
            throw new \Exception(ErrorMessages::get(76));
        if($file->hasMoved())
            throw new \Exception(ErrorMessages::get(77));
        if(FileExtsStorage::getByExtension($file->getClientExtension()) === false)
            throw new \Exception(ErrorMessages::get(76));
    }

    /**
     * Валидация данных подтверждения почты
     *
     * @param array $data
     * @throws \Exception
     */
    public static function confirmEmail($data = [])
    {
        $valid = Services::validation();
        $valid->setRule('code', 'code', 'required|string');
        if (!$valid->run($data))
            throw new \Exception($valid->listErrors('modal_errors'));
    }
}
