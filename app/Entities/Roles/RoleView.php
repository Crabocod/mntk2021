<?php namespace App\Entities\Roles;

use CodeIgniter\Entity;

class RoleView extends Entity
{
    public static function getOptions($roles, $id = 0)
    {
        $options = '';
        foreach ($roles as $role) {
            $selected = ($role['id'] == $id) ? 'selected' : '';
            $options .= '<option '.$selected.' value="'.$role['id'].'">'.$role['title'].'</option>';
        }
        return $options;
    }
}