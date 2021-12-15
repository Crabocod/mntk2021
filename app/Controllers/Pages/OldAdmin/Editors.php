<?php namespace App\Controllers\Pages\OldAdmin;

use App\Entities\Users\User;
use App\Entities\Users\UserSession;
use App\Entities\Users\UserValid;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use CodeIgniter\Controller;

class Editors extends BaseController
{
    public function index()
    {
        $data['url_segments'] = $this->request->uri->getSegments();

        $userModel = new \App\Models\Users();
        $confModel = new \App\Models\Conferences();
        $userConfModel = new \App\Models\UserConferences();

        $userConf = $userConfModel->findAll();
        $conferences = $confModel->findAll();
        $editors = $userModel->where('role_id', 2)->findAll();

        $data['editors'] = \App\Entities\Users\UserView::getEditorsCards($editors, $conferences, $userConf);

        $options = '';
        for ($i = 0; $i < count($conferences); $i++){
            $conferences[$i] = $conferences[$i]->toRawArray();
            $options .= '<option value="'.$conferences[$i]['id'].'" >'.$conferences[$i]['url_segment'].'</option>';
        }
        $data['options'] = $options;
        echo view('pages/admin/editors', $data);
    }

    public function save()
    {
        try {
            $userModel = new \App\Models\Users();
            $userConfModel = new \App\Models\UserConferences();
            $user = new \App\Entities\Users\User();
            $confModel = new \App\Models\Conferences();
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
            if (isset($post['password']))
                $user->password = $post['password'];

            $user->role_id = 2;
            $userModel->save($user);
            if(empty($post['id']))
                $user->id = $userModel->getInsertID();

            $userConfModel->where('user_id', $user->id)->delete();

            if (isset($post['perm'])) {
                for ($i = 0; $i < count($post['perm']); $i++) {
                    $data = [
                        'user_id' => $user->id,
                        'conference_id' => $post['perm'][$i],
                    ];
                    $userConfModel->insert($data);
                }
            }

            $html = '';
            $message = SuccessMessages::get(201);
            if (!isset($post['id'])) {
                $userConf = $userConfModel->findAll();
                $conferences = $confModel->findAll();
                $html = \App\Entities\Users\UserView::getEditorCard($user->toArray(), $conferences, $userConf);

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

        $userModel = new \App\Models\Users();
        $userModel->where('id', $post['id'])->delete();
        Output::ok([]);
    }
}