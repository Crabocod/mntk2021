<?php namespace App\Entities\Roles;

use CodeIgniter\Entity;

class RoleStorage extends Entity
{
    public static function set($roles)
    {
        return session()->set('roles', $roles);
    }

    public static function get($id = null)
    {
        $session = session();
        if(isset($id))
            return (isset($session->roles[$id])) ? $session->roles[$id] : false;
        else
            return session()->roles;
    }
}