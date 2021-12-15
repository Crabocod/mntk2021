<?php namespace App\Controllers\Pages\OldConference;

use App\Entities\ManagementFeedbacks\ManagementFeedback;
use App\Entities\ManagementFeedbacks\ManagementFeedbackValid;
use App\Entities\ManagementFeedbacks\ManagementFeedbackView;
use App\Entities\Users\UserSession;
use App\Libraries\Output;
use App\Models\ManagementFeedbacks;

class Management extends BaseController
{
    public function index()
    {
        $managementFeedbacksModel = new ManagementFeedbacks();

        $managementFeedbacks = $managementFeedbacksModel->show_all(['with_user' => true, 'conference_id' => $this->conference->id]);

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $this->conference;
        $data['management_feedbacks'] = ManagementFeedbackView::getConferenceCards($managementFeedbacks);

        echo view('pages/conference/management', $data);
    }

    public function addFeedback($url_segment)
    {
        try {
            $managementFeedbacksModel = new ManagementFeedbacks();

            $user = UserSession::getUser();

            // Валидация
            $post = $this->request->getPost();
            ManagementFeedbackValid::add($post);

            // Добавление отзыва
            $managementFeedback = new ManagementFeedback();
            $managementFeedback->conference_id = $this->conference->id;
            $managementFeedback->user_id = $user->id;
            $managementFeedback->text = $post['text'];
            $managementFeedbacksModel->save($managementFeedback);

            // Вывод html
            $managementFeedback->user_name = $user->name;
            $managementFeedback->user_surname = $user->surname;
            $managementFeedback->created_at = date('Y-m-d H:i:s');
            $html = ManagementFeedbackView::getConferenceCard($managementFeedback->toRawArray());

            Output::ok(['html' => $html]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}