<?php namespace App\Controllers\Pages\OldConference;

use App\Controllers\Pages\BaseController;
use App\Entities\Users\User;
use App\Entities\Users\UserSession;
use App\Entities\Users\UserValid;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Conferences;
use App\Models\Users as UsersModel;

class Auth extends BaseController
{
    public function index()
    {
        echo view('pages/conference/auth');
    }

    public function login($url_segment)
    {
        try {
            // Валидация
            $post = $this->request->getPost();
            $post['url_segment'] = $url_segment;
            UserValid::authConference($post);

            // Вывод пользователя
            $userModel = new UsersModel();
            $userModel->withPermissions()->withConferences()->where('email', $post['email']);
            $user = $userModel->first();
            if (empty($user)) throw new \Exception(ErrorMessages::$messages[100]);

            // Проверка пароля
            $result = $user->checkPassword($post['password']);
            if (!$result) throw new \Exception(ErrorMessages::$messages[100]);

            // Проверка что редактор или пользователь имеют доступ к конференции
            if (!$user->hasPrivilege('admin') and !$user->hasConference($post['url_segment']))
                throw new \Exception(ErrorMessages::$messages[103]);

            // Сохранить сессию пользователя с временной зоной
            $user->timezone = app_timezone();
            if(!empty($post['timezone']))
                $user->timezone = $post['timezone'];
            UserSession::set($user);

            // Ответ
            $url = $this->request->getCookie('lastPagePath');
            $url = (empty($url)) ? '/' . $post['url_segment'] : $url;
            Output::ok(['url' => $url]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function recoveryPassword($url_segment)
    {
        try {
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();

            // Валидация
            $post = $this->request->getPost();
            $post['url_segment'] = $url_segment;
            UserValid::recoveryPassword($post);

            // Вывод пользователя
            $userModel = new UsersModel();
            $userModel->withPermissions()->withConferences()->where('email', $post['email']);
            $user = $userModel->first();
            if (empty($user)) throw new \Exception(ErrorMessages::get(104));

            // Проверка что редактор или пользователь имеют доступ к конференции
            if (!$user->hasPrivilege('admin') and !$user->hasConference($post['url_segment']))
                throw new \Exception(ErrorMessages::get(103));

            // Сохранение пользователя
            $newPass = User::genPassword();
            $user->password = $newPass;
            $userModel->save($user);

            // Отправка сообщения
            $data = view('emails/password_recovery', [
                'name' => @$user->surname . ' ' . @$user->name,
                'site_name' => $_SERVER['HTTP_HOST'],
                'password' => $newPass
            ]);

            $mailer->user_email = $user->email;
            $mailer->text = $data;
            $mailer->send_date = date("Y-m-d H:i:s");
            $mailer->status = 0;
            $mailer->subject = 'Активация нового пароля';
            $mailerModel->save($mailer);

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}
