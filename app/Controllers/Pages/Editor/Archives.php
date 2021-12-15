<?php namespace App\Controllers\Pages\Editor;

use App\Entities\ArchiveFeedbacks\ArchiveFeedbackValid;
use App\Entities\ArchiveFeedbacks\ArchiveFeedbackView;
use App\Entities\ArchiveFiles\ArchiveFile;
use App\Entities\ArchiveFiles\ArchiveFileView;
use App\Entities\Archives\Archive;
use App\Entities\Archives\ArchiveValid;
use App\Entities\Archives\ArchiveView;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use App\Models\ArchiveFeedbacks;
use App\Models\ArchiveFiles;
use App\Entities\ArchiveFiles\ArchiveFileValid;

class Archives extends BaseController
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
            $event_id = $res[3];

        if (isset($conference_id) && isset($event_id)){
            $archiveModel = new \App\Models\Archives();
            $event = $archiveModel->where('conference_id', $conference_id)->where('id', $event_id)->first();
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
        $archivesModel = new \App\Models\Archives();

        $archivesModel->where('conference_id', $this->conference->id);
        $archivesModel->orderBy('date', 'DESC');
        $archives = $archivesModel->find();

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['archives'] = ArchiveView::getTableRows($archives, $this->conference->id);
        echo view('pages/editor/archives', $data);
    }

    public function about($conference_id, $archive_id)
    {
        $archivesModel = new \App\Models\Archives();
        $archiveFilesModel = new ArchiveFiles();
        $archviveFeedbacksModel = new ArchiveFeedbacks();

        $archive = $archivesModel->find($archive_id);
        $files = $archiveFilesModel->where('archive_id', $archive_id)->find();
        $feedbacks = $archviveFeedbacksModel->show_all(['archive_id'=>$archive_id, 'with_user' => true]);

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();
        $data['archive'] = $archive->toArray();
        $data['archive_files'] = ArchiveFileView::getEditorRows($files);
        $data['archive_feedbacks'] = ArchiveFeedbackView::getEditorTableRows($feedbacks);
        echo view('pages/editor/archive', $data);
    }

    public function saveArchive()
    {
        try {
            $archiveModel = new \App\Models\Archives();
            $archive = new Archive();

            // Валидация
            $post = $this->request->getPost();
            ArchiveValid::add($post);

            $post['date'] = date('Y-m-d H:i:s', strtotime($post['date']));

            // Сохранение
            $archive->fill($post);
            $archive->conference_id = $this->conference->id;
            $archiveModel->save($archive);
            if(!isset($post['id']))
                $archive->id = $archiveModel->getInsertID();

            Output::ok([
                'url' => '/editor/'.$this->conference->id.'/archives/'.$archive->id,
                'html' => ArchiveView::getTableRow($archive->toArray(), $this->conference->id),
                'message' => SuccessMessages::get(600)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteArchive($conference_id, $archive_id)
    {
        try {
            $archiveModel = new \App\Models\Archives();

            // Удаление
            $archiveModel->delete($archive_id);

            Output::ok([
                'url' => '/editor/'.$conference_id.'/archives',
                'message' => SuccessMessages::get(601)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function addArchiveFile($conference_id, $archive_id)
    {
        try {
            $archiveFilesModel = new ArchiveFiles();
            $archiveFile = new ArchiveFile();

            // Валидация
            $post['archive_id'] = $archive_id;
            ArchiveFileValid::save($post, $this->request);

            // Сохранение
            $file = $this->request->getFile('link');
            $archiveFile->saveFile($file);
            $archiveFile->archive_id = $archive_id;
            $archiveFilesModel->save($archiveFile);

            $archiveFile->id = $archiveFilesModel->getInsertID();

            Output::ok([
                'html' => ArchiveFileView::getEditorRow($archiveFile->toArray()),
                'message' => SuccessMessages::get(700)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteArchiveFile()
    {
        try {
            $archiveFilesModel = new ArchiveFiles();

            // Валидация
            $post = $this->request->getPost();
            ArchiveFileValid::delete($post);

            // Удаление
            $archiveFilesModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(701)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function deleteArchiveFeedback()
    {
        try {
            $archiveFeedbackModel = new ArchiveFeedbacks();

            // Валидация
            $post = $this->request->getPost();
            ArchiveFeedbackValid::delete($post);

            // Удаление
            $archiveFeedbackModel->delete($post['id']);

            Output::ok([
                'message' => SuccessMessages::get(801)
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}
