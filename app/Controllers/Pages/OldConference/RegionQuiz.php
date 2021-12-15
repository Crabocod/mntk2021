<?php namespace App\Controllers\Pages\OldConference;

use App\Controllers\Pages\BaseController;
use App\Entities\RegionQuizQuestions\RegionQuizQuestionValid;
use App\Entities\RegionQuizQuestions\RegionQuizQuestionView;
use App\Entities\Users\UserSession;
use App\Models\RegionQuizAnswers;
use App\Models\RegionQuizQuestions;
use App\Libraries\Output;

class RegionQuiz extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $regionQuizModel = new RegionQuizQuestions();

        $conference = $confModel->where('url_segment', $url_segment)->first();

        $user = UserSession::getUser();
        $data['user_surname'] = $user->surname;
        $data['user_name'] = $user->name;

        $regionQuizModel->select('region_quiz_questions.*');
        $regionQuizModel->select('rqa.text as answer');
        $regionQuizModel->join('region_quiz_answers rqa', '(rqa.region_quiz_question_id=region_quiz_questions.id and rqa.user_id='.$user->id.')', 'left');
        $regionQuizModel->where('conference_id', $conference->id);
        $regionQuizModel->where('visibility', 1);
        $regionQuizModel->orderBy('number', 'asc');
        $questions = $regionQuizModel->find();

        $data['conferences'] = $conference;
        $data['questions'] = RegionQuizQuestionView::getQuestionCards($questions);
        echo view('pages/conference/region_quiz', $data);
    }

    public function saveAnswer($url_segment)
    {
        try {
            $regionQuizAnswersModel = new RegionQuizAnswers();

            // Валидация
            $post = $this->request->getPost();
            RegionQuizQuestionValid::add($post);

            $user = UserSession::getUser();

            // Проверим существует ли такой ответ
            $regionQuizAnswersModel->where('region_quiz_question_id', $post['region_quiz_question_id']);
            $regionQuizAnswersModel->where('user_id', $user->id);
            $answer = $regionQuizAnswersModel->first();
            if(!empty($answer))
                $post['id'] = $answer->id;

            // Добавление
            $post['user_id'] = $user->id;
            $regionQuizAnswersModel->save($post);

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}