<?php


namespace App\Controllers\Pages\Conference;


class News extends BaseController
{
    public function about($id)
    {
        $newsModel = new \App\Models\News();

        $newsModel->select('news.*');
        $newsModel->select('f.link as file_link');
        $newsModel->select('f_min.link as file_min_link');
        $newsModel->join('files f', 'f.id = news.photo_file_id', 'left');
        $newsModel->join('files f_min', 'f.id = news.photo_min_file_id', 'left');
        $newsModel->where('news.id', $id);
        $newsModel->where('news.deleted_at IS NULL');
        $news = $newsModel->first();

        echo view('pages/conference/timeline-about', ['news' => $news->toRawArray()]);
    }

    public function index()
    {
        $newsModel = new \App\Models\News();

        $newsModel->select('news.*');
        $newsModel->select('f.link as file_link');
        $newsModel->select('f_min.link as file_min_link');
        $newsModel->join('files f', 'f.id = news.photo_file_id', 'left');
        $newsModel->join('files f_min', 'f.id = news.photo_min_file_id', 'left');
        $newsModel->where('news.deleted_at IS NULL');
        $news = $newsModel->asArray()->findAll();

        echo view('pages/conference/timeline', ['news' => $news]);
    }
}