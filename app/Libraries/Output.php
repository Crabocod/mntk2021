<?php namespace App\Libraries;

use Config\Services;

/**
 * Class Output
 * @package App\Libraries
 */
class Output
{
    /**
     * @param $data
     */
    public static function ok($data)
    {
        if (!isset($data['status']))
            $data['status'] = 'ok';
        self::output($data);
    }

    /**
     * @param $data
     */
    public static function error($data)
    {
        if (!isset($data['status']))
            $data['status'] = 'error';
        self::output($data);
    }

    /**
     * @param $data
     */
    public static function output($data, $exit = true) {
        if (is_string($data)) {
            Services::response()->setContentType('text/html');
            Services::response()->setBody($data);
            Services::response()->send();
        } elseif (is_array($data)) {
            Services::response()->setContentType('application/json');
            Services::response()->setJSON($data);
            Services::response()->send();
        }
        if($exit) exit();
    }
}
