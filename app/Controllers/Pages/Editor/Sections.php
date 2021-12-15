<?php namespace App\Controllers\Pages\Editor;

use App\Entities\SectionFeedbacks\SectionFeedbackValid;
use App\Entities\SectionFeedbacks\SectionFeedbackView;
use App\Entities\SectionImages\SectionImage;
use App\Entities\SectionImages\SectionImageValid;
use App\Entities\SectionImages\SectionImageView;
use App\Entities\SectionImagesSort\SISValid;
use App\Entities\SectionJury\SectionJuryValid;
use App\Entities\SectionJury\SectionJuryView;
use App\Entities\Sections\Section;
use App\Entities\Sections\SectionValid;
use App\Entities\Sections\SectionView;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\SectionFeedbacks;
use App\Models\SectionImages;
use App\Models\SectionJury;

class Sections extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();

        $res = $this->request->uri->getSegments();
        $conference_id = $res[1];
        if (isset($res[3]) && is_numeric($res[3]))
            $section_id = $res[3];

        if (isset($conference_id) && isset($section_id)){
            $sectionModel = new \App\Models\Sections();
            $event = $sectionModel->where('conference_id', $conference_id)->where('id', $section_id)->first();
            if (empty($event)){
                if($this->request->isAJAX())
                    Output::error(['message' => ErrorMessages::get(300)]);
                else
                    Output::output(view('errors/html/error_404'));
            }
        }
    }

    public function index($conference_id)
    {
        $sectionsModel = new \App\Models\Sections();

        $sectionsModel->orderBy('protection_date', 'desc');
        $sectionsModel->where('conference_id', $conference_id);
        $sections = $sectionsModel->find();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['sections'] = SectionView::getEditorTableRows($sections, $conference_id);
        echo view('pages/editor/sections', $data);
    }

    public function about($conference_id, $section_id)
    {
        $sectionsModel = new \App\Models\Sections();
        $sectionFeedbacksModel = new SectionFeedbacks();
        $sectionJuryModel = new SectionJury();
        $sectionImagesModel = new SectionImages();

        $section = $sectionsModel->find($section_id);
        if (empty($section))
            Output::output(view('/errors/html/error_404'), true);

        $sectionFeedbacksModel->select('section_feedbacks.*');
        $sectionFeedbacksModel->select('u.name as user_name');
        $sectionFeedbacksModel->select('u.surname as user_surname');
        $sectionFeedbacksModel->join('users u', 'u.id=section_feedbacks.user_id', 'left');
        $sectionFeedbacks = $sectionFeedbacksModel->where('section_id', $section_id)->find();

        $sectionJury = $sectionJuryModel->where('section_id', $section_id)->find();

        $sectionImagesModel->orderBy('sort_num', 'asc');
        $sectionImages = $sectionImagesModel->where('section_images.section_id', $section_id)->find();

        $section = $section->toArray();
        $section['protection_date'] = DateTime::byUserTimeZone(UserSession::getUser(), $section['protection_date']);
        $section['discussion_date'] = DateTime::byUserTimeZone(UserSession::getUser(), $section['discussion_date']);

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['section'] = $section;
        $data['section_feedbacks'] = SectionFeedbackView::getEditorTableRows($sectionFeedbacks, $conference_id);
        $data['section_jury'] = SectionJuryView::getEditorTableRows($sectionJury);
        $data['section_images'] = SectionImageView::getEditorItems($sectionImages);
        echo view('pages/editor/section', $data);
    }

    public function save($conference_id)
    {
        try {
            $sectionsModel = new \App\Models\Sections();
            $section = new Section();

            // Валидация
            $post = $this->request->getPost();
            SectionValid::save($post);

            // Работа с датой
            $post['protection_time'] = isset($post['protection_time']) ? $post['protection_time'] : '12:00';
            $post['protection_date'] = DateTime::setTime($post['protection_date'], $post['protection_time']);
            $post['protection_date'] = DateTime::fromUserTimeZone(UserSession::getUser(), $post['protection_date']);

            if (isset($post['discussion_date'])):
                $post['discussion_time'] = isset($post['discussion_time']) ? $post['discussion_time'] : '12:00';
                $post['discussion_date'] = DateTime::setTime($post['discussion_date'], $post['discussion_time']);
                $post['discussion_date'] = DateTime::fromUserTimeZone(UserSession::getUser(), $post['discussion_date']);
            endif;

            // Сохранение
            $section->fill($post);
            $section->conference_id = $this->conference->id;
            $sectionsModel->save($section);
            if (!isset($post['id']))
                $section->id = $sectionsModel->getInsertID();
            $section->is_publication = 1;

            Output::ok([
                'url' => '/editor/'.$this->conference->id.'/sections/'.$section->id,
                'html' => SectionView::getEditorTableRow($section->toArray(), $this->conference->id),
                'message' => SuccessMessages::get(1000)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function publication($conference_id)
    {
        try {
            $sectionsModel = new \App\Models\Sections();
            $section = new Section();

            // Валидация
            $post = $this->request->getPost();
            SectionValid::publication($post);

            // Сохранение
            $section->id = $post['id'];
            $section->is_publication = $post['is_publication'];
            $sectionsModel->save($section);

            Output::ok([
                'message' => SuccessMessages::get(1000)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function delete($conference_id, $section_id)
    {
        try {
            $sectionsModel = new \App\Models\Sections();

            // Удаление
            $sectionsModel->delete($section_id);

            Output::ok([
                'url' => '/editor/' . $conference_id . '/sections',
                'message' => SuccessMessages::get(1001)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteFeedback($conference_id, $section_id)
    {
        try {
            $sectionFeedbackModel = new \App\Models\SectionFeedbacks();

            // Валидация
            $post = $this->request->getPost();
            SectionFeedbackValid::delete($post);

            // Удаление
            $sectionFeedbackModel->delete($post['id']);

            Output::ok(['message' => SuccessMessages::get(1101)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function saveJury($conference_id, $section_id)
    {
        try {
            $sectionModel = new \App\Models\Sections();
            $sectionJuryModel = new SectionJury();
            $jury = new \App\Entities\SectionJury\SectionJury();

            // Валидация
            $post = $this->request->getPost();
            SectionJuryValid::save($post);

            // Проверка
            $section = $sectionModel->find($section_id);
            if (empty($section))
                throw new \Exception(ErrorMessages::get(1000));

            // Сохранение
            $jury->fill($post);
            $jury->section_id = $section_id;
            $sectionJuryModel->save($jury);
            if (!isset($post['id']))
                $jury->id = $sectionJuryModel->getInsertID();

            Output::ok([
                'html' => SectionJuryView::getEditorTableRow($jury->toArray()),
                'message' => SuccessMessages::get(1300)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteJury($conference_id, $section_id)
    {
        try {
            $sectionJuryModel = new SectionJury();

            // Валидация
            $post = $this->request->getPost();
            SectionJuryValid::delete($post);

            // Удаление
            $sectionJuryModel->delete($post['id']);

            Output::ok(['message' => SuccessMessages::get(1301)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function addImage($conference_id, $section_id)
    {
        try {
            $sectionImagesModel = new SectionImages();
            $sectionImage = new SectionImage();

            $file = $this->request->getFile('img_orig');

            // Валидация
            $post = $this->request->getPost();
            $post['section_id'] = $section_id;
            \App\Entities\SectionImages\SectionImageValid::save($post, $this->request);

            // Сохранение
            $sectionImage->saveImage($file);
            $sectionImage->section_id = $section_id;
            $sectionImage->sort_num = $post['sort_num'];
            $sectionImagesModel->save($sectionImage);

            $sectionImage->id = $sectionImagesModel->getInsertID();

            Output::ok(['html' => SectionImageView::getEditorItem($sectionImage->toArray())]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteImage($conference_id, $section_id)
    {
        try {
            $sectionImagesModel = new SectionImages();

            // Валидация
            $post = $this->request->getPost();
            \App\Entities\SectionImages\SectionImageValid::delete($post);

            // Удаление
            $sectionImagesModel->delete($post['id']);

            Output::ok(['message' => SuccessMessages::get(76)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function sortImages($conference_id, $section_id)
    {
        try {
            $sectionImagesModel = new SectionImages();

            // Валидация
            $post = $this->request->getPost();
            $post['section_id'] = $section_id;
            SectionImageValid::sort($post);

            // Добавление новых записей
            $updateData = [];
            foreach ($post['sort'] as $sort) {
                $updateData[] = [
                    'id' => $sort['section_image_id'],
                    'sort_num' => $sort['sort_num']
                ];
            }

            $sectionImagesModel->updateBatch($updateData, 'id');

            Output::ok([]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}
