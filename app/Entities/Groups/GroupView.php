<?php namespace App\Entities\Groups;

use CodeIgniter\Entity;

class GroupView extends Entity
{
    public static function getEditorTableRows(array $groups = [])
    {
        $rows = '';
        foreach ($groups as $item) {
            $item = $item->toRawArray();
            $rows .= self::getEditorTableRow($item);
        }
        return $rows;
    }

    public static function getEditorTableRow(array $group = [])
    {
        return view('templates/editor/groups/table_row', $group);
    }
}
