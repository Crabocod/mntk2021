<?php namespace App\Controllers\Pages\Editor;

use App\Controllers\Pages\BaseController;

class Logout extends BaseController
{
    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/editor');
    }
}