<?php namespace App\Entities\FileExts;

use CodeIgniter\Entity;

class FileExtsStorage extends Entity
{
    public static function set($exts)
    {
        return session()->set('file_exts', $exts);
    }

    public static function get($id = null)
    {
        $session = session();
        if(isset($id))
            return (isset($session->file_exts[$id])) ? $session->file_exts[$id] : false;
        else
            return session()->file_exts;
    }

    public static function getByExtension($str = '')
    {
        $str = mb_strtolower($str);
        $file_exts = session()->file_exts;
        foreach ($file_exts as $ext) {
            if($ext['file_extension'] == $str)
                return $ext;
        }
        return false;
    }
}