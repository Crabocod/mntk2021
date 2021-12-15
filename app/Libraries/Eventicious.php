<?php namespace App\Libraries;

use App\Entities\Groups\Group;
use App\Entities\Users\User;

class Eventicious
{
    private $api_key = '';

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function addUser(User $user)
    {
        $full_name = trim($user->full_name);
        $segments = explode(' ', $full_name);
        if(count($segments) > 1) {
            $data['firstName'] = $segments[1];
            $data['lastName'] = $segments[0];
        } else {
            $data['firstName'] = $full_name;
            $data['lastName'] = '?';
        }
        $data['id'] = $user->id;
        $data['email'] = $user->email;

        try {
            $curl = \Config\Services::curlrequest();
            $response = $curl->setBody(json_encode($data))->request('POST', 'https://api.eventicious.com/api/external/Speakers/Create', [
                'headers' => [
                    'Authorization' => 'Secret '.$this->api_key,
                    'Content-Type' => 'application/json'
                ],
                'connect_timeout' => 5
            ]);

            return $response;

        } catch (\Exception $e) {
            log_message('info', 'App\Libraries\Eventicious\addUser: Исключение - '.$e->getMessage());
            return false;
        }
    }

    public function updateUser(User $user)
    {
        $full_name = trim($user->full_name);
        $segments = explode(' ', $full_name);
        if(count($segments) > 1) {
            $data['firstName'] = $segments[1];
            $data['lastName'] = $segments[0];
        } else {
            $data['firstName'] = $full_name;
            $data['lastName'] = '?';
        }
        $data['id'] = $user->id;
        $data['email'] = $user->email;

        try {
            $curl = \Config\Services::curlrequest();
            $response = $curl->setBody(json_encode($data))->request('PUT', 'https://api.eventicious.com/api/external/Speakers/Update/'.$user->id, [
                'headers' => [
                    'Authorization' => 'Secret '.$this->api_key,
                    'Content-Type' => 'application/json'
                ],
                'connect_timeout' => 5
            ]);

            return $response;

        } catch (\Exception $e) {
            log_message('info', 'App\Libraries\Eventicious\updateUser: Исключение - '.$e->getMessage());
            return false;
        }
    }

    public function deleteUser(User $user)
    {
        try {
            $curl = \Config\Services::curlrequest();
            $response = $curl->request('DELETE', 'https://api.eventicious.com/api/external/Speakers/Delete/'.$user->id, [
                'headers' => [
                    'Authorization' => 'Secret '.$this->api_key,
                    'Content-Type' => 'application/json'
                ],
                'connect_timeout' => 5
            ]);

            return $response;

        } catch (\Exception $e) {
            log_message('info', 'App\Libraries\Eventicious\deleteUser: Исключение - '.$e->getMessage());
            return false;
        }
    }

    public function addGroup(Group $group)
    {
        $data['id'] = $group->id;
        $data['name'] = $group->title;

        try {
            $curl = \Config\Services::curlrequest();
            $response = $curl->setBody(json_encode($data))->request('POST', 'https://api.eventicious.com/api/external/ACLGroups/Create', [
                'headers' => [
                    'Authorization' => 'Secret '.$this->api_key,
                    'Content-Type' => 'application/json'
                ],
                'connect_timeout' => 5
            ]);

            return $response;

        } catch (\Exception $e) {
            log_message('info', 'App\Libraries\Eventicious\addGroup: Исключение - '.$e->getMessage());
            return false;
        }
    }

    public function updateGroup(Group $group)
    {
        $data['id'] = $group->id;
        $data['name'] = $group->title;

        try {
            $curl = \Config\Services::curlrequest();
            $response = $curl->setBody(json_encode($data))->request('PUT', 'https://api.eventicious.com/api/external/ACLGroups/Update/'.$group->id, [
                'headers' => [
                    'Authorization' => 'Secret '.$this->api_key,
                    'Content-Type' => 'application/json'
                ],
                'connect_timeout' => 5
            ]);

            return $response;

        } catch (\Exception $e) {
            log_message('info', 'App\Libraries\Eventicious\updateGroup: Исключение - '.$e->getMessage());
            return false;
        }
    }

    public function deleteGroup(Group $group)
    {
        try {
            $curl = \Config\Services::curlrequest();
            $response = $curl->request('DELETE', 'https://api.eventicious.com/api/external/ACLGroups/Delete/'.$group->id, [
                'headers' => [
                    'Authorization' => 'Secret '.$this->api_key,
                    'Content-Type' => 'application/json'
                ],
                'connect_timeout' => 5
            ]);

            return $response;

        } catch (\Exception $e) {
            log_message('info', 'App\Libraries\Eventicious\deleteGroup: Исключение - '.$e->getMessage());
            return false;
        }
    }
}