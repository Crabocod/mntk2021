<?php namespace App\Controllers\Pages\Editor;

use App\Entities\News\NewsView;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Entities\News\NewsValid;
use App\Models\News as NewsModel;
use App\Entities\News\News as NewsEntity;

class News extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();

        $res = $this->request->uri->getSegments();
        $conference_id = $res[1];
        if (isset($res[3]) && is_numeric($res[3]))
            $news_id = $res[3];

        if (isset($conference_id) && isset($news_id)){
            $newsModel = new \App\Models\News();
            $event = $newsModel->where('conference_id', $conference_id)->where('id', $news_id)->first();
            if (empty($event)){
                if($this->request->isAJAX())
                    Output::error(['message' => ErrorMessages::get(300)]);
                else
                    Output::output(view('errors/html/error_404'));
            }
        }
    }

    public function index($conference_id)
    {
        $newsModel = new NewsModel();

        $newsModel->where('conference_id', $conference_id);
        $newsModel->orderBy('id', 'desc');
        $news = $newsModel->find();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['news'] = NewsView::getEditorTableRows($news, $conference_id);
        echo view('pages/editor/news', $data);
    }

    public function about($conference_id, $news_id)
    {
        $newsModel = new NewsModel();

        $news = $newsModel->find($news_id);
        if (empty($news))
            Output::output(view('errors/html/error_404'), true);

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['news'] = $news->toArray();
        echo view('pages/editor/news_about', $data);
    }

    public function save()
    {
        try {
            $newsModel = new NewsModel();
            $news = new NewsEntity();

            // Валидация
            $post = $this->request->getPost();
            NewsValid::add($post);

            $post['date'] = date('Y-m-d H:i:s', strtotime($post['date']));

            // Сохранение
            $news->fill($post);
            $news->conference_id = $this->conference->id;
            $newsModel->save($news);
            if (!isset($post['id']))
                $news->id = $newsModel->getInsertID();
            $news->is_publication = 1;

            Output::ok([
                'url' => '/editor/'.$this->conference->id.'/news/'.$news->id,
                'html' => NewsView::getEditorTableRow($news->toArray(), $this->conference->id),
                'message' => SuccessMessages::get(900)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function delete($conference_id, $news_id)
    {
        try {
            $newsModel = new \App\Models\News();

            // Удаление
            $newsModel->delete($news_id);

            Output::ok([
                'url' => '/editor/' . $conference_id . '/news',
                'message' => SuccessMessages::get(901)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function publication($conference_id)
    {
        try {
            $newsModel = new \App\Models\News();
            $news = new \App\Entities\News\News();

            // Валидация
            $post = $this->request->getPost();
            NewsValid::publication($post);

            // Сохранение
            $news->fill($post);
            $newsModel->save($news);

            Output::ok([
                'message' => SuccessMessages::get(900)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}