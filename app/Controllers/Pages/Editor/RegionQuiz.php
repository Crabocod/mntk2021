<?php namespace App\Controllers\Pages\Editor;

use App\Entities\Conferences\Conference;
use App\Entities\Conferences\ConferenceValid;
use App\Entities\RegionQuizAnswers\RegionQuizAnswerView;
use App\Entities\RegionQuizQuestions\RegionQuizQuestion;
use App\Entities\RegionQuizQuestions\RegionQuizQuestionValid;
use App\Entities\RegionQuizQuestions\RegionQuizQuestionView;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Conferences;
use App\Models\RegionQuizAnswers;
use App\Models\RegionQuizQuestions;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class RegionQuiz extends BaseController
{
    public function index($conference_id)
    {
        $quizQuestions = new RegionQuizQuestions();
        $quizAnswers = new RegionQuizAnswers();

        // Вывод всех вопросов
        $quizQuestions->orderBy('number', 'asc');
        $questions = $quizQuestions->where('conference_id', $this->conference->id)->find();

        // Вывод всех овтетов
        $quizAnswers->select('region_quiz_answers.*');
        $quizAnswers->select('u.id as user_id');
        $quizAnswers->select('u.name as user_name');
        $quizAnswers->select('u.surname as user_surname');
        $quizAnswers->select('u.email as user_email');
        $quizAnswers->select('rqq.text as text_question');
        $quizAnswers->select('rqq.number as question_number');
        $quizAnswers->join('users u', 'u.id=region_quiz_answers.user_id', 'left');
        $quizAnswers->join('region_quiz_questions rqq', 'rqq.id=region_quiz_answers.region_quiz_question_id', 'left');
        $quizAnswers->where('rqq.conference_id', $this->conference->id);
        $quizAnswers->orderBy('question_number', 'asc');
        $answers = $quizAnswers->find();

        // Обработка ответов
        $result = array();
        foreach ($answers as $answer) {
            if (empty($result[$answer->user_id])) {
                $result[$answer->user_id] = [
                    'user_name' => $answer->user_name,
                    'user_surname' => $answer->user_surname,
                    'user_email' => $answer->user_email,
                ];
            }
            $result[$answer->user_id]['answers'][] = [
                'text_answer' => $answer->text,
                'text_question' => $answer->text_question
            ];
        }
        $answers = $result;

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['questions_table_rows'] = RegionQuizQuestionView::getEditorTableRows($questions);
        $data['answers_table_rows'] = RegionQuizAnswerView::getEditorTableRows($answers);
        echo view('pages/editor/region-quiz', $data);
    }

    public function saveMain($conference_id)
    {
        try {
            $conferenceModel = new Conferences();
            $conference = new Conference();

            // Валидация
            $post = $this->request->getPost();
            ConferenceValid::saveRegionQuiz($post);

            // Сохранение
            $conferenceModel->update($conference_id, $post);

            Output::ok([
                'message' => SuccessMessages::get(308)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function save($conference_id)
    {
        try {
            $quizQuestions = new RegionQuizQuestions();
            $regionQuestion = new RegionQuizQuestion();

            $image = $this->request->getFile('img');
            $audio = $this->request->getFile('audio');

            // Валидация
            $post = $this->request->getPost();
            RegionQuizQuestionValid::save($post, $this->request);

            // Сохранение
            if(!empty($post['id']) and !empty($post['deleted_img']))
                $regionQuestion->img = '';
            if(($regionQuestion->saveImage($image) === false and empty($post['id'])))
                $regionQuestion->img = '';
            if(!empty($post['id']) and !empty($post['deleted_audio'])) {
                $regionQuestion->audio = '';
                $regionQuestion->audio_title = '';
            }
            if(($regionQuestion->saveAudio($audio) === false and empty($post['id']))) {
                $regionQuestion->audio = '';
                $regionQuestion->audio_title = '';
            }
            $regionQuestion->fill($post);
            $regionQuestion->conference_id = $this->conference->id;
            $quizQuestions->save($regionQuestion);
            if (!isset($post['id']))
                $regionQuestion->id = $quizQuestions->getInsertID();
            $regionQuestion->visibility = 1;

            Output::ok([
                'html' => RegionQuizQuestionView::getEditorTableRow($regionQuestion->toArray()),
                'message' => SuccessMessages::get(1600)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function publication($conference_id)
    {
        try {
            $quizQuestionsModel = new RegionQuizQuestions();
            $regionQuizQuestion = new RegionQuizQuestion();

            // Валидация
            $post = $this->request->getPost();
            RegionQuizQuestionValid::publication($post);

            // Сохранение
            $regionQuizQuestion->id = $post['id'];
            $regionQuizQuestion->visibility = $post['visibility'];
            $quizQuestionsModel->save($regionQuizQuestion);

            Output::ok([
                'message' => SuccessMessages::get(1600)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function delete($conference_id)
    {
        try {
            $quizModel = new RegionQuizQuestions();
            $answersModel = new RegionQuizAnswers();

            // Валидация
            $post = $this->request->getPost();
            $post['conference_id'] = $conference_id;
            RegionQuizQuestionValid::delete($post);

            // У вопроса не должно быть ответов
            $answersModel->where('region_quiz_question_id', $post['id']);
            if(!empty($answersModel->first()))
                throw new \Exception(ErrorMessages::get(1600));

            // Удаление
            $quizModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(1601)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function getAnswersExcel()
    {
        try {
            // Вывод всех овтетов
            $quizAnswers = new RegionQuizAnswers();
            $quizAnswers->select('region_quiz_answers.*');
            $quizAnswers->select('u.id as user_id');
            $quizAnswers->select('u.name as user_name');
            $quizAnswers->select('u.surname as user_surname');
            $quizAnswers->select('u.email as user_email');
            $quizAnswers->select('rqq.text as text_question');
            $quizAnswers->select('rqq.number as question_number');
            $quizAnswers->join('users u', 'u.id=region_quiz_answers.user_id', 'left');
            $quizAnswers->join('region_quiz_questions rqq', 'rqq.id=region_quiz_answers.region_quiz_question_id', 'left');
            $quizAnswers->where('rqq.conference_id', $this->conference->id);
            $quizAnswers->orderBy('question_number', 'asc');
            $answers = $quizAnswers->find();

            // Обработка ответов
            $result = array();
            foreach ($answers as $answer) {
                if (empty($result[$answer->user_id])) {
                    $result[$answer->user_id] = [
                        'user_name' => $answer->user_name,
                        'user_surname' => $answer->user_surname,
                        'user_email' => $answer->user_email,
                    ];
                }
                $result[$answer->user_id]['answers'][] = [
                    'text_answer' => $answer->text,
                    'text_question' => $answer->text_question
                ];
            }
            $answers = $result;

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Ответы пользователей');
            $sheet->setCellValue("A1", "Фамилия");
            $sheet->setCellValue("B1", "Имя");
            $sheet->setCellValue("C1", "Почта");
            $sheet->setCellValue("D1", "Вопросы");
            $sheet->setCellValue("E1", "Ответы");

            # Ширина столбцов
            $sheet->getColumnDimension("A")->setWidth(25);
            $sheet->getColumnDimension("B")->setWidth(25);
            $sheet->getColumnDimension("C")->setWidth(25);
            $sheet->getColumnDimension("D")->setWidth(50);
            $sheet->getColumnDimension("E")->setWidth(50);

            # Жирность
            $sheet->getStyle("A1")->getFont()->setBold(true);
            $sheet->getStyle("B1")->getFont()->setBold(true);
            $sheet->getStyle("C1")->getFont()->setBold(true);
            $sheet->getStyle("D1")->getFont()->setBold(true);
            $sheet->getStyle("E1")->getFont()->setBold(true);

            if (!empty($answers)) {
                $i = 0;
                foreach ($answers as $answer) {
                    // Запись данных
                    $sheet->setCellValue("A" . ($i + 2), $answer['user_surname']);
                    $sheet->setCellValue("B" . ($i + 2), $answer['user_name']);
                    $sheet->setCellValue("C" . ($i + 2), $answer['user_email']);

                    // Переносы строк и автовысота
                    $sheet->getStyle("A" . ($i + 2))->getAlignment()->setWrapText(true);
                    $sheet->getStyle("B" . ($i + 2))->getAlignment()->setWrapText(true);
                    $sheet->getStyle("C" . ($i + 2))->getAlignment()->setWrapText(true);

                    for ($j = 0; $j < count($answer['answers']); $j++) {
                        if($j != 0)
                            $i++;

                        // Запись данных
                        $sheet->setCellValue("D" . ($i + 2), $answer['answers'][$j]['text_question']);
                        $sheet->setCellValue("E" . ($i + 2), $answer['answers'][$j]['text_answer']);

                        // Переносы строк и автовысота
                        $sheet->getStyle("D" . ($i + 2))->getAlignment()->setWrapText(true);
                        $sheet->getStyle("E" . ($i + 2))->getAlignment()->setWrapText(true);
                    }
                    $i++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            ob_start();
            $writer->save('php://output');
            $xlsData = ob_get_contents();
            ob_end_clean();
            echo json_encode('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'.base64_encode($xlsData));

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}
