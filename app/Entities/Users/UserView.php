<?php namespace App\Entities\Users;

use CodeIgniter\Entity;

class UserView extends Entity
{
    public static function getTableHead()
    {
        return view('templates/users/table_head');
    }

    public static function getTableRows(array $users)
    {
        $rows = '';
        foreach ($users as $user) {
            $rows .= self::getTableRow($user);
        }
        return $rows;
    }

    public static function getTableRow(User $user)
    {
        $parser = \Config\Services::parser();
        return $parser->setData($user->toRawArray())->render('templates/users/table_row');
    }

    public static function getOptions($users, $id = 0)
    {
        $options = '';
        foreach ($users as $user) {
            $selected = ($user->id == $id) ? 'selected' : '';
            $options .= '<option ' . $selected . ' value="' . $user->id . '">' . $user->alias . '</option>';
        }
        return $options;
    }

    public static function getAdminsCards($admin_users)
    {
        $cards = '';
        foreach ($admin_users as $admin_user) {
            $admin_user = $admin_user->toRawArray();
            $cards .= self::getAdminCard($admin_user);
        }
        return $cards;
    }

    public static function getAdminCard(array $admin_user)
    {
        return view('templates/admin/admin_users/admin_card', $admin_user);
    }

    public static function getEditorsCards($editors, $conferences, $userConf)
    {
        $cards = '';
        foreach ($editors as $editor) {
            $editor = $editor->toRawArray();
            $cards .= self::getEditorCard($editor, $conferences, $userConf);
        }
        return $cards;
    }

    public static function getEditorCard(array $editor, array $conferences, array $userConf)
    {
        $editor['conferences'] = $conferences;
        $editor['userConf'] = $userConf;

        return view('templates/admin/editors/editor_card', $editor);
    }

    public static function getModeratorsUserRows($users)
    {
        $cards = '';
        foreach ($users as $user) {
            $user = $user->toRawArray();
            $cards .= self::getModeratorUserRow($user);
        }
        return $cards;
    }

    public static function getModeratorUserRow(array $user)
    {
        return view('templates/admin/users/moderator_user_row', $user);
    }

    public static function getUserRows($users)
    {
        $cards = '';
        foreach ($users as $user) {
            $user = $user->toRawArray();
            $cards .= self::getUserRow($user);
        }
        return $cards;
    }

    public static function getUserRow(array $user)
    {
        return view('templates/admin/users/user_row', $user);
    }

    public static function getUsersCards($users)
    {
        $cards = '';
        foreach ($users as $user) {
            $user = $user->toRawArray();
            $cards .= self::getUserCard($user);
        }
        return $cards;
    }

    public static function getUserCard(array $user)
    {
        return view('templates/editor/users/user_card', $user);
    }

    public static function getAddExcelResult(array $addedUsers = [], array $existingUsers = [], array $errorUsers = [])
    {
        $data['count_add'] = count($addedUsers);
        $data['count_existing'] = count($existingUsers);
        $data['count_error'] = count($errorUsers);
        $data['error_users'] = $errorUsers;
        return view('templates/editor/users/add_excel_result', $data);
    }
}