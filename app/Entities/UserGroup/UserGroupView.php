<?php namespace App\Entities\UserGroup;

use CodeIgniter\Entity;

class UserGroupView extends Entity
{
    public static function getEditorTableRows(array $groups = [])
    {
        $rows = '';
        $data = [];
        foreach ($groups as $item) {
            $data[$item['group_id']]['group_title'] = $item['group_title'];
            if(!isset($data[$item['group_id']]['user_group_count']))
                $data[$item['group_id']]['user_group_count'] = 1;
            else
                $data[$item['group_id']]['user_group_count'] += 1;
            $data[$item['group_id']]['users'][] = [
                'surname' => $item['user_surname'],
                'name' => $item['user_name'],
                'email' => $item['user_email']
            ];
        }
        foreach ($data as $item) {
            $rows .= self::getEditorTableRow($item);
        }
        return $rows;
    }

    public static function getEditorTableRow(array $group = [])
    {
        return view('templates/editor/groups/user_group_row', $group);
    }

    public static function getEditorTableHead()
    {
        return view('templates/editor/groups/user_group_head');
    }
}
