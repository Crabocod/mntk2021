<?php namespace App\Controllers\Pages\OldConference;

use App\Entities\ArchiveFeedbacks\ArchiveFeedback;
use App\Entities\ArchiveFeedbacks\ArchiveFeedbackValid;
use App\Entities\ArchiveFeedbacks\ArchiveFeedbackView;
use App\Entities\ArchiveFiles\ArchiveFileView;
use App\Entities\Archives\ArchiveView;
use App\Libraries\Output;
use App\Models\ArchiveFeedbacks;
use App\Models\ArchiveFiles;
use App\Models\Archives;
use App\Entities\Users\UserSession;

class Archive extends BaseController
{
    public function index($url_segment)
    {
        $confModel = new \App\Models\Conferences();
        $archivesModel = new Archives();

        $archivesModel->where('conference_id', $this->conference->id);
        $archivesModel->orderBy('date', 'desc');
        $archives = $archivesModel->find();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conferences'] = $this->conference;
        $data['archive'] = ArchiveView::getCards($archives, $url_segment);
        echo view('pages/conference/archive', $data);
    }

    public function about($url_segment, $archive_id)
    {
        $confModel = new \App\Models\Conferences();
        $archivesModel = new Archives();
        $archiveFilesModel = new ArchiveFiles();
        $archiveFeedbacksModel = new ArchiveFeedbacks();

        $archivesModel->where('id', $archive_id);
        $archivesModel->where('conference_id', $this->conference->id);
        $archive = $archivesModel->first();
        if(empty($archive))
            Output::output(view('errors/html/error_404'));

        $archiveFiles = $archiveFilesModel->where('archive_id', $archive->id)->find();

        $archiveFeedbacksModel->select('archive_feedbacks.*');
        $archiveFeedbacksModel->select('u.surname as user_surname');
        $archiveFeedbacksModel->select('u.name as user_name');
        $archiveFeedbacksModel->join('users u', 'u.id=archive_feedbacks.user_id', 'left');
        $archiveFeedbacksModel->where('archive_id', $archive->id);
        $archiveFeedbacks = $archiveFeedbacksModel->find();

        $data['conferences'] = $this->conference;
        $data['archive'] = $archive->toRawArray();
        $data['url_segments'] = $this->request->uri->getSegments();
        $data['archive_files'] = ArchiveFileView::getRows($archiveFiles);
        $data['archive_feedbacks'] = ArchiveFeedbackView::getFeedbackCards($archiveFeedbacks);
        echo view('pages/conference/archive_about', $data);
    }

    public function addFeedback($url_segment, $archive_id)
    {
        try {
            $archiveFeedbacksModel = new ArchiveFeedbacks();

            $user = UserSession::getUser();

            // Валидация
            $post = $this->request->getPost();
            ArchiveFeedbackValid::add($post);

            // Добавление отзыва
            $archiveFeedback = new ArchiveFeedback();
            $archiveFeedback->archive_id = $archive_id;
            $archiveFeedback->user_id = $user->id;
            $archiveFeedback->text = $post['text'];
            $archiveFeedbacksModel->save($archiveFeedback);

            // Вывод html
            $archiveFeedback->user_name = $user->name;
            $archiveFeedback->user_surname = $user->surname;
            $archiveFeedback->created_at = date('Y-m-d H:i:s');
            $html = ArchiveFeedbackView::getFeedbackCard($archiveFeedback->toRawArray());

            Output::ok(['html' => $html]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}