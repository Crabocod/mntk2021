<?php namespace App\Entities\Users;

use CodeIgniter\Entity;

class UserRole extends Entity
{
    private $permissions = array();

    private function __construct()
    {
        parent::__construct();
    }

    public static function setRolePerms(array $perms)
    {
        $userRole = new UserRole();
        foreach ($perms as $perm) {
            $userRole->permissions[$perm['title']] = true;
        }
        return $userRole;
    }

    public function hasPerm($permission)
    {
        return isset($this->permissions[$permission]);
    }
}
