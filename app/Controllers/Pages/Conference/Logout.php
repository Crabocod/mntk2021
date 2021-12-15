<?php namespace App\Controllers\Pages\Conference;

use App\Controllers\Pages\BaseController;
use App\Entities\Users\UserSession;

class Logout extends BaseController
{
    public function index()
    {
        $session = session();
        $session->destroy();
        header('Location: /auth');
        exit();
    }
}