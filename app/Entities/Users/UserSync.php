<?php namespace App\Entities\Users;

use CodeIgniter\Entity;

class UserSync extends Entity
{
    private $conferences = array();

    private function __construct()
    {
        parent::__construct();
    }

    public static function setConferences(array $userConferences)
    {
        $thisUserConferences = new UserSync();
        foreach ($userConferences as $conf) {
            $thisUserConferences->conferences[$conf] = true;
        }
        return $thisUserConferences;
    }

    public function hasConf($conference)
    {
        return isset($this->conferences[$conference]);
    }
}