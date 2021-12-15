<?php namespace App\Controllers\Pages\Editor;

use App\Entities\Users\User;
use App\Entities\Users\UserSender;
use App\Entities\Users\UserValid;
use App\Entities\Users\UserView;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\UserConferences;
use App\Models\UserGroup;

class Users extends BaseController
{
    public function index($conference_id)
    {
        $userModel = new \App\Models\Users();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $userModel->select('users.*');
        $userModel->join('user_conferences uc', '(uc.user_id=users.id and uc.conference_id='.$conference_id.')', 'left');
        $userModel->where('role_id', 3);
        $userModel->where('uc.conference_id', $conference_id);
        $users = $userModel->findAll();
        $data['users'] = \App\Entities\Users\UserView::getUsersCards($users);

        echo view('pages/editor/users', $data);
    }

    public function save($conference_id)
    {
        try {
            $userModel = new \App\Models\Users();
            $userConfModel = new \App\Models\UserConferences();
            $user = new \App\Entities\Users\User();

            $post = $this->request->getPost();
            UserValid::save($post);

            if (isset($post['id']))
                $userModel->where('users.id!=', $post['id']);

            $res = $userModel->where('email', $post['email'])->first();

            if (!empty($res)) {
                if (!isset($post['id'])) {
                    $res1 = $userConfModel->where('user_id', $res->id)->where('conference_id', $conference_id)->first();

                    if (!empty($res1)) {
                        if ($res->role_id == 1)
                            throw new \Exception(ErrorMessages::get(205));
                        elseif ($res->role_id == 2)
                            throw new \Exception(ErrorMessages::get(206));
                        elseif ($res->role_id == 3)
                            throw new \Exception(ErrorMessages::get(201));
                    }else{
                        $exist_user_id = $res->id;
                    }
                }else{
                    if ($res->role_id == 1)
                        throw new \Exception(ErrorMessages::get(205));
                    elseif ($res->role_id == 2)
                        throw new \Exception(ErrorMessages::get(206));
                    elseif ($res->role_id == 3)
                        throw new \Exception(ErrorMessages::get(201));
                }
            }

            if (isset($post['id'])) {
                $user->id = $post['id'];

            }elseif (isset($exist_user_id)){
                $user->id = $exist_user_id;
            } else{

                $newPass = User::genPassword();
                $user->password = $newPass;
            }
            if (isset($post['name']))
                $user->name = $post['name'];
            if (isset($post['surname']))
                $user->surname = $post['surname'];
            if (isset($post['email']))
                $user->email = $post['email'];
            if (isset($post['og_title']))
                $user->og_title = $post['og_title'];
            $user->role_id = 3;


            $userModel->save($user);
            if (empty($post['id']))
                $user->id = $userModel->getInsertID();
            if (isset($exist_user_id)){
                $user->id = $exist_user_id;
            }

            $html = '';
            $message = SuccessMessages::get(201);
            if (!isset($post['id'])) {
                $data = [
                    'conference_id' => $conference_id,
                    'user_id' => ($user->id == 0) ? $exist_user_id : $user->id,
                ];
                $userConfModel->insert($data);

                $html = \App\Entities\Users\UserView::getUserCard($user->toArray());
                $message = SuccessMessages::get(200);
            }

            Output::ok(['message' => $message, 'html' => $html]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function delete($conference_id)
    {
        $userModel = new \App\Models\Users();
        $user = new \App\Entities\Users\User();
        $userConfModel = new \App\Models\UserConferences();
        $userGroupModel = new UserGroup();
        $groupsModel = new \App\Models\Groups();

        $post = $this->request->getPost();

        $user->id = $post['id'];
        $user->updated_at = date("Y-m-d H:i:s");
        $userModel->save($user);

        $userConfModel->where('user_id', $post['id']);
        $userConfModel->where('conference_id', $conference_id);
        $userConfModel->delete();

        $groups = $groupsModel->where('conference_id', $conference_id)->find();
        $groupsIds = [];
        foreach ($groups as $group) {
            $groupsIds[] = $group->id;
        }
        if(!empty($groupsIds)) {
            $userGroupModel->where('user_id', $post['id']);
            $userGroupModel->whereIn('group_id', $groupsIds);
            $userGroupModel->delete();
        }

        Output::ok([]);
    }

    public function sendPass($conference_id)
    {
        try {
            $post = $this->request->getPost();

            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();
            $userModel = new \App\Models\Users();
            $user = $userModel->where('id', $post['id'])->first();
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

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function addFromExcel($conference_id)
    {
        try {
            $usersModel = new \App\Models\Users();
            $userConferencesModel = new UserConferences();

            $file = $this->request->getFile('import-exl');

            // Валидация файла
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            UserValid::addUsersFromExcel($this->request);

            // Вывод массива пользователей из Excel таблицы
            $inputFileName = $file->getRealPath();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
            $sheet = $spreadsheet->getActiveSheet();
            $users = $sheet->toArray();

            // Пользователи которые уже добавлены в эту конференцию
            $existingUsers = [];
            // Пользователи с ошибками
            $errorUsers = [];
            // Новые пользователи
            $newUsers = [];
            // Пользователи из другой конференции, которых нужно будет обновить
            $updateUsers = [];

            // Массив всех email пользователей из excel таблицы
            $usersEmail = [];

            $i = 0;
            foreach ($users as $data) {
                $i++;

                // Обработка данных
                $data[0] = trim(preg_replace("/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u", "", $data[0]));
                $data[1] = trim(preg_replace("/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u", "", $data[1]));
                $data[2] = trim(preg_replace("/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u", "", $data[2]));
                $data[3] = trim(preg_replace("/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u", "", $data[3]));

                if(empty($data[0]) and empty($data[1]) and empty($data[2]) and empty($data[3]))
                    continue;

                $user = new User();
                $user->name = (@$data[0])?$data[0]:'';
                $user->surname = (@$data[1])?$data[1]:'';
                $user->email = (@$data[2])?$data[2]:'';
                $user->og_title = (@$data[3])?$data[3]:'';
                $user->role_id = 3;
                $user->excel_row = $i;

                // Валидация
                try {
                    UserValid::add($user->toArray());
                } catch (\Exception $e) {
                    $errorUsers[] = $user;
                    continue;
                }

                // Если в таблице дублируется email, то учитываем только первый
                if(in_array($user->email, $usersEmail))
                    continue;
                $usersEmail[] = $user->email;

                // Проверка на дублирование в БД
                $usersModel->select('users.*');
                $usersModel->select('uc.conference_id as uc_id');
                $usersModel->join('user_conferences uc', '(uc.user_id=users.id and uc.conference_id='.$conference_id.')', 'left');
                $usersModel->where('email', $user->email);
                $duplicate = $usersModel->first();
                if(!empty($duplicate)) {
                    $user->id = $duplicate->id;
                    if(!empty($duplicate->uc_id))
                        $existingUsers[] = $user;
                    else
                        $updateUsers[] = $user;
                    continue;
                }

                // Новый пользователь
                $user->password = $user->origin_password = $user->genPassword();
                $newUsers[] = $user;
            }

            // Добавление пользователя и его конференции
            if(!empty($newUsers)) {
                foreach ($newUsers as $user) {
                    $usersModel->save($user);
                    $user->id = $usersModel->getInsertID();
                    $userConferencesModel->insert(['user_id' => $user->id, 'conference_id' => $this->conference->id]);
                }
            }

            // Обновление пользователя и добавление конференции
            if(!empty($updateUsers)) {
                foreach ($updateUsers as $user) {
                    $usersModel->save($user);
                    $userConferencesModel->insert(['user_id' => $user->id, 'conference_id' => $this->conference->id]);
                }
            }

            $html = \App\Entities\Users\UserView::getUsersCards($newUsers);
            $html .= \App\Entities\Users\UserView::getUsersCards($updateUsers);
            Output::ok([
                'html' => $html,
                'message' => UserView::getAddExcelResult(array_merge($newUsers, $updateUsers), $existingUsers, $errorUsers)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sendAllPass($conference_id)
    {
        try {
            $userConfModel = new \App\Models\UserConferences();
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();
            $userModel = new \App\Models\Users();

            $userModel->join('user_conferences uc', '(uc.user_id=users.id and uc.conference_id='.$conference_id.')');
            $userModel->where('users.pass_send', 0);
            $userModel->where('users.role_id', 3);
            $users = $userModel->find();
            if (count($users) > 0) {
                foreach ($users as $item) {
                    $user = $userModel->where('id', $item->user_id)->first();
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
                }
                Output::ok(['message' => 'Пароли успешно отправлены']);
            }else{
                Output::ok(['message' => 'Нет пользователей для отправки паролей']);
            }
        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}