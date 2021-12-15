<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Libraries\Output;

class NewsAbout extends BaseController
{
    public function index($id)
    {
        $newsModel = new \App\Models\News();
        $newsModel->select('news.*');
        $newsModel->select('f.title as file_title');
        $newsModel->join('files f', 'f.id = news.photo_file_id', 'left');
        $newsModel->where('news.deleted_at IS NULL');
        $news = $newsModel->where('news.id', $id)->first();


        if(empty($news))
            Output::output(view('errors/html/error_404'));

        $news->date = date('Y-m-d', strtotime($news->date));
        $data['news_info'] = $news->toRawArray();

        echo view('pages/admin/news-about', $data);
    }
}