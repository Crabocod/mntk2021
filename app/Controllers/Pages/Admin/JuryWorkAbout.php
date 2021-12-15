<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\FileExts\FileExtsStorage;
use App\Entities\Files\File;
use App\Entities\SectionImages\SectionImage;
use App\Entities\SectionImages\SectionImageValid;
use App\Entities\SectionImages\SectionImageView;
use App\Entities\SectionJury\SectionJuryValid;
use App\Entities\SectionJury\SectionJuryView;
use App\Entities\Sections\SectionValid;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Files;
use App\Models\SectionImages;
use App\Models\Sections;
use CodeIgniter\HTTP\Files\UploadedFile;

class JuryWorkAbout extends BaseController
{
    public function deleteSection($id)
    {
        try {
            $sectionModel = new Sections();

            // Удаление
            $sectionModel->delete($id);

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveImages($id)
    {
        try {
            $filesModel = new \App\Models\Files();
            $sectionImagesModel = new SectionImages();
            $sectionImage = new SectionImage();

            $file = $this->request->getFile('img');

            // Валидация
            $post = $this->request->getPost();
            $post['section_id'] = $id;
            SectionImageValid::save($post, $this->request);

            $sectionImages = $sectionImagesModel->orderBy('sort_num', 'DESC')->first();
            $sortNum = (empty($sectionImages)) ? 0 : $sectionImages->sort_num;

            // Сохранение
            if(!empty($file) && !empty($result = $this->saveEventFile($file))) {
                $sectionImage->img_file_id = $result['file_id'];
                $sectionImage->img_min_file_id = $result['file_min_id'];
            }
            $sectionImage->section_id = $id;
            $sectionImage->sort_num = $sortNum + 1;
            $sectionImagesModel->save($sectionImage);

            if (!empty($sectionImage->img_min_file_id)){
                $file = $filesModel->where('id', $sectionImage->img_min_file_id)->first();
                $sectionImage->file_link = $file->link;
            }else{
                $file = $filesModel->where('id', $sectionImage->img_file_id)->first();
                $sectionImage->file_link = $file->link;
            }

            $sectionImage->id = $sectionImagesModel->getInsertID();

            Output::ok(['html' => SectionImageView::getEditorItem($sectionImage->toArray())]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteImages($id)
    {
        try {
            $sectionImagesModel = new SectionImages();

            // Валидация
            $post = $this->request->getPost();
            SectionImageValid::delete($post);

            // Удаление
            $sectionImagesModel->delete($post['id']);

            Output::ok(['message' => SuccessMessages::get(76)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sortImages($id)
    {
        try {
            $sectionImagesModel = new SectionImages();

            // Валидация
            $post = $this->request->getPost();
            $post['section_id'] = $id;
            SectionImageValid::sort($post);

            // Добавление новых записей
            $updateData = [];
            foreach ($post['sort'] as $sort) {
                $updateData[] = [
                    'id' => $sort['id'],
                    'sort_num' => $sort['sort_num']
                ];
            }

            $sectionImagesModel->updateBatch($updateData, 'id');

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function addJury($id)
    {
        try {
            $sectionJuryModel = new \App\Models\SectionJury();

            $post = $this->request->getPost();
            SectionJuryValid::save($post);

            $post['section_id'] = $id;
            $sectionJuryModel->save($post);

            $post['id'] = $sectionJuryModel->getInsertID();

            Output::ok([
                'message' => SuccessMessages::get(1300),
                'html' => SectionJuryView::getAdminTableRow($post)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteJury()
    {
        try {
            $sectionJuryModel = new \App\Models\SectionJury();

            $post = $this->request->getPost();
            SectionJuryValid::delete($post);

            $sectionJuryModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(1301)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveJury()
    {
        try {
            $sectionJuryModel = new \App\Models\SectionJury();

            $post = $this->request->getPost();
            SectionJuryValid::save($post);

            $sectionJuryModel->save($post);

            Output::ok([
                'message' => SuccessMessages::get(1300)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function update($id)
    {
        try {
            $sectionModel = new \App\Models\Sections();

            // Валидация
            $post = $this->request->getPost();
            $files = [];
            if (!empty($this->request->getFiles()))
                $files = $this->request->getFiles();
            SectionValid::save($post, $files);

            // Сохранение
            $data['id'] = $id;
            $data['is_publication'] = (isset($post['is_publication'])) ? 1 : 0;
            if(isset($post['title']))
                $data['title'] = $post['title'];
            if(!empty($post['date_from']))
                $data['protection_date'] = $post['date_from'].' '.$post['time_from'];
            if(isset($post['youtube_iframe']))
                $data['youtube_iframe'] = $post['youtube_iframe'];
            if(isset($post['number']))
                $data['number'] = $post['number'];

            if(!empty($data['protection_date']))
                $data['protection_date'] = DateTime::fromUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s', strtotime($data['protection_date'])));

            // Сохранение изображений
            if(!empty($files['preview_file']) && !empty($result = $this->saveEventFile($files['preview_file']))) {
                $data['preview_file_id'] = $result['file_id'];
                $data['preview_min_file_id'] = $result['file_min_id'];
            }

            $sectionModel->where('id', $id)->set($data)->update();

            Output::ok([
                'message' => SuccessMessages::get(1201)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    protected function saveEventFile(UploadedFile $file)
    {
        if (($file instanceof UploadedFile) === false)
            return [];
        if ($file->isFile() === false)
            return [];

        $fileEntity = new File();
        $filesModel = new Files();

        $data = [];
        $fileEntity->save($file);
        $filesModel->save($fileEntity);
        $file_id = $filesModel->getInsertID();

        $file_min_id = 0;
        if (FileExtsStorage::get($fileEntity->ext_id)['title'] == 'Изображение') {
            $imgFile = new File();
            $result = $imgFile->handleImage($fileEntity->link);
            if ($result === true && !empty($imgFile->image_min_link)) {
                $filesModel->insert([
                    'ext_id' => $fileEntity->ext_id,
                    'title' => $fileEntity->title,
                    'link' => $imgFile->image_min_link,
                    'size' => $fileEntity->size
                ]);
                $file_min_id = $filesModel->getInsertID();
            }
        }

        $data['file_id'] = $file_id;
        $data['file_min_id'] = $file_min_id;

        return $data;
    }

    public function index($id)
    {
        $sectionsModel = new \App\Models\Sections();
        $sectionsFeedbackModel = new \App\Models\SectionFeedbacks();
        $sectionsImagesModel = new \App\Models\SectionImages();
        $sectionsJuryModel = new \App\Models\SectionJury();
        $usersModel = new \App\Models\Users();

        $sectionsModel->select('sections.*');
        $sectionsModel->select('preview_file.title as preview_file_title');
        $sectionsModel->join('files preview_file', 'preview_file.id=sections.preview_file_id', 'left');
        $section = $sectionsModel->where('sections.id', $id)->asArray()->first();

        if(empty($section))
            Output::output(view('errors/html/error_404'));

        if(!empty($section['protection_date'])) {
            $section['protection_date'] = DateTime::byUserTimeZone(UserSession::getUser(), $section['protection_date']);
        }

        $section['users'] = $usersModel->where('section_id', $id)->asArray()->findAll();
        $section['jury'] = $sectionsJuryModel->where('section_id', $id)->asArray()->findAll();

        $sectionsImagesModel->select('section_images.*');
        $sectionsImagesModel->select('photo_file.link as photo_file_link');
        $sectionsImagesModel->select('photo_min_file.link as photo_min_file_link');
        $sectionsImagesModel->join('files photo_file', 'photo_file.id=section_images.img_file_id', 'left');
        $sectionsImagesModel->join('files photo_min_file', 'photo_min_file.id=section_images.img_min_file_id', 'left');
        $sectionsImagesModel->orderBy('sort_num', 'ASC');
        $section['gallery'] = $sectionsImagesModel->where('section_images.section_id', $id)->asArray()->find();

        $sectionsFeedbackModel->select('section_feedbacks.*');
        $sectionsFeedbackModel->select('u.full_name as user_full_name');
        $sectionsFeedbackModel->join('users u', 'u.id=section_feedbacks.user_id', 'left');
        $section['feedbacks'] = $sectionsFeedbackModel->where('section_feedbacks.section_id', $id)->asArray()->find();

        echo view('pages/admin/jury_work_about', $section);
    }
}