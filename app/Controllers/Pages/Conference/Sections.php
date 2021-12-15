<?php namespace App\Controllers\Pages\Conference;

use App\Entities\SectionFeedbacks\SectionFeedbackValid;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\SectionFeedbacks;
use App\Models\SectionImages;
use App\Models\SectionJury;
use App\Models\Users;

class Sections extends BaseController
{
    public function index($section_id)
    {
        $sectionsModel = new \App\Models\Sections();
        $sectionsFeedbackModel = new \App\Models\SectionFeedbacks();
        $sectionsJuryModel = new SectionJury();
        $sectionImagesModel = new SectionImages();
        $usersModel = new Users();

        $section = $sectionsModel->asArray()->where('id', $section_id)->first();
        if(empty($section))
            Output::output(view('errors/html/error_404'));

        if(!empty($section['protection_date']))
            $section['protection_date'] = DateTime::byUserTimeZone(UserSession::getUser(), $section['protection_date']);

        $formatter = new \IntlDateFormatter('ru_RU', \IntlDateFormatter::FULL, \IntlDateFormatter::FULL);
        $formatter->setPattern('d MMMM');
        $section['time'] = date('H:i', strtotime($section['protection_date']));
        $section['protection_date'] = $formatter->format(new \DateTime($section['protection_date']));

        $section['jury'] = $sectionsJuryModel->asArray()->where('section_id', $section_id)->find();
        $section['members'] = $usersModel->asArray()->where('section_id', $section_id)->find();

        $sectionImagesModel->select('section_images.*');
        $sectionImagesModel->select('img_file.link as img_file_link');
        $sectionImagesModel->select('img_min_file.link as img_min_file_link');
        $sectionImagesModel->join('files img_file', 'img_file.id=section_images.img_file_id', 'left');
        $sectionImagesModel->join('files img_min_file', 'img_min_file.id=section_images.img_min_file_id', 'left');
        $section['gallery'] = $sectionImagesModel->asArray()->where('section_images.section_id', $section_id)->find();

        $sectionsFeedbacks = $sectionsFeedbackModel->where('section_id', $section_id)->asArray()->findAll();
        $section['feedbacks'] = $sectionsFeedbacks;

        echo view('pages/conference/sections', $section);
    }

    public function addFeedback($event_id)
    {
        try {
            $userSession = UserSession::getUser();
            $sectionFeedbacksModel = new SectionFeedbacks();

            $post = $this->request->getPost();
            SectionFeedbackValid::add($post);

            $sectionFeedbacksModel->insert([
                'user_id' => $userSession->id,
                'section_id' => $event_id,
                'text' => $post['text'],
                'grade' => $post['grade'],
            ]);

            Output::ok(['message' => SuccessMessages::get(1002)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function getFeedback($section_id)
    {
        $sectionsFeedbackModel = new \App\Models\SectionFeedbacks();
        $sectionsFeedbacks = $sectionsFeedbackModel->where('section_id', $section_id)->asArray()->findAll();

        $html = '';
        if(!empty($sectionsFeedbacks)){
            $html .= '<div class="new-reviews_blocks" id="feedback_rows">';
            foreach ($sectionsFeedbacks as $feedback){
                $html .= view('templates/conference/all/feedback_row', ['feedback' => $feedback]);
            }
            $html .= '</div>';
        }

        Output::ok(['html' => $html]);
    }
}