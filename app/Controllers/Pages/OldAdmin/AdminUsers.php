<?php namespace App\Controllers\Pages\OldAdmin;


use App\Entities\Users\User;
use App\Entities\Users\UserSession;
use App\Entities\Users\UserValid;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use CodeIgniter\Controller;
use mysql_xdevapi\Exception;

class AdminUsers extends BaseController
{
    public function index()
    {
        $data['url_segments'] = $this->request->uri->getSegments();

        $userModel = new \App\Models\Users();

        $admin_users = $userModel->where('role_id', 1)->findAll();

        $data['admin_users'] = \App\Entities\Users\UserView::getAdminsCards($admin_users);
        echo view('pages/admin/admin_users', $data);
    }

    public function save()
    {
        try {
            $userModel = new \App\Models\Users();
            $user = new \App\Entities\Users\User();
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();

            $post = $this->request->getPost();
            UserValid::save($post);

            if (isset($post['id']))
                $userModel->where('id!=', $post['id']);
            $res = $userModel->where('email', $post['email'])->first();
            if (!empty($res)) {
                if ($res->role_id == 1)
                    throw new \Exception(ErrorMessages::get(205));
                elseif ($res->role_id == 2)
                    throw new \Exception(ErrorMessages::get(206));
                elseif ($res->role_id == 3)
                    throw new \Exception(ErrorMessages::get(201));
            }

            if (isset($post['id'])) {
                $user->id = $post['id'];
            }else{
                $newPass = User::genPassword();
                $user->password = $newPass;
            }
            if (isset($post['name']))
                $user->name = $post['name'];
            if (isset($post['surname']))
                $user->surname = $post['surname'];
            if (isset($post['email']))
                $user->email = $post['email'];
            $user->role_id = 1;
            $userModel->save($user);

            $html = '';
            $message = SuccessMessages::get(201);
            if (!isset($post['id'])) {
                $user->id = $userModel->getInsertID();
                $html = \App\Entities\Users\UserView::getAdminCard($user->toArray());

                $message = SuccessMessages::get(200);
            }

            Output::ok(['message' => $message, 'html' => $html]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sendPass()
    {
        try {
            $post = $this->request->getPost();

            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();
            $userModel = new \App\Models\Users();
            $user = $userModel->where('id', $post['id'])->first();
            if ($user->pass_send == 0) {
                $newPass = User::genPassword();
                $user->password = $newPass;
                $user->pass_send = 1;
                $userModel->save($user);

                $message = view('emails/password_recovery', [
                    'name' => @$user->surname . ' ' . @$user->name,
                    'site_name' => $_SERVER['HTTP_HOST'],
                    'password' => $newPass
                ]);

                $mailer->user_email = $user->email;
                $mailer->text = $message;
                $mailer->send_date = date("Y-m-d H:i:s");
                $mailer->status = 0;
                $mailer->subject = 'Активация нового пароля';
                $mailerModel->save($mailer);
                Output::ok(['message' => 'Пароль успешно отправлен']);
            }
            else{
                Output::ok(['message' => 'Пароль уже был отправлен этому пользователю']);
            }
        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        $post = $this->request->getPost();
        $user = UserSession::getUser();
        if ($user->id != $post['id']) {
            $userModel = new \App\Models\Users();
            $userModel->where('id', $post['id'])->delete();
            Output::ok([]);
        } else {
            Output::error([
                'message' => 'Вы не можете удалить самого себя'
            ]);
        }
    }
}