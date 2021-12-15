<?php namespace App\Controllers\Pages\Conference;

use App\Controllers\Pages\BaseController;
use App\Entities\Users\User;
use App\Entities\Users\UserSession;
use App\Entities\Users\UserValid;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Models\Users as UsersModel;

class Auth extends BaseController
{
    public function index()
    {
        echo view('pages/conference/auth');
    }

    public function login()
    {
        try {
            // Валидация
            $post = $this->request->getPost();
            UserValid::authConference($post);

            // Вывод пользователя
            $userModel = new UsersModel();
            $userModel->withPermissions()->where('email', $post['email']);
            $user = $userModel->first();
            if (empty($user))
                throw new \Exception(ErrorMessages::$messages[100]);

            if(empty($user->is_registered))
                throw new \Exception(ErrorMessages::get(111));

            // Проверка пароля
            if($user->checkRecoveryPassword($post['password'])) {
                $user->password = $post['password'];
                $user->password_recovery = '';
                $userModel->save($user);
            } elseif($user->checkPassword($post['password']) === false) {
                throw new \Exception(ErrorMessages::get(100));
            }

            // Проверка подтверждения почты
            if (empty($user->email_confirmed))
                throw new \Exception(ErrorMessages::$messages[107]);

            // Сохранить сессию пользователя с временной зоной
            $user->timezone = app_timezone();
            if(!empty($post['timezone']))
                $user->timezone = $post['timezone'];
            UserSession::set($user);

            // Ответ
            $url = $this->request->getCookie('lastPagePath');
            $url = (empty($url)) ? '/' : $url;
            Output::ok(['url' => $url]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}