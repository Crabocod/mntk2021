<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\BusinessPrograms\BusinessProgramValid;
use App\Entities\BusinessPrograms\BusinessProgramView;
use App\Entities\Files\File;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Files;

class Programs extends BaseController
{
    public function publicProgram()
    {
        try {
            $programModel = new \App\Models\BusinessPrograms();

            $post = $this->request->getPost();

            $program = $programModel->where('id', $post['id'])->first();
            if ($program->is_published == 1)
                $program->is_published = 0;
            else
                $program->is_published = 1;

            $programModel->save($program);

            Output::ok([
                'message' => SuccessMessages::get(2401)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteProgram()
    {
        try {
            $programModel = new \App\Models\BusinessPrograms();

            $post = $this->request->getPost();
            BusinessProgramValid::delete($post);

            $programModel->delete($post['id']);

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function showPrograms()
    {
        try {
            $businessProgramsModel = new \App\Models\BusinessPrograms();
            $businessProgramsModel->select('business_programs.*');
            $businessProgramsModel->select('f.link as file_link');
            $businessProgramsModel->select('f_min.link as file_min_link');
            $businessProgramsModel->join('files f', 'f.id = business_programs.photo_file_id', 'left');
            $businessProgramsModel->join('files f_min', 'f_min.id = business_programs.photo_min_file_id', 'left');
            $businessProgramsModel->where('business_programs.deleted_at IS NULL');
            $businessPrograms = $businessProgramsModel->findAll();

            Output::ok([
                'html' => BusinessProgramView::getProgramCards($businessPrograms)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveProgram()
    {
        try {
            $programsModel = new \App\Models\BusinessPrograms();
            $program = new \App\Entities\BusinessPrograms\BusinessProgram();

            $file = new File();
            $filesModel = new Files();

            $post = $this->request->getPost();
            $fileImg = $this->request->getFile('img_link');
            BusinessProgramValid::save($post, $this->request);

            if (!empty($post['id'])) {
                $program->id = $post['id'];
                $program->is_published = (!empty($post['is_publication']))?'1':'0';
            }

            $program->title = $post['title'];
            $program->date = date('Y-m-d H:i:s',strtotime($post['date']));
            $program->text = $post['text'];
            $program->youtube_iframe = $post['iframe'];

            if (!empty($fileImg) && ($fileImg instanceof \CodeIgniter\Files\File) && $fileImg->isFile()) {
                $file->save($fileImg);
                $filesModel->save($file);
                $program->photo_file_id = $filesModel->getInsertID();

                // Добавление миниатюры изображения
                $imgFile = new File();
                $result = $imgFile->handleImage($file->link);

                if($result === true && !empty($imgFile->image_min_link)) {
                    $filesModel->insert([
                        'ext_id' => $file->ext_id,
                        'title' => $file->title,
                        'link' => $imgFile->image_min_link,
                        'size' => $file->size
                    ]);
                    $program->photo_min_file_id = $filesModel->getInsertID();
                }
            }

            $programsModel->save($program);

            Output::ok([
                'message' => SuccessMessages::get(2400)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function index()
    {
        echo view('pages/admin/programs');
    }
}