<?php namespace App\Controllers\Pages\Editor;

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
        $conferencesModel = new Conferences();
        $conferences = $conferencesModel->findAll();

        $data['conferences'] = ConferenceView::getOptions($conferences);
        echo view('pages/editor/auth', $data);
    }

    public function login()
    {
        try {
            $userModel = new UsersModel();
            $conferencesModel = new Conferences();

            // Валидация
            $post = $this->request->getPost();
            UserValid::authEditorConference($post);

            // Вывод конференции
            $conference = $conferencesModel->where('url_segment', $post['conference_url'])->first();
            if(empty($conference))
                throw new \Exception(ErrorMessages::get(300));

            // Вывод пользователя
            $userModel->withPermissions()->withConferences()->where('email', $post['email']);
            $user = $userModel->first();
            if (empty($user)) throw new \Exception(ErrorMessages::$messages[100]);

            // Проверка пароля
            $result = $user->checkPassword($post['password']);
            if (!$result) throw new \Exception(ErrorMessages::$messages[100]);

            // Проверка что у пользователя есть доступ
            if (!$user->hasPrivilege('admin') and (!$user->hasPrivilege('editor') or !$user->hasConference($conference->url_segment)))
                throw new \Exception(ErrorMessages::$messages[4]);

            // Сохранить сессию пользователя с временной зоной
            $user->timezone = app_timezone();
            if(!empty($post['timezone']))
                $user->timezone = $post['timezone'];
            UserSession::set($user);

            // Ответ
            $url = $this->request->getCookie('lastPagePath');
            $url = (empty($url)) ? '/editor/'.$conference->id : $url;
            Output::ok(['url' => $url]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function recoveryPassword()
    {
        try {
            $userModel = new UsersModel();
            $conferencesModel = new Conferences();
            $passGenerator = new \Password\Generator();
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();

            // Валидация
            $post = $this->request->getPost();
            UserValid::recoveryPassword($post);

            // Вывод пользователя
            $userModel->withPermissions()->withConferences()->where('email', $post['email']);
            $user = $userModel->first();
            if (empty($user)) throw new \Exception(ErrorMessages::get(106));

            // Проверяем что редактор имеет доступ к конференции
            if (!$user->hasPrivilege('editor'))
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