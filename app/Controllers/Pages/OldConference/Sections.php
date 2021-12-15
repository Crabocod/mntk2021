<?php namespace App\Controllers\Pages\OldConference;

use App\Entities\SectionFeedbacks\SectionFeedback;
use App\Entities\SectionFeedbacks\SectionFeedbackValid;
use App\Entities\SectionFeedbacks\SectionFeedbackView;
use App\Entities\SectionImages\SectionImageView;
use App\Entities\SectionJury\SectionJuryView;
use App\Entities\Sections\SectionView;
use App\Entities\Users\UserSession;
use App\Libraries\Output;
use App\Models\SectionFeedbacks;
use App\Models\SectionImages;
use App\Models\SectionJury;
use App\Libraries\DateTime;

class Sections extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $sectionsModel = new \App\Models\Sections();

        $sectionsModel->where('conference_id', $this->conference->id);
        $sectionsModel->where('is_publication', 1);
        $sectionsModel->orderBy('protection_date', 'asc');
        $sections = $sectionsModel->find();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $this->conference;
        $data['sections'] = SectionView::getSectionCards($sections, $url_segment);
        echo view('pages/conference/sections', $data);
    }

    public function about($url_segment, $section_id)
    {
        $confModel = new \App\Models\Conferences();
        $sectionsModel = new \App\Models\Sections();
        $sectionFeedbacksModel = new SectionFeedbacks();
        $sectionJuryModel = new SectionJury();
        $sectionImagesModel = new SectionImages();

        $sectionsModel->where('conference_id', $this->conference->id);
        $sectionsModel->where('is_publication', 1);
        $section = $sectionsModel->find($section_id);
        if(empty($section))
            Output::output(view('errors/html/error_404'));

        $sectionFeedbacksModel->select('section_feedbacks.*');
        $sectionFeedbacksModel->select('u.name as user_name');
        $sectionFeedbacksModel->select('u.surname as user_surname');
        $sectionFeedbacksModel->join('users u', 'u.id=section_feedbacks.user_id', 'left');
        $sectionFeedbacksModel->where('section_id', $section->id);
        $feedbacks = $sectionFeedbacksModel->find();

        $jury =$sectionJuryModel->where('section_id', $section->id)->find();

        $sectionImagesModel->orderBy('sort_num', 'asc');
        $images = $sectionImagesModel->where('section_id', $section->id)->find();

        $user = UserSession::getUser();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $this->conference;
        $data['section'] = $section->toRawArray();
        $data['section']['protection_date'] = DateTime::formatRu($data['section']['protection_date'], 'd MMMM в HH:mm', $user);
        $data['section']['discussion_date'] = DateTime::formatRu($data['section']['discussion_date'], 'd MMMM в HH:mm', $user);
        $data['section_feedbacks'] = SectionFeedbackView::getFeedbackCards($feedbacks, $url_segment);
        $data['section_jury'] = SectionJuryView::getSectionJuryCards($jury);
        $data['section_images'] = SectionImageView::getSectionImages($images);
        echo view('pages/conference/section_about', $data);
    }

    public function addFeedback($url_segment, $section_id)
    {
        try {
            $sectionFeedbacksModel = new SectionFeedbacks();

            $user = UserSession::getUser();

            // Валидация
            $post = $this->request->getPost();
            SectionFeedbackValid::add($post);

            // Добавление отзыва
            $sectionFeedback = new SectionFeedback();
            $sectionFeedback->section_id = $section_id;
            $sectionFeedback->user_id = $user->id;
            $sectionFeedback->text = $post['text'];
            $sectionFeedbacksModel->save($sectionFeedback);

            // Вывод html
            $sectionFeedback->user_name = $user->name;
            $sectionFeedback->user_surname = $user->surname;
            $sectionFeedback->created_at = date('Y-m-d H:i:s');
            $html = SectionFeedbackView::getFeedbackCard($sectionFeedback->toRawArray(), $url_segment);

            Output::ok(['html' => $html]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}