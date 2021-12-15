<?php namespace App\Entities\ArchiveFiles;

use CodeIgniter\Entity;

class ArchiveFileView extends Entity
{
    public static function getRows($archive_files)
    {
        $rows = '';
        foreach ($archive_files as $item) {
            $item = $item->toRawArray();
            $rows .= self::getRow($item);
        }
        return $rows;
    }

    public static function getRow(array $item)
    {
        return view('templates/conference/archives/archive_file', $item);
    }

    public static function getEditorRows(array $archive_files)
    {
        $rows = '';
        foreach ($archive_files as $item) {
            $item = $item->toRawArray();
            $rows .= self::getEditorRow($item);
        }
        return $rows;
    }

    public static function getEditorRow(array $item)
    {
        return view('templates/editor/archives/archive_file', $item);
    }
}