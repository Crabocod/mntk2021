<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Chronograph\ChronographValid;
use App\Entities\ChronographQuestionAnswers\ChronographQuestionAnswers;
use App\Entities\ChronographQuestionAnswers\ChronographQuestionAnswersView;
use App\Entities\ChronographQuestions\ChronographQuestionsView;
use App\Entities\Files\File;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Files;

class Chronograph extends BaseController
{
    public function deleteQuestion()
    {
        try {
            $chronographQuestionModel = new \App\Models\ChronographQuestions();

            $post = $this->request->getPost();
            ChronographValid::deleteQuestion($post);

            $chronographQuestionModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(2203)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function showQuestion()
    {
        $chronographQuestionsModel = new \App\Models\ChronographQuestions();
        $chronographQuestions = $chronographQuestionsModel->findAll();

        foreach ($chronographQuestions as $chronographQuestion) {
            $chronographQuestionsFilesModel = new \App\Models\ChronographQuestionFiles();
            $chronographQuestionsFilesModel->select('chronograph_question_files.*');
            $chronographQuestionsFilesModel->select('f.link as file_link');
            $chronographQuestionsFilesModel->select('f.title as file_title');
            $chronographQuestionsFilesModel->join('files f', 'f.id = chronograph_question_files.file_id', 'left');
            $chronographQuestionsFilesModel->where('chronograph_question_files.chronograph_question_id', $chronographQuestion->id);
            $chronographQuestion->files = $chronographQuestionsFilesModel->findAll();
        }

        Output::ok([
            'html' => ChronographQuestionsView::getAdminQuestionsRows($chronographQuestions)
        ]);
    }

    public function saveQuestion()
    {

        try {
            $chronographQuestionModel = new \App\Models\ChronographQuestions();
            $chronographQuestionFilesModel = new \App\Models\ChronographQuestionFiles();
            $chronographQuestion = new \App\Entities\ChronographQuestions\ChronographQuestions();
            $file = new File();
            $filesModel = new Files();

            $image = $this->request->getFile('img_link');
            $audio = $this->request->getFile('audio_link');
            $fileLink = $this->request->getFile('file_link');


            // Валидация
            $post = $this->request->getPost();
            ChronographValid::saveQuestion($post, $this->request);

            // Сохранение
            $chronographQuestion->fill($post);
            if(empty($post['show']))
                $chronographQuestion->show = 0;
            $chronographQuestionModel->save($chronographQuestion);
            $chronographQuestionId = $chronographQuestionModel->getInsertID();

            if ($chronographQuestionId == '')
                $chronographQuestionId = $post['id'];

            if (!empty($post['delete-img']) && $post['delete-img'] == 1){
                $chronographQuestionFiles = $chronographQuestionFilesModel->where('type_id', '3')->where('chronograph_question_id', $chronographQuestionId)->first();
                $chronographQuestionFilesModel->delete($chronographQuestionFiles->id);
            }

            if (!empty($post['delete-audio']) && $post['delete-audio'] == 1){
                $chronographQuestionFiles = $chronographQuestionFilesModel->where('type_id', '1')->where('chronograph_question_id', $chronographQuestionId)->first();
                $chronographQuestionFilesModel->delete($chronographQuestionFiles->id);
            }

            if (!empty($post['delete-file']) && $post['delete-file'] == 1){
                $chronographQuestionFiles = $chronographQuestionFilesModel->where('type_id', '2')->where('chronograph_question_id', $chronographQuestionId)->first();
                $chronographQuestionFilesModel->delete($chronographQuestionFiles->id);
            }

            $chronographQuestionFiles = new \App\Entities\ChronographQuestionFiles\ChronographQuestionFile();
            if (!empty($image) && ($image instanceof \CodeIgniter\Files\File) && $image->isFile()) {
                $chronographQuestionFile = $chronographQuestionFilesModel->where('type_id', '3')->where('chronograph_question_id', $chronographQuestionId)->first();
                if (!empty($chronographQuestionFile))
                    $chronographQuestionFilesModel->delete($chronographQuestionFile->id);

                $file->save($image);
                $filesModel->save($file);
                $chronographQuestionFiles->file_id = $filesModel->getInsertID();
                $chronographQuestionFiles->type_id = 3;
                $chronographQuestionFiles->chronograph_question_id = $chronographQuestionId;
                $chronographQuestionFilesModel->save($chronographQuestionFiles);
            }
            if (!empty($audio) && ($audio instanceof \CodeIgniter\Files\File) && $audio->isFile()) {
                $chronographQuestionFile = $chronographQuestionFilesModel->where('type_id', '1')->where('chronograph_question_id', $chronographQuestionId)->first();
                if (!empty($chronographQuestionFile))
                    $chronographQuestionFilesModel->delete($chronographQuestionFile->id);

                $file->save($audio);
                $filesModel->save($file);
                $chronographQuestionFiles->file_id = $filesModel->getInsertID();
                $chronographQuestionFiles->type_id = 1;
                $chronographQuestionFiles->chronograph_question_id = $chronographQuestionId;
                $chronographQuestionFilesModel->save($chronographQuestionFiles);
            }
            if (!empty($fileLink) && ($fileLink instanceof \CodeIgniter\Files\File) && $fileLink->isFile()) {
                $chronographQuestionFile = $chronographQuestionFilesModel->where('type_id', '2')->where('chronograph_question_id', $chronographQuestionId)->first();
                if (!empty($chronographQuestionFile))
                    $chronographQuestionFilesModel->delete($chronographQuestionFile->id);

                $file->save($fileLink);
                $filesModel->save($file);
                $chronographQuestionFiles->file_id = $filesModel->getInsertID();
                $chronographQuestionFiles->type_id = 2;
                $chronographQuestionFiles->chronograph_question_id = $chronographQuestionId;
                $chronographQuestionFilesModel->save($chronographQuestionFiles);
            }

            Output::ok([
                'message' => SuccessMessages::get(2202)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }

    }

    public function saveText()
    {
        try {
            $chronographModel = new \App\Models\Chronograph();
            $chronograph = new \App\Entities\Chronograph\Chronograph();

            $post = $this->request->getPost();
            ChronographValid::saveText($post);

            $chronograph->text = $post['text'];
            $chronograph->id = 1;
            $chronographModel->save($chronograph);

            Output::ok([
                'message' => SuccessMessages::get(2201)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function index()
    {
        $chronographModel = new \App\Models\Chronograph();
        $chronographQuestionAnswerModel = new \App\Models\ChronographQuestionAnswers();


        $chronographQuestionAnswerModel->select('chronograph_question_answers.*');
        $chronographQuestionAnswerModel->select('u.full_name as user_name');
        $chronographQuestionAnswerModel->select('u.email as user_email');
        $chronographQuestionAnswerModel->select('cq.text as question_text');
        $chronographQuestionAnswerModel->join('chronograph_questions cq', 'cq.id = chronograph_question_answers.chronograph_question_id', 'left');
        $chronographQuestionAnswerModel->join('users u', 'u.id = chronograph_question_answers.user_id', 'left');
        $chronographQuestionAnswerModel->where('chronograph_question_answers.deleted_at IS NULL');
        $chronographQuestionAnswers = $chronographQuestionAnswerModel->findAll();

        $chronograph = $chronographModel->first();
        $data['chronograph'] = $chronograph->toRawArray();
        $data['answers'] = ChronographQuestionAnswersView::getAnswersRows($chronographQuestionAnswers);

        echo view('pages/admin/chronograph', $data);
    }
}