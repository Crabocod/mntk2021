<?php namespace App\Controllers\Pages\Admin;

use App\Controllers\Pages\BaseController;
use App\Entities\SectionJury\SectionJuryValid;
use App\Entities\Sections\SectionView;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;

class JuryWork extends BaseController
{
    public function addJuryWork()
    {
        try {
            $juryWorkModel = new \App\Models\Sections();

            // Валидация
            $post = $this->request->getPost();
            SectionJuryValid::add($post);

            $date_from = DateTime::fromUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s', strtotime($post['date_from'])));

            // Сохранение
            $data = [
                'title' => $post['title'],
                'number' => $post['number'],
                'protection_date' => $date_from
            ];
            $juryWorkModel->insert($data);
            $data['id'] = $juryWorkModel->getInsertID();

            Output::ok([
                'url' => '/admin/jury-work/' . $data['id'],
                'message' => SuccessMessages::get(1200)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function index()
    {
        $sectionsModel = new \App\Models\Sections();
        $usersModel = new \App\Models\Users();
        $sectionJuryModel = new \App\Models\SectionJury();

        $users = $usersModel->findAll();
        $sectionJury = $sectionJuryModel->findAll();

        $sectionsModel->select('sections.*');
        $sectionsModel->select('preview_file.link as preview_file_link');
        $sectionsModel->join('files preview_file', 'preview_file.id=sections.preview_file_id', 'left');
        $sections = $sectionsModel->orderBy('protection_date', 'asc')->findAll();

        $data['sections'] = SectionView::getAdminSectionsCards($sections, $users, $sectionJury);

        echo view('pages/admin/jury_work', $data);
    }
}