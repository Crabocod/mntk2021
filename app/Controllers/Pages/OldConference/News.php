<?php namespace App\Controllers\Pages\OldConference;

use App\Entities\News\NewsView;
use App\Libraries\Output;

class News extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $newsModel =new \App\Models\News();

        $newsModel->where('conference_id', $this->conference->id);
        $newsModel->where('is_publication', 1);
        $newsModel->orderBy('id', 'desc');
        $news = $newsModel->find();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $this->conference;
        $data['news'] = NewsView::getNewsCards($news, $url_segment);
        echo view('pages/conference/news', $data);
    }

    public function about($url_segment, $news_id)
    {
        $confModel = new \App\Models\Conferences();
        $newsModel =new \App\Models\News();

        $newsModel->where('conference_id', $this->conference->id);
        $newsModel->where('is_publication', 1);
        $newsModel->where('id', $news_id);
        $news = $newsModel->first();
        if(empty($news))
            Output::output(view('errors/html/error_404'));

        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern('d MMMM');
        $news->date = $formatter->format(new \DateTime($news->date));

        $data = [];
        $data['conferences'] = $this->conference;
        $data['news'] = $news;
        $data['url_segments'] = $this->request->uri->getSegments();
        echo view('pages/conference/news_about', $data);
    }
}