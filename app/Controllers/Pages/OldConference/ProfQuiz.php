<?php namespace App\Controllers\Pages\OldConference;

use App\Controllers\Pages\BaseController;
use App\Entities\ProfQuizAnswers\ProfQuizAnswer;
use App\Entities\ProfQuizAnswers\ProfQuizAnswerValid;
use App\Entities\ProfQuizQuestions\ProfQuizQuestionView;
use App\Entities\Users\UserSession;
use App\Libraries\Output;
use App\Models\ProfessionalQuizAnswers;
use App\Models\ProfessionalQuizQuestions;

class ProfQuiz extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $profQuizModel = new ProfessionalQuizQuestions();

        $conference = $confModel->where('url_segment', $url_segment)->first();

        $user = UserSession::getUser();
        $data['user_surname'] = $user->surname;
        $data['user_name'] = $user->name;

        $profQuizModel->select('professional_quiz_questions.*');
        $profQuizModel->select('pqa.text as answer');
        $profQuizModel->select('pqa.file as answer_file');
        $profQuizModel->select('pqa.file_name as answer_file_name');
        $profQuizModel->join('professional_quiz_answers pqa', '(pqa.professional_quiz_question_id=professional_quiz_questions.id and pqa.user_id='.$user->id.')', 'left');
        $profQuizModel->where('conference_id', $conference->id);
        $profQuizModel->where('visibility', 1);
        $profQuizModel->orderBy('number', 'asc');
        $questions = $profQuizModel->find();

        $data['conferences'] = $conference;
        $data['questions'] = ProfQuizQuestionView::getQuestionCards($questions);
        echo view('pages/conference/prof_quiz', $data);
    }

    public function saveAnswer($url_segment)
    {
        try {
            $profQuizAnswersModel = new ProfessionalQuizAnswers();

            $file = $this->request->getFile('file');

            // Валидация
            $post = $this->request->getPost();
            ProfQuizAnswerValid::add($post, $this->request);

            $user = UserSession::getUser();

            // Проверим существует ли такой ответ
            $profQuizAnswersModel->where('professional_quiz_question_id', $post['professional_quiz_question_id']);
            $profQuizAnswersModel->where('user_id', $user->id);
            $profQuizAnswer = $profQuizAnswersModel->first();
            if(empty($profQuizAnswer))
                $profQuizAnswer = new ProfQuizAnswer();

            // Добавление
            if(!empty($post['deleted_file']))
                $profQuizAnswer->file = $profQuizAnswer->file_name = '';
            $profQuizAnswer->saveFile($file);
            $profQuizAnswer->user_id = $user->id;
            $profQuizAnswer->professional_quiz_question_id = $post['professional_quiz_question_id'];
            $profQuizAnswer->text = $post['text'];
            if($profQuizAnswer->hasChanged())
                $profQuizAnswersModel->save($profQuizAnswer);

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}