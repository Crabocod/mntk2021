<?php namespace App\Entities\Users;

use CodeIgniter\Entity;

class User extends Entity
{
    private $role;
    private $role_title;
    private $conferences;
    private $sync;

    public function setPassword(string $pass)
    {
        $this->attributes['password'] = self::getPasswordHash($pass);
        return $this;
    }

    public function setEmail(string $email)
    {
        $this->attributes['email'] = strtolower($email);
        return $this;
    }

    public function checkPassword($password)
    {
        $password = mb_strtolower($password);
        return password_verify($password, $this->password);
    }

    public function checkRecoveryPassword($password)
    {
        $password = mb_strtolower($password);
        return password_verify($password, $this->password_recovery);
    }

    public static function getPasswordHash($password)
    {
        $password = mb_strtolower($password);
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function genPassword()
    {
        $passGenerator = new \Password\Generator();
        $passGenerator->setMinLength(8);
        $passGenerator->setNumberOfUpperCaseLetters(3);
        $passGenerator->setNumberOfNumbers(2);
        return $passGenerator->generate();
    }

    public function hasPrivilege(string $title) {
        return $this->role->hasPerm($title);
    }

    public function setRoleOneTime(UserRole $role) {
        if(empty($this->role)) {
            $this->role = $role;
            return true;
        }
        return false;
    }

    public function hasConference($url_segment = '') {
        return $this->conferences->hasConf($url_segment);
    }

    public function setConferencesOneTime(UserConferences $userConferences)
    {
        if(empty($this->conferences)) {
            $this->conferences = $userConferences;
            return true;
        }
        return false;
    }

    public function setRoleTitle($role = '')
    {
        $this->attributes['role_title'] = $role;
        return $this;
    }

    public function hasSync($url_segment = '') {
        return $this->sync->hasConf($url_segment);
    }

    public function setSyncOneTime(UserSync $userSync)
    {
        if(empty($this->sync)) {
            $this->sync = $userSync;
            return true;
        }
        return false;
    }
}
