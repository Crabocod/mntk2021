<?php namespace App\Controllers\Pages;

class Index extends BaseController
{
    public function index()
    {
        echo view('pages/index');
    }
}