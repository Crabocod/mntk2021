<?php namespace App\Controllers\Pages\Conference;

use App\Entities\Users\User;
use App\Entities\Users\UserSession;
use App\Entities\Users\UserValid;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Users;
use App\Models\Users as UsersModel;

class Recovery extends BaseController
{
    public function index()
    {
        echo view('pages/conference/recovery');
    }

    public function recoveryPassword()
    {
        try {
            $session = session();
            $usersModel = new Users();
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();

            // Валидация
            $post = $this->request->getPost();
            UserValid::recoveryPassword($post);

            // Вывод пользователя
            $userModel = new UsersModel();
            $userModel->where('email', $post['email']);
            $user = $userModel->first();
            if (empty($user))
                throw new \Exception(ErrorMessages::get(104));

            // Сохранение пользователя
            $generator = new \Password\Generator;
            $generator->setMinLength(8);
            $generator->setNumberOfNumbers(2);
            $generator->setNumberOfSymbols(1);
            $password = $generator->generate();

            $user->password_recovery = User::getPasswordHash($password);
            $usersModel->save($user);

            // Отправка сообщения
            $data = view('emails/password_recovery', [
                'name' => $user->full_name,
                'site_name' => $_SERVER['HTTP_HOST'],
                'password' => $password
            ]);

            $mailer->user_email = $user->email;
            $mailer->text = $data;
            $mailer->send_date = date("Y-m-d H:i:s");
            $mailer->status = 0;
            $mailer->subject = 'Активация нового пароля';
            $mailerModel->save($mailer);

            $session->set('password_recovery', SuccessMessages::get(204));
            $session->markAsFlashdata('password_recovery');
            Output::ok([
                'message' => SuccessMessages::get(204)
            ]);

        } catch (\Exception $e) {
            $session->set('password_recovery', $e->getMessage());
            $session->markAsFlashdata('password_recovery');
            Output::error(['message' => $e->getMessage()]);
        }
    }
}