<?php namespace App\Controllers\Pages\Editor;

use App\Entities\Conferences\ConferenceValid;
use App\Entities\ManagementFeedbacks\ManagementFeedbackValid;
use App\Entities\ManagementFeedbacks\ManagementFeedbackView;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Conferences;
use App\Models\ManagementFeedbacks;

class Management extends BaseController
{
    public function index($conference_id)
    {
        $managementFeedbacksModel = new ManagementFeedbacks();

        $feedbacks = $managementFeedbacksModel->show_all(['conference_id'=>$this->conference->id, 'with_user' => true]);

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['feedbacks'] = ManagementFeedbackView::getEditorTableRows($feedbacks);

        echo view('pages/editor/management', $data);
    }

    public function save($conference_id)
    {
        try {
            $conferenceModel = new Conferences();

            $file = $this->request->getFile('file');

            // Валидация
            $post = $this->request->getPost();
            ConferenceValid::saveManagementItems($post);

            // Сохранение
            if(@$post['deleted_file'] == 1) {
                $this->conference->management_file_url = '';
                $this->conference->management_file_name = '';
            }
            $this->conference->saveManagementFile($file);
            $this->conference->management_title = $post['management_title'];
            $this->conference->management_top_text = $post['management_top_text'];
            $this->conference->management_text = $post['management_text'];
            if($this->conference->hasChanged())
                $conferenceModel->save($this->conference);

            Output::ok([
                'message' => SuccessMessages::get(300)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteFeedback($conference_id)
    {
        try {
            $managementFeedbacksModel = new ManagementFeedbacks();

            // Валидация
            $post = $this->request->getPost();
            ManagementFeedbackValid::delete($post);

            // Удаление
            $managementFeedbacksModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(2000)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}
