<?php namespace App\Controllers\Pages\Conference;

use App\Entities\Users\User;
use App\Entities\Users\UserSession;
use App\Entities\Users\UserValid;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\UserConfirms;
use App\Models\Users;

class Registration extends BaseController
{
    public function index()
    {
        echo view('pages/conference/registration');
    }

    public function register()
    {
        $usersModel = new Users();
        $userConfirmsModal = new UserConfirms();
        $mailerModel = new \App\Models\Mailer();
        $mailer = new \App\Entities\Mailers\Mailer();

        try {
            $post = $this->request->getPost();
            UserValid::registration($post);

            // Должен существовать пользователь с таким email
            $usersModel->where('role_id', 3);
            $usersModel->where('email', $post['email']);
            if(!empty($post['phone']))
                $usersModel->orWhere('phone', $post['phone']);
            $user = $usersModel->first();
            if(empty($user))
                throw new \Exception(ErrorMessages::get(210));

            if(!empty($user->is_registered))
                throw new \Exception(ErrorMessages::get(211));

            // Обновление данных
            $user->full_name = $post['full_name'];
            if(!empty($post['phone']))
                $user->phone = $post['phone'];
            $user->password = $post['password'];
            $user->role_id = 3;
            $usersModel->save($user);
            if(!empty($usersModel->errors()))
                throw new \Exception(ErrorMessages::get(205));

            // Создаем данные для подтверждения почты
            $data = [
                'user_id' => $user->id,
                'type' => 'email',
                'value' => $user->email,
                'code' => md5(rand(100000, 999999))
            ];
            $userConfirmsModal->insert($data);

            // Отправка письма с подтверждением
            $message = view('emails/confirm_email', [
                'site_name' => $_SERVER['HTTP_HOST'],
                'href' => base_url('/registration/confirm-email').'?code='.$data['code']
            ]);
            $mailer->user_email = $user->email;
            $mailer->text = $message;
            $mailer->send_date = date("Y-m-d H:i:s");
            $mailer->status = 0;
            $mailer->subject = 'Подтверждение адреса электронной почты';
            $mailerModel->save($mailer);

            Output::ok([
                'message' => SuccessMessages::get(203)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function confirmEmail()
    {
        $usersModel = new Users();
        $userConfirmsModal = new UserConfirms();
        $session = session();

        try {
            $get = $this->request->getGet();
            UserValid::confirmEmail($get);

            // Поиск кода
            $confirm = $userConfirmsModal->where('code', $get['code'])->first();
            if(empty($confirm))
                throw new \Exception(ErrorMessages::get(108));

            // Пользователь подтвержден
            $usersModel->where('id', $confirm['user_id']);
            $usersModel->set('email_confirmed', 1);
            $usersModel->set('is_registered', 1);
            $usersModel->update();

            // Удаление кода
            $userConfirmsModal->where('user_id', $confirm['user_id'])->delete();

            $session->set('confirm_email', SuccessMessages::get(100));
            $session->markAsFlashdata('confirm_email');
            header('Location: /auth');
            exit();

        } catch (\Exception $e) {
            $session->set('confirm_email', ErrorMessages::get(109));
            $session->markAsFlashdata('confirm_email');
            header('Location: /auth');
            exit();
        }
    }
}