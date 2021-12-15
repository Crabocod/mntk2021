<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Files\File;
use App\Entities\News\NewsValid;
use App\Entities\News\NewsView;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Files;

class News extends BaseController
{
    public function index()
    {
        echo view('pages/admin/news');
    }

    public function showNews()
    {
        try {
            $newsModel = new \App\Models\News();
            $newsModel->select('news.*');
            $newsModel->select('f.link as file_link');
            $newsModel->select('f_min.link as file_min_link');
            $newsModel->join('files f', 'f.id = news.photo_file_id', 'left');
            $newsModel->join('files f_min', 'f_min.id = news.photo_min_file_id', 'left');
            $newsModel->where('news.deleted_at IS NULL');
            $news = $newsModel->findAll();


            Output::ok([
                'html' => NewsView::getNewsCards($news)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteNews()
    {
        try {
            $newsModel = new \App\Models\News();

            $post = $this->request->getPost();
            NewsValid::delete($post);

            $newsModel->delete($post['id']);

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveNews()
    {
        try {
            $newsModel = new \App\Models\News();
            $news = new \App\Entities\News\News();

            $file = new File();
            $filesModel = new Files();

            $post = $this->request->getPost();
            $fileImg = $this->request->getFile('img_link');
            NewsValid::save($post, $this->request);

            if (!empty($post['id'])) {
                $news->id = $post['id'];
                $news->is_publication = (!empty($post['is_publication']))?'1':'0';
            }

            $news->title = $post['title'];
            $news->date = date('Y-m-d H:i:s',strtotime($post['date']));
            $news->short_text = $post['text'];
            if (!empty($post['full_text']))
                $news->full_text = $post['full_text'];
            $news->youtube_iframe = $post['iframe'];

            if (!empty($fileImg) && ($fileImg instanceof \CodeIgniter\Files\File) && $fileImg->isFile()) {
                $file->save($fileImg);
                $filesModel->save($file);
                $news->photo_file_id = $filesModel->getInsertID();

                // Добавление миниатюры изображения
                $imgFile = new File();
                $result = $imgFile->handleImage($file->link);

                if($result === true && !empty($imgFile->image_min_link)) {
                    $filesModel->insert([
                        'ext_id' => $file->ext_id,
                        'title' => $file->title,
                        'link' => $imgFile->image_min_link,
                        'size' => $file->size
                    ]);
                    $news->photo_min_file_id = $filesModel->getInsertID();
                }
            }

            $newsModel->save($news);

            Output::ok([
                'message' => SuccessMessages::get(900)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}