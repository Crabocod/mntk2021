<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\Chess\ChessValid;
use App\Entities\Chess\ChessView;
use App\Entities\Conferences\ConferenceValid;
use App\Entities\FileExts\FileExtsStorage;
use App\Entities\Files\File;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\Chess;
use App\Models\Conference;
use App\Models\Files;
use App\Models\SortBlocksModel;
use App\Models\SortNavigationBlockItemsModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class Index extends BaseController
{
    public function index()
    {
        $chessModel = new Chess();
        $conferenceModel = new Conference();
        $sortBlocksModel = new SortBlocksModel();
        $sortNavigationBlocksModel = new SortNavigationBlockItemsModel();

        $sortBlocksModel->orderBy('number', 'ASC');
        $data['sort_blocks'] = $sortBlocksModel->find();

        $chessModel->select('chess.*');
        $chessModel->select('img_file.link as img_file_link');
        $chessModel->select('img_min_file.link as img_min_file_link');
        $chessModel->join('files img_file', 'img_file.id=chess.img_file_id', 'left');
        $chessModel->join('files img_min_file', 'img_min_file.id=chess.img_min_file_id', 'left');
        $chessModel->orderBy('date', 'desc');
        $chess = $chessModel->findAll();

        $conferenceModel->select('conference.*');
        $conferenceModel->select('logo_file.link as logo_file_link');
        $conferenceModel->select('logo_file.title as logo_file_title');
        $conferenceModel->join('files logo_file', 'logo_file.id=conference.logo_file_id', 'left');
        $data['conference'] = $conferenceModel->asArray()->first();
        $data['chess'] = ChessView::getTableRows($chess);

        if(!empty($data['conference']['timer']))
            $data['conference']['timer'] = DateTime::byUserTimeZone(UserSession::getUser(), $data['conference']['timer']);

        $sortNavigationBlocksModel->orderBy('number', 'ASC');
        $data['sort_navigation_items'] = $sortNavigationBlocksModel->find();

        echo view('pages/admin/index', $data);
    }
    
    public function sortBlocks()
    {
        try {
            $sortBlocksModel = new SortBlocksModel();

            $post = $this->request->getPost();

            $updateBatch = [];
            $sort_numbers = json_decode($post['sort_numbers'], true);
            foreach ($sort_numbers as $sort_number) {
                $updateBatch[] = [
                    'id' => $sort_number['id'],
                    'number' => $sort_number['number']
                ];
            }

            if (!empty($updateBatch)) {
                $sortBlocksModel->updateBatch($updateBatch, 'id');
            }

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sortNabItems()
    {
        try {
            $sortNavigationBlockItemsModel = new SortNavigationBlockItemsModel();

            $post = $this->request->getPost();

            $updateBatch = [];
            $sort_numbers = json_decode($post['sort_numbers'], true);
            foreach ($sort_numbers as $sort_number) {
                $updateBatch[] = [
                    'id' => $sort_number['id'],
                    'number' => $sort_number['number']
                ];
            }

            if (!empty($updateBatch)) {
                $sortNavigationBlockItemsModel->emptyTable();
                $sortNavigationBlockItemsModel->insertBatch($updateBatch, 'id');
            }

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function hideBlock()
    {
        try {
            $sortBlocksModel = new SortBlocksModel();

            $post = $this->request->getPost();
            ConferenceValid::hideBlock($post);

            $sortBlocksModel->where('id', $post['id'])->set('hide', $post['hide'])->update();

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function updateMainBlock()
    {
        try {
            $fileEntity = new File();
            $filesModel = new Files();
            $conferenceModel = new Conference();

            $post = $this->request->getPost();
            $files = [];
            if (!empty($this->request->getFiles()))
                $files = $this->request->getFiles();
            ConferenceValid::updateMainBlock($post, $files);

            $data = [
                'title' => $post['title'],
                'sub_title' => $post['sub_title'],
                'date' => $post['date'],
                'specialist_num' => $post['specialist_num'],
                'og_num' => $post['og_num'],
                'experts_num' => $post['experts_num'],
                'sections_num' => $post['sections_num'],
                'projects_num' => $post['projects_num'],
            ];

            // Сохранение файла
            if(!empty($files['logo'])) {
                $fileEntity->save($files['logo']);
                $filesModel->save($fileEntity);
                $logoFileId = $filesModel->getInsertID();

                $logoMinFileId = 0;
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
                        $logoMinFileId = $filesModel->getInsertID();
                    }
                }

                $data['logo_file_id'] = $logoFileId;
                $data['logo_min_file_id'] = $logoMinFileId;
            }

            $conferenceModel->where('id', 1)->set($data)->update();

            Output::ok([
                'message' => SuccessMessages::get(300)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function updateTimer()
    {
        try {
            $conferenceModel = new Conference();

            $post = $this->request->getPost();
            ConferenceValid::updateTimer($post);

            $date = DateTime::fromUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s', strtotime($post['timer'])));

            $data = [
                'timer' => $date
            ];

            $conferenceModel->where('id', 1)->set($data)->update();

            Output::ok([
                'message' => SuccessMessages::get(300)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveChess()
    {
        try {
            $chessModel = new Chess();
            $fileEntity = new File();
            $filesModel = new Files();
            $chess = new \App\Entities\Chess\Chess();

            $file = $this->request->getFile('img_link');

            // Валидация
            $post = $this->request->getPost();
            $files = [];
            if (!empty($this->request->getFiles()))
                $files = $this->request->getFiles();
            ChessValid::save($post, $this->request);

            // Сохранение
            if(!empty($post['id']) and !empty($post['deleted_icon'])) {
                $chess->img_file_id = 0;
                $chess->img_min_file_id = 0;
            }
            $chess->date = DateTime::fromUserTimeZone(UserSession::getUser(), $post['date']);
            $chess->type = $post['type'];
            $chess->title = $post['title'];
            $chess->page_url = $post['page_url'];
            if(isset($post['id']))
                $chess->id = $post['id'];

            // Сохранение файла
            if(!empty($files['icon']) && ($files['icon'] instanceof UploadedFile) && $files['icon']->isFile()) {
                $fileEntity->save($files['icon']);
                $filesModel->save($fileEntity);
                $fileId = $filesModel->getInsertID();

                $minFileId = 0;
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
                        $minFileId = $filesModel->getInsertID();
                    }
                }

                $chess->img_file_id = $fileId;
                $chess->img_min_file_id = $minFileId;
            }

            if ($chess->hasChanged())
                $chessModel->save($chess);

            $chess->id = $chessModel->getInsertID();

            Output::ok([
                'html' => ChessView::getTableRow($chess->toArray()),
                'message' => SuccessMessages::get(500)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteChess()
    {
        try {
            $chessModel = new Chess();

            // Валидация
            $post = $this->request->getPost();
            ChessValid::delete($post);

            // Сохранение
            $chessModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(501)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}