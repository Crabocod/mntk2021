<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Events\EventValid;
use App\Entities\FileExts\FileExtsStorage;
use App\Entities\Files\File;
use App\Entities\GoogleFormImgs\GoogleFormImg;
use App\Entities\GoogleFormImgs\GoogleFormImgValid;
use App\Entities\GoogleFormImgs\GoogleFormImgView;
use App\Entities\Users\UserSession;
use App\Entities\Users\UserValid;
use App\Libraries\DateTime;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\EventGallery;
use App\Models\EventTypes;
use App\Models\Files;
use App\Models\GoogleFormImgs;
use App\Models\UserEventFeedbacks;
use App\Models\UserEvents;
use App\Models\Users as UsersModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

class Events extends BaseController
{
    public function index()
    {
        $eventModel = new \App\Models\Events();
        $userEventModel = new \App\Models\UserEvents();
        $eventTypesModel = new EventTypes();
        
        $path = \CodeIgniter\Config\Services::router()->getMatchedRoute()[0];
        if($path === 'admin/master-classes')
            $event_type_id = 1;
        elseif($path === 'admin/experts')
            $event_type_id = 2;
        elseif($path === 'admin/lounge-time')
            $event_type_id = 3;
        elseif($path === 'admin/oil-english-club')
            $event_type_id = 4;
        else
            Output::output(view('errors/html/error_404'));

        $eventModel->select('events.*');
        $eventModel->select('preview_file.link as preview_file_link');
        $eventModel->join('files preview_file', 'preview_file.id=events.preview_file_id', 'left');
        $eventModel->where('event_type_id', $event_type_id);
        $events = $eventModel->orderBy('date_from', 'asc')->findAll();
        $userEvents = $userEventModel->findAll();

        $data['events'] = \App\Entities\Events\EventView::getEditorEventsCards($events, $userEvents,  explode('/', $path)[1] ?? '');

        $data['event_type'] = $eventTypesModel->where('id', $event_type_id)->first();

        echo view('pages/admin/events', $data);
    }

    public function add()
    {
        try {
            $eventsModel = new \App\Models\Events();
            $eventTypesModel = new EventTypes();

            // Валидация
            $post = $this->request->getPost();
            EventValid::add($post);

            $date_from = DateTime::fromUserTimeZone(UserSession::getUser(), $post['date_from']);

            // Сохранение
            $data = [
                'event_type_id' => $post['event_type_id'],
                'title' => $post['title'],
                'speaker' => $post['speaker'],
                'date_from' => $date_from
            ];
            $eventsModel->insert($data);

            $data['id'] = $eventsModel->getInsertID();

            $url_segment = '';
            if($post['event_type_id'] == 1)
                $url_segment = 'master-classes';
            elseif($post['event_type_id'] == 2)
                $url_segment = 'experts';
            elseif($post['event_type_id'] == 3)
                $url_segment = 'lounge-time';
            elseif($post['event_type_id'] == 4)
                $url_segment = 'oil-english-club';

            Output::ok([
                'url' => '/admin/' . $url_segment . '/' . $data['id'],
                'message' => SuccessMessages::get(1200)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function update($id)
    {
        try {
            $eventsModel = new \App\Models\Events();

            // Валидация
            $post = $this->request->getPost();
            $files = [];
            if (!empty($this->request->getFiles()))
                $files = $this->request->getFiles();
            EventValid::save($post, $files);

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

            if(!empty($data['date_from']))
                $data['date_from'] = DateTime::fromUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s', strtotime($data['date_from'])));
            if(!empty($data['date_to']))
                $data['date_to'] = DateTime::fromUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s', strtotime($data['date_to'])));

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

            $eventsModel->where('id', $id)->set($data)->update();

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

    public function delete($event_id)
    {
        try {
            $eventsModel = new \App\Models\Events();
            $event = $eventsModel->asArray()->where('id', $event_id)->first();

            $eventsModel->delete($event_id);

            $url_segment = '';
            if($event['event_type_id'] == 1)
                $url_segment = 'master-classes';
            elseif($event['event_type_id'] == 2)
                $url_segment = 'experts';
            elseif($event['event_type_id'] == 3)
                $url_segment = 'lounge-time';
            elseif($event['event_type_id'] == 4)
                $url_segment = 'oil-english-club';

            Output::ok([
                'message' => SuccessMessages::get(1203),
                'url' => '/admin/'.$url_segment
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function confirmUser($event_id)
    {
        try {
            $userEventsModel = new UserEvents();

            $post = $this->request->getPost();

            $userEventsModel->where('user_id', $post['user_id'])->where('event_id', $event_id)->set('status', $post['status'])->update();

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function addImage($event_id)
    {
        try {
            $eventGalleryModel = new EventGallery();
            $filesModel = new Files();
            $fileEntity = new File();
            $fileMinEntity = new File();

            $file = $this->request->getFile('img');

            // Валидация
            if (empty($file))
                throw new \Exception(ErrorMessages::get(75));
            if ($file->isFile() === false)
                throw new \Exception(ErrorMessages::get(75));

            $valid = Services::validation();
            $valid->setRules([
                'img' => [
                    'label' => 'Изображение',
                    'rules' => 'is_image[img]|max_size[img,102400]',
                ]
            ]);
            if (!$valid->withRequest($this->request)->run())
                throw new \Exception($valid->listErrors('modal_errors'));

            if (!$file->isValid())
                throw new \Exception(ErrorMessages::get(76));
            if ($file->hasMoved())
                throw new \Exception(ErrorMessages::get(77));
            if (FileExtsStorage::getByExtension($file->getClientExtension()) === false)
                throw new \Exception(ErrorMessages::get(76));

            // Сохранение
            $fileEntity->save($file);
            if(empty($fileEntity->link))
                throw new \Exception(ErrorMessages::get(77));
            $filesModel->save($fileEntity);
            $fileEntity->id = $filesModel->getInsertID();

            $result = $fileMinEntity->handleImage($fileEntity->link);

            if($result === true && !empty($fileMinEntity->image_min_link)) {
                $filesModel->insert([
                    'ext_id' => $fileEntity->ext_id,
                    'title' => $fileEntity->title,
                    'link' => $fileMinEntity->image_min_link,
                    'size' => $fileEntity->size
                ]);
                $fileMinEntity->id = $filesModel->getInsertID();
            }

            $lastEvent = $eventGalleryModel->orderBy('sort_num', 'DESC')->first();
            if(empty($lastEvent))
                $lastEvent['sort_num'] = 0;
            $lastEvent['sort_num']++;

            $eventGalleryModel->insert([
                'event_id' => $event_id,
                'photo_file_id' => $fileEntity->id ?? 0,
                'photo_min_file_id' => $fileMinEntity->id ?? 0,
                'sort_num' => $lastEvent['sort_num']
            ]);

            $img_link = '';
            if(!empty($fileMinEntity->image_min_link))
                $img_link = $fileMinEntity->image_min_link;
            elseif(!empty($fileEntity->link))
                $img_link = $fileEntity->link;

            Output::ok(['html' => "<div data-id=".$eventGalleryModel->getInsertID()." class='admin-photo-block'><img src='/".$img_link."'><div class=delete-photo></div></div>"]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteImage()
    {
        try {
            $eventGalleryModel = new EventGallery();

            // Валидация
            $post = $this->request->getPost();
            GoogleFormImgValid::delete($post);

            // Удаление
            $eventGalleryModel->delete($post['id']);

            Output::ok(['message' => SuccessMessages::get(76)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sortImage($event_id)
    {
        try {
            $eventGallery = new EventGallery();

            // Валидация
            $post = $this->request->getPost();
            GoogleFormImgValid::sort($post);

            // Добавление новых записей
            $updateData = [];
            foreach ($post['sort'] as $sort) {
                $updateData[] = [
                    'id' => $sort['id'],
                    'sort_num' => $sort['sort_num']
                ];
            }

            $eventGallery->updateBatch($updateData, 'id');

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}