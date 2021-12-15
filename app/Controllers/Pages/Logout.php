<?php namespace App\Controllers\Pages;

class Logout extends BaseController {
    public function index()
    {
        session()->remove('user');
        return redirect()->to('/');
    }
}