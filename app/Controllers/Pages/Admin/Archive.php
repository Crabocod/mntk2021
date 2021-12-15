<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Archives\ArchiveValid;
use App\Entities\Archives\ArchiveView;
use App\Entities\Events\EventValid;
use App\Entities\FileExts\FileExtsStorage;
use App\Entities\Files\File;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Archives;
use App\Models\EventTypes;
use App\Models\Files;
use CodeIgniter\HTTP\Files\UploadedFile;

class Archive extends BaseController
{
    public function index()
    {
        $archivesModel = new Archives();

        $archivesModel->asArray();
        $archivesModel->select('archives.*');
        $archivesModel->select('preview_file.link as preview_file_link');
        $archivesModel->select('preview_min_file.link as preview_min_file_link');
        $archivesModel->join('files preview_file', 'preview_file.id=archives.preview_file_id', 'left');
        $archivesModel->join('files preview_min_file', 'preview_min_file.id=archives.preview_min_file_id', 'left');
        $archives = $archivesModel->orderBy('date_from', 'asc')->find();

        $data['archives'] = ArchiveView::getTableRows($archives);

        echo view('pages/admin/archive', $data);
    }

    public function add()
    {
        try {
            $archivesModel = new \App\Models\Archives();

            // Валидация
            $post = $this->request->getPost();
            ArchiveValid::add($post);

            $date_from = DateTime::fromUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s', strtotime($post['date_from'])));

            // Сохранение
            $data = [
                'title' => $post['title'],
                'speaker' => $post['speaker'],
                'date_from' => $date_from
            ];
            $archivesModel->insert($data);

            $data['id'] = $archivesModel->getInsertID();

            Output::ok([
                'url' => '/admin/archive/' . $data['id'],
                'message' => SuccessMessages::get(1800)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function publication()
    {
        try {
            $archivesModel = new \App\Models\Archives();

            // Валидация
            $post = $this->request->getPost();
            ArchiveValid::publication($post);

            // Сохранение
            $data = [
                'is_published' => $post['is_published']
            ];
            $archivesModel->set($data)->where('id', $post['id'])->update();

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function update($id)
    {
        try {
            $archiveModel = new Archives();

            // Валидация
            $post = $this->request->getPost();
            $files = [];
            if (!empty($this->request->getFiles()))
                $files = $this->request->getFiles();
            ArchiveValid::save($post, $files);

            // Сохранение
            $data['id'] = $id;
            $data['show_button'] = (isset($post['show_button'])) ? 1 : 0;
            if(!empty($post['title']))
                $data['title'] = $post['title'];
            if(!empty($post['speaker']))
                $data['speaker'] = $post['speaker'];
            if(!empty($post['date_from']))
                $data['date_from'] = $post['date_from'].' '.$post['time_from'];
            if(!empty($post['date_to']))
                $data['date_to'] = $post['date_to'].' '.$post['time_to'];
            if(isset($post['about_speaker']))
                $data['about_speaker'] = $post['about_speaker'];
            if(isset($post['short_text']))
                $data['short_text'] = $post['short_text'];
            if(isset($post['full_text']))
                $data['full_text'] = $post['full_text'];
            if(isset($post['youtube_iframe']))
                $data['youtube_iframe'] = $post['youtube_iframe'];
            $data['is_published'] = (!empty($post['is_published'])) ? 1 : 0;

            if(!empty($data['date_from']))
                $data['date_from'] = DateTime::fromUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s', strtotime($data['date_from'])));

            // Сохранение изображений
            if(!empty($files['preview_file']) && !empty($result = $this->saveEventFile($files['preview_file']))) {
                $data['preview_file_id'] = $result['file_id'];
                $data['preview_min_file_id'] = $result['file_min_id'];
            }
            if(!empty($files['presentation_file']) && !empty($result = $this->saveEventFile($files['presentation_file']))) {
                $data['presentation_file_id'] = $result['file_id'];
                $data['presentation_min_file_id'] = $result['file_min_id'];
            }
            if(!empty($files['photo_file']) && !empty($result = $this->saveEventFile($files['photo_file']))) {
                $data['photo_file_id'] = $result['file_id'];
                $data['photo_min_file_id'] = $result['file_min_id'];
            }

            $archiveModel->where('id', $id)->set($data)->update();

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

    public function delete($archive_id)
    {
        try {
            $archiveModel = new Archives();
            $archive = $archiveModel->asArray()->where('id', $archive_id)->first();

            $archiveModel->delete($archive_id);

            Output::ok([
                'url' => '/admin/archive'
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

}