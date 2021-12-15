<?php namespace App\Controllers\Pages\OldAdmin;

use App\Entities\Conferences\ConferenceView;
use App\Entities\Users\User;
use App\Entities\Users\UserSession;
use App\Entities\Users\UserValid;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Models\Users as UsersModel;
use CodeIgniter\Controller;
use App\Models\Conferences;

class Auth extends Controller
{
    public function index()
    {
        echo view('pages/admin/auth');
    }

    public function login()
    {
        try {
            // Валидация
            $post = $this->request->getPost();
            UserValid::authAdminConference($post);

            // Вывод пользователя
            $userModel = new UsersModel();
            $userModel->withPermissions()->withConferences()->where('email', $post['email']);
            $user = $userModel->first();
            if (empty($user)) throw new \Exception(ErrorMessages::$messages[100]);

            // Проверка пароля
            $result = $user->checkPassword($post['password']);
            if (!$result) throw new \Exception(ErrorMessages::$messages[100]);

            // Проверка что это админ
            if (!$user->hasPrivilege('admin'))
                throw new \Exception(ErrorMessages::$messages[4]);

            // Сохранить сессию пользователя с временной зоной
            $user->timezone = app_timezone();
            if(!empty($post['timezone']))
                $user->timezone = $post['timezone'];
            UserSession::set($user);

            // Ответ
            $url = $this->request->getCookie('lastPagePath');
            $url = (empty($url)) ? '/admin' : $url;
            Output::ok(['url' => $url]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function recoveryPassword()
    {
        try {
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();

            // Валидация
            $post = $this->request->getPost();
            UserValid::recoveryPassword($post);

            // Вывод пользователя
            $userModel = new UsersModel();
            $userModel->withPermissions()->withConferences()->where('email', $post['email']);
            $user = $userModel->first();
            if (empty($user)) throw new \Exception(ErrorMessages::get(105));

            // Проверяем что пользователь имеет право в админку
            if (!$user->hasPrivilege('admin'))
                throw new \Exception(ErrorMessages::get(4));

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