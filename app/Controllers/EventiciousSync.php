<?php namespace App\Controllers;

use App\Entities\Users\User;
use App\Entities\Users\UserValid;
use App\Libraries\ErrorMessages;
use App\Models\Conference;
use App\Models\UserConferences;
use App\Models\Users;
use App\Libraries\Eventicious;
use App\Models\UserSync;
use CodeIgniter\Controller;

class EventiciousSync extends Controller
{
    public function index()
    {
        try {
            $conferenceModel = new Conference();

            $conference = $conferenceModel->first();

            if (empty($conference->eventicious_api_key))
                return;

            $eventiciousSync = new Eventicious($conference->eventicious_api_key);

            $usersModel = new Users();
            $users = $usersModel->query('
                SELECT users.* 
                FROM users 
                WHERE role_id = 3 AND email_confirmed = 1 AND (user_sync_at IS NULL OR user_sync_at<updated_at OR updated_at IS NULL OR (user_sync_at IS NOT NULL AND deleted_at IS NOT NULL))')->getResult('\App\Entities\Users\User');

            // Users: Create, Update, Delete
            foreach ($users as $user) {
                log_message('info', 'App\Controllers\EventiciousSync: Начинаем синхронизацию пользователя User_id: ' . $user->id);
                $response = false;

                if (empty($user->user_sync_at) && empty($user->deleted_at))
                    $response = $eventiciousSync->addUser($user);
                elseif (empty($user->updated_at) || strtotime($user->user_sync_at) < strtotime($user->updated_at))
                    $response = $eventiciousSync->updateUser($user);
                elseif (!empty($user->user_sync_at) && !empty($user->deleted_at))
                    $response = $eventiciousSync->deleteUser($user);

                $responseBody = [];
                if ($response instanceof \CodeIgniter\HTTP\Response)
                    $responseBody = json_decode($response->getBody(), true);

                if ($response !== false and (!empty($responseBody['id']) or @$responseBody['success'] == true)) {
                    if (empty($user->user_sync_at) && empty($user->deleted_at)) {
                        $usersModel->set('user_sync_at', date('Y-m-d H:i:s'));
                        $usersModel->where('id', $user->id);
                        $usersModel->update();
                    } elseif (empty($user->updated_at) || strtotime($user->user_sync_at) < strtotime($user->updated_at)) {
                        $usersModel->set('user_sync_at', date('Y-m-d H:i:s'));
                        $usersModel->where('id', $user->id);
                        $usersModel->update();
                    } elseif (!empty($user->user_sync_at) && !empty($user->deleted_at)) {
                        $usersModel->set('user_sync_at', NULL);
                        $usersModel->where('id', $user->id);
                        $usersModel->update();
                    }
                    log_message('info', 'App\Controllers\EventiciousSync: Успешная синхронизация пользователя Conference_id: ' . $conference->id . ' User_id: ' . $user->id);
                } else {
                    log_message('info', 'App\Controllers\EventiciousSync: Что то пошло не так у пользователя Conference_id: ' . $conference->id . ' User_id: ' . $user->id);
                }
            }

        } catch (\Exception $e) {
            log_message('error', 'App\Controllers\EventiciousSync: Исключение - ' . $e->getMessage());
        }
    }

    public function addUser($conference_id)
    {
        try {
            log_message('error', 'App\Controllers\EventiciousSync\addUser: Добавление нового пользователя');
            $userConferencesModel = new UserConferences();
            $conferenceModel = new Conferences();
            $userSyncModel = new UserSync();
            $usersModel = new Users();
            $newUser = new User();

            $conference = $conferenceModel->find($conference_id);
            if (empty($conference))
                throw new \Exception(ErrorMessages::$messages[300]);

            $json = $this->request->getJSON(true);
            if (empty($json))
                throw new \Exception(ErrorMessages::$messages[209]);

            $data['surname'] = @$json['LastName'];
            $data['name'] = @$json['FirstName'];
            $data['email'] = @$json['Email'];
            $data['role_id'] = 3;
            UserValid::addFromEventicious($data);

            $usersModel->where('email', $data['email']);
            $user = $usersModel->withConferences()->first();

            if (empty($user)) {
                $newUser->fill($data);
                $usersModel->save($newUser);
                $newUser->id = $usersModel->getInsertID();
                log_message('error', 'App\Controllers\EventiciousSync\addUser: Пользователь успешно создан. Conference_id: ' . $conference->id . ' User_id: ' . $newUser->id);

            } elseif (!$user->hasConference($conference->url_segment)) {
                $usersModel->update($user->id, $data);
                $newUser->id = $user->id;
                log_message('error', 'App\Controllers\EventiciousSync\addUser: Пользователь успешно создан. Conference_id: ' . $conference->id . ' User_id: ' . $newUser->id);

            } else {
                throw new \Exception(ErrorMessages::$messages[201]);
            }

            $userConferencesModel->insert(['user_id' => $newUser->id, 'conference_id' => $conference->id]);

            $userSyncModel->insert(['user_id' => $newUser->id, 'conference_id' => $conference->id]);

            echo json_encode(['id' => $newUser->id]);
            exit();

        } catch (\Exception $e) {
            log_message('error', 'App\Controllers\EventiciousSync\addUser: Исключение - ' . $e->getMessage());
        }
    }

    public function updateUser($conference_id, $user_id)
    {
        try {
            log_message('error', 'App\Controllers\EventiciousSync\updateUser: Обновление пользователя');
            $conferenceModel = new Conferences();
            $userSyncModel = new UserSync();
            $usersModel = new Users();

            $conference = $conferenceModel->find($conference_id);
            if (empty($conference))
                throw new \Exception(ErrorMessages::$messages[300]);

            $json = $this->request->getJSON(true);
            if (empty($json))
                throw new \Exception(ErrorMessages::$messages[209]);

            log_message('error', 'App\Controllers\EventiciousSync\updateUser: ' . json_encode($json));

            $data['id'] = $user_id;
            $data['surname'] = @$json['LastName'];
            $data['name'] = @$json['FirstName'];
            $data['email'] = @$json['Email'];
            UserValid::update($data);

            $user = $usersModel->withConferences()->withSync()->find($user_id);
            if (empty($user))
                throw new \Exception(ErrorMessages::$messages[200]);

            $usersModel->where('email', $data['email']);
            $usersModel->where('id!=', $user->id);
            $duplicate = $usersModel->first();
            if (!empty($duplicate))
                throw new \Exception(ErrorMessages::$messages[201]);

            $usersModel->update($user->id, $data);

            $userSyncModel->where('conference_id', $conference->id);
            $userSyncModel->where('user_id', $user->id);
            $sync = $userSyncModel->first();

            if (empty($sync)) {
                $userSyncModel->insert(['conference_id' => $conference->id, 'user_id' => $user->id]);
            } else {
                $userSyncModel->set('updated_at', date('Y-m-d H:i:s'));
                $userSyncModel->where('id', $sync['id']);
                $userSyncModel->update();
            }

        } catch (\Exception $e) {
            log_message('error', 'App\Controllers\EventiciousSync\updateUser: Исключение - ' . $e->getMessage());
        }
    }

    public function deleteUser($conference_id, $user_id)
    {
        try {
            log_message('error', 'App\Controllers\EventiciousSync\deleteUser: Удаление пользователя');
            $userConferencesModel = new UserConferences();
            $conferenceModel = new Conferences();
            $userSyncModel = new UserSync();
            $usersModel = new Users();

            $conference = $conferenceModel->find($conference_id);
            if (empty($conference))
                throw new \Exception(ErrorMessages::$messages[300]);

            $user = $usersModel->withConferences()->withSync()->find($user_id);
            if (empty($user))
                throw new \Exception(ErrorMessages::$messages[200]);

            if (!$user->hasConference($conference->url_segment))
                throw new \Exception(ErrorMessages::$messages[207]);

            if (!$user->hasSync($conference->url_segment))
                throw new \Exception(ErrorMessages::$messages[208]);

            $userConferencesModel->where('conference_id', $conference->id);
            $userConferencesModel->where('user_id', $user->id);
            $userConferencesModel->delete();

            $userSyncModel->where('conference_id', $conference->id);
            $userSyncModel->where('user_id', $user->id);
            $userSyncModel->delete();

        } catch (\Exception $e) {
            log_message('error', 'App\Controllers\EventiciousSync\deleteUser: Исключение - ' . $e->getMessage());
        }
    }
}