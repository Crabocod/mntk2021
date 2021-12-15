<?php namespace App\Controllers\Pages\OldAdmin;


class Logout extends BaseController
{
    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/admin/auth');
    }    
}