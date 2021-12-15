<?php namespace App\Controllers\Pages\OldConference;

use App\Controllers\Pages\BaseController;
use App\Entities\GoogleFormImgs\GoogleFormImgView;
use App\Entities\Users\UserSession;
use App\Models\GoogleFormImgs;

class Feedback extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $googleFormImgsModel = new GoogleFormImgs();

        $conference = $confModel->where('url_segment', $url_segment)->first();

        // Вывод картинок
        $googleFormImgsModel->orderBy('sort_num', 'asc');
        $imgs = $googleFormImgsModel->where('conference_id', $conference->id)->find();

        $user = UserSession::getUser();
        $data['user_surname'] = $user->surname;
        $data['user_name'] = $user->name;

        $data['conferences'] = $conference;
        $data['google_form_imgs'] = GoogleFormImgView::getFeedbackItems($imgs);
        echo view('pages/conference/feedback', $data);
    }
}