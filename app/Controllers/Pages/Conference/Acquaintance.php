<?php namespace App\Controllers\Pages\Conference;

use App\Entities\Events\EventValid;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\AcquaintanceFeedback;
use App\Models\AcquaintanceModel;

class Acquaintance extends BaseController
{
    public function index()
    {
        $userSession = UserSession::getUser();
        $acquaintanceModel = new AcquaintanceModel();
        $acquaintanceFeedbackModel = new AcquaintanceFeedback();

        $acquaintance = $acquaintanceModel->asArray()->first();
        if(empty($acquaintance))
            Output::output(view('errors/html/error_404'));

        $acquaintanceFeedbackModel->select('acquaintance_feedback.*');
        $acquaintanceFeedbackModel->select('u.full_name as user_full_name');
        $acquaintanceFeedbackModel->join('users u', 'u.id=acquaintance_feedback.user_id', 'left');
        $acquaintance['feedbacks'] = $acquaintanceFeedbackModel->find();

        echo view('pages/conference/acquaintance', $acquaintance);
    }

    public function addFeedback()
    {
        try {
            $userSession = UserSession::getUser();
            $acquaintanceFeedbackModel = new AcquaintanceFeedback();

            $post = $this->request->getPost();
            EventValid::addFeedback($post);

            $post['text'] = $acquaintanceFeedbackModel->db->escape($post['text']);

            $created_at = DateTime::fromUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s'));
            $query = "INSERT INTO `acquaintance_feedback` SET `user_id`='".$userSession->id."', `text`=".$post['text'].", `created_at`='".$created_at."'";
            if(!empty($post['grade'])) {
                $grade = decbin(intval($post['grade']));
                $max_grade = decbin(2);
                if($grade > $max_grade)
                    $grade = $max_grade;
                $query .= ", `grade` = b'" . $grade . "'";
            }
            $result = $acquaintanceFeedbackModel->db->query($query);

            $id = 0;
            if(!empty($result->connID->insert_id))
                $id = $result->connID->insert_id;

            $acquaintanceFeedbackModel->select('acquaintance_feedback.*');
            $acquaintanceFeedbackModel->select('u.full_name as user_full_name');
            $acquaintanceFeedbackModel->join('users u', 'u.id=acquaintance_feedback.user_id', 'left');
            $feedback = $acquaintanceFeedbackModel->where('acquaintance_feedback.id', $id)->first();

            $feedback = view('templates/conference/all/feedback_row', ['feedback' => $feedback]);

            Output::ok([
                'message' => SuccessMessages::get(2100),
                'html' => $feedback
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}