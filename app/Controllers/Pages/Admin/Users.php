<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Users\User;
use App\Entities\Users\UserValid;
use App\Entities\Users\UserView;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;

class Users extends BaseController
{
    public function addFromExcel()
    {
        try {
            $usersModel = new \App\Models\Users();


            $file = $this->request->getFile('import-exl');

            // Валидация файла
            $post = $this->request->getPost();
            UserValid::addUsersFromExcel($this->request);

            // Вывод массива пользователей из Excel таблицы
            $inputFileName = $file->getRealPath();
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
            $sheet = $spreadsheet->getActiveSheet();
            $users = $sheet->toArray();

            unset($users[0]);

            // Пользователи которые уже добавлены в эту конференцию
            $existingUsers = [];
            // Пользователи с ошибками
            $errorUsers = [];
            // Новые пользователи
            $newUsers = [];

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
                $data[4] = trim(preg_replace("/([^\pL\pN\pP\pS\pZ])|([\xC2\xA0])/u", "", $data[4]));

                if(empty($data[0]) and empty($data[1]) and empty($data[2]) and empty($data[3]))
                    continue;

                $user = new User();
                $user->full_name = (@$data[0])?$data[0]:'';
                $user->section_id = (@$data[1])?$data[1]:'';
                $user->phone = (@$data[2])?intval($data[2]):'';
                $user->email = (@$data[3])?$data[3]:'';
                $user->og_title = (@$data[4])?$data[4]:'';
                $user->role_id = 3;

                // Валидация
                try {
                    UserValid::save($user->toArray());
                } catch (\Exception $e) {
                    $errorUsers[] = $user;
                    continue;
                }

                // Если в таблице дублируется email, то учитываем только первый
                if(in_array($user->email, $usersEmail))
                    continue;
                $usersEmail[] = $user->email;

                // Проверка на дублирование в БД
                $usersModel->where('email', $user->email);
                $duplicate = $usersModel->first();
                if(!empty($duplicate)) {
                    $existingUsers[] = $user;
                    continue;
                }

                // Новый пользователь
                $newUsers[] = $user;
            }

            // Добавление пользователя и его конференции
            if(!empty($newUsers)) {
                foreach ($newUsers as $user) {
                    $usersModel->save($user);
                }
            }

            Output::ok([
                'message' => UserView::getAddExcelResult($newUsers, $existingUsers, $errorUsers)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function showUser()
    {
        try {
            $usersModel = new \App\Models\Users();

            $users = $usersModel->where('role_id', '3')->findAll();

            Output::ok([
                'html' => UserView::getUserRows($users)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sendAllMail()
    {
        try {
            $usersModel = new \App\Models\Users();
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();

            $users = $usersModel->where('role_id', 3)->findAll();

            foreach ($users as $user) {
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
            }

            Output::ok([
                'message' => SuccessMessages::get(206)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sendMail()
    {
        try {
            $usersModel = new \App\Models\Users();
            $mailerModel = new \App\Models\Mailer();
            $mailer = new \App\Entities\Mailers\Mailer();

            $post = $this->request->getPost();
            UserValid::delete($post);

            $user = $usersModel->where('id', $post['id'])->first();

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


            Output::ok([
                'message' => SuccessMessages::get(205)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteUser()
    {
        try {
            $usersModel = new \App\Models\Users();

            $post = $this->request->getPost();
            UserValid::delete($post);

            $usersModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(202)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function addUser()
    {
        try {
            helper('string');
            $usersModel = new \App\Models\Users();
            $user = new \App\Entities\Users\User();

            $post = $this->request->getPost();
            $post['phone'] = get_simple_phone_number($post['phone']);
            UserValid::save($post);

            $user->fill($post);
            $user->role_id = 3;
            $usersModel->save($user);

            Output::ok([
                'message' => SuccessMessages::get((!empty($post['id']))?201:200)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function index()
    {
        echo view('pages/admin/users');
    }
}