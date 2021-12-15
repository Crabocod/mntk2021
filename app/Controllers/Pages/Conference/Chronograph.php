<?php namespace App\Controllers\Pages\Conference;

use App\Entities\ChronographQuestionAnswers\ChronographQuestionAnswersValid;
use App\Entities\ChronographQuestions\ChronographQuestionsView;
use App\Entities\Users\UserSession;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;

class Chronograph extends BaseController
{
    public function addAnswer()
    {
        try{
            $userSession = UserSession::getUser();
            $chronographQuestionAnswersModel = new \App\Models\ChronographQuestionAnswers();
            $chronographQuestionAnswers = new \App\Entities\ChronographQuestionAnswers\ChronographQuestionAnswers();

            $post = $this->request->getPost();
            ChronographQuestionAnswersValid::add($post);
            $chronographQuestionAnswer = $chronographQuestionAnswersModel->where('chronograph_question_id', $post['id'])->first();
            if ($chronographQuestionAnswer != null)
                $chronographQuestionAnswersModel->delete($chronographQuestionAnswer->id);

            $chronographQuestionAnswers->chronograph_question_id = $post['id'];
            $chronographQuestionAnswers->text = $post['answer'];
            $chronographQuestionAnswers->user_id = $userSession->id;

            $chronographQuestionAnswersModel->save($chronographQuestionAnswers);

            Output::ok(['message' => SuccessMessages::get(2200)]);
        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function index()
    {
        $userSession = UserSession::getUser();
        $chronographModel = new \App\Models\Chronograph();
        $chronographQuestionsModel = new \App\Models\ChronographQuestions();

        $chronograph = $chronographModel->first();
        $chronographQuestionsModel->select('chronograph_questions.*');
        $chronographQuestionsModel->select('cqa.text as text_answer');
        $chronographQuestionsModel->join('chronograph_question_answers cqa', 'cqa.chronograph_question_id = chronograph_questions.id AND cqa.user_id = '.$userSession->id, 'left');
        $chronographQuestionsModel->where('chronograph_questions.show', '1');
        $chronographQuestionsModel->where('cqa.deleted_at IS NULL');
        $chronographQuestions = $chronographQuestionsModel->orderBy('chronograph_questions.number', 'ASC')->findAll();

        foreach ($chronographQuestions as $chronographQuestion) {
            $chronographQuestionsFilesModel = new \App\Models\ChronographQuestionFiles();
            $chronographQuestionsFilesModel->select('chronograph_question_files.*');
            $chronographQuestionsFilesModel->select('f.link as file_link');
            $chronographQuestionsFilesModel->select('f.title as file_title');
            $chronographQuestionsFilesModel->join('files f', 'f.id = chronograph_question_files.file_id', 'left');
            $chronographQuestionsFilesModel->where('chronograph_question_files.chronograph_question_id', $chronographQuestion->id);
            $chronographQuestion->files = $chronographQuestionsFilesModel->orderBy('chronograph_question_files.type_id', 'ASC')->findAll();
        }

        $data['title_text'] = $chronograph->text;
        $data['questions'] = ChronographQuestionsView::getQuestionsRows($chronographQuestions);


        echo view('pages/conference/chronograph', $data);
    }
}