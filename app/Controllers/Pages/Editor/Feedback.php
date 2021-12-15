<?php namespace App\Controllers\Pages\Editor;

use App\Entities\Conferences\Conference;
use App\Entities\Conferences\ConferenceValid;
use App\Entities\Conferences\ConferenceView;
use App\Entities\GoogleFormImgs\GoogleFormImg;
use App\Entities\GoogleFormImgs\GoogleFormImgValid;
use App\Entities\GoogleFormImgs\GoogleFormImgView;
use App\Entities\Users\UserSession;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\GoogleFormImgs;

class Feedback extends BaseController
{
    public function index($conference_id)
    {
        $googleFormImgsModel = new GoogleFormImgs();

        $googleFormImgsModel->orderBy('sort_num', 'asc');
        $feedbackImages = $googleFormImgsModel->where('conference_id', $this->conference->id)->find();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['feedback_images'] = GoogleFormImgView::getEditorItems($feedbackImages);
        echo view('pages/editor/feedback', $data);
    }

    public function save($conference_id)
    {
        try {
            $conferencesModel = new \App\Models\Conferences();
            $conference = new Conference();

            // Валидация
            $post = $this->request->getPost();
            ConferenceValid::saveGfItems($post);

            // Сохранение
            $conference->fill($post);
            $conference->id = $this->conference->id;
            $conferencesModel->save($conference);

            Output::ok([
                'message' => SuccessMessages::get(304)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function addImage($conference_id)
    {
        try {
            $googleFormImgsModel = new GoogleFormImgs();
            $googleFormImg = new GoogleFormImg();

            $file = $this->request->getFile('img');

            // Валидация
            $post = $this->request->getPost();
            GoogleFormImgValid::save($post, $this->request);

            // Сохранение
            $googleFormImg->saveImage($file);
            $googleFormImg->conference_id = $this->conference->id;
            $googleFormImgsModel->save($googleFormImg);

            $googleFormImg->id = $googleFormImgsModel->getInsertID();

            Output::ok(['html' => GoogleFormImgView::getEditorItem($googleFormImg->toArray())]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteImage($conference_id)
    {
        try {
            $googleFormImgsModel = new GoogleFormImgs();

            // Валидация
            $post = $this->request->getPost();
            GoogleFormImgValid::delete($post);

            // Удаление
            $googleFormImgsModel->delete($post['id']);

            Output::ok(['message' => SuccessMessages::get(76)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sortImages($conference_id)
    {
        try {
            $googleFormImgsModel = new GoogleFormImgs();

            // Валидация
            $post = $this->request->getPost();
            GoogleFormImgValid::sort($post);

            // Добавление новых записей
            $updateData = [];
            foreach ($post['sort'] as $sort) {
                $updateData[] = [
                    'id' => $sort['google_form_img_id'],
                    'sort_num' => $sort['sort_num']
                ];
            }

            $googleFormImgsModel->updateBatch($updateData, 'id');

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}
