<?php namespace App\Controllers\Pages\Editor;


use App\Entities\Events\EventValid;
use App\Entities\Events\EventView;
use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Libraries\SuccessMessages;
use mysql_xdevapi\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Events extends BaseController
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

        if (isset($conference_id) && isset($event_id)) {
            $eventModel = new \App\Models\Events();
            $event = $eventModel->where('conference_id', $conference_id)->where('id', $event_id)->first();
            if (empty($event)) {
                if ($this->request->isAJAX())
                    Output::error(['message' => ErrorMessages::get(300)]);
                else
                    Output::output(view('errors/html/error_404'));
            }
        }
    }

    public function index()
    {
        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();

        $eventModel = new \App\Models\Events();
        $userEventModel = new \App\Models\UserEvents();
        $events = $eventModel->where('conference_id', $data['conference']['id'])->orderBy('date', 'asc')->findAll();
        $userEvents = $userEventModel->findAll();

        $data['events'] = \App\Entities\Events\EventView::getEditorEventsCards($events, $userEvents);
        echo view('pages/editor/events', $data);
    }

    public function saveEvent()
    {
        try {
            $eventsModel = new \App\Models\Events();

            // Валидация
            $post = $this->request->getPost();
            EventValid::save($post);

            $date = date("Y-m-d 12:00:00", strtotime($post['date']));
            $date = DateTime::fromUserTimeZone(UserSession::getUser(), $date);

            // Сохранение
            $data = [
                'conference_id' => $this->conference->id,
                'title' => $post['title'],
                'speaker' => $post['speaker'],
                'date' => $date
            ];
            $eventsModel->insert($data);

            $data['id'] = $eventsModel->getInsertID();

            $html = \App\Entities\Events\EventView::getEditorEventCard($data, 0, 0);
            Output::ok([
                'url' => '/editor/' . $this->conference->id . '/events/' . $data['id'],
                'message' => SuccessMessages::get(1200),
                'html' => $html,
            ]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function about($url_segment, $event_id)
    {
        $eventsModel = new \App\Models\Events();
        $userEventsModel = new \App\Models\UserEvents();

        $event = $eventsModel->where('id', $event_id)->first();

        $userEventsModel->select('user_events.*');
        $userEventsModel->select('users.name as user_name');
        $userEventsModel->select('users.surname as user_surname');
        $userEventsModel->select('users.email as user_email');
        $userEventsModel->select('users.id as user_id');
        $userEventsModel->join('users', 'users.id = user_events.user_id', 'left');
        $userEventsModel->where('event_id', $event_id);
        $userEvent = $userEventsModel->findAll();
        //echo '<pre>';print_r($userEvent);exit();

        $data['event'] = EventView::getEditorEventAbout($event, $userEvent);

        $data['url_segments'] = $this->request->uri->getSegments();
        $data['conference'] = $this->conference->toArray();

        echo view('pages/editor/event_about', $data);
    }

    public function saveAbout($url_segment, $event_id)
    {
        try {
            $eventsModel = new \App\Models\Events();
            $file = $this->request->getFile('event_preview');
            $fileName = $file->getName();

            // Проверка
            $event = $eventsModel->find($event_id);
            if (empty($event))
                throw new Exception(ErrorMessages::get(1200));

            // Валидация
            $post = $this->request->getPost();
            EventValid::saveEventItems($post, $this->request);

            $date = date("Y-m-d H:i:s", strtotime($post['date']));
            $date = DateTime::fromUserTimeZone(UserSession::getUser(), $date);

            // Сохранение
            $event->saveEventPreview($file);
            $event->preview_img_name = $fileName;
            $event->title = $post['title'];
            $event->date = $date;
            $event->full_text = $post['full_text'];
            $event->short_text = $post['short_text'];
            $event->speaker = $post['speaker'];
            $event->show_button = $post['show_button'];

            if ($event->hasChanged())
                $eventsModel->save($event);

            Output::ok(['message' => SuccessMessages::get(1201)]);

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function userChangeStatus()
    {
        try {
            $userEventsModel = new \App\Models\UserEvents();
            $post = $this->request->getPost();
            $userEvent = $userEventsModel->where('id', $post['id'])->first();

            $userEvent->status = $post['status'];
            $userEventsModel->save($userEvent);

            $userEventsModel->select('user_events.*');
            $userEventsModel->select('users.name as user_name');
            $userEventsModel->select('users.surname as user_surname');
            $userEventsModel->select('users.email as user_email');
            $userEventsModel->join('users', 'users.id = user_events.user_id', 'left');
            $userEventsModel->where('user_events.id', $post['id']);
            $res = $userEventsModel->first();

            $html = EventView::getUserEventCard($res->toArray());
            Output::ok([
                'message' => SuccessMessages::get(1202),
                'html' => $html
            ]);
        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function delete($conference_id)
    {
        try {
            $post = $this->request->getPost();

            $eventsModel = new \App\Models\Events();
            $eventsModel->where('id', $post['id'])->delete();

            Output::ok([
                'message' => SuccessMessages::get(1203),
                'href' => '/editor/' . $conference_id . '/events'
            ]);
        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }

    public function getUsersExcel($conference_id, $event_id)
    {
        try {
            // Вывод всех пользователей этого меропрития
            $usersModel = new \App\Models\Users();
            $usersModel->select('users.*');
            $usersModel->select('ue.status as ue_status');
            $usersModel->join('user_events ue', 'ue.user_id=users.id', 'left');
            $usersModel->where('ue.event_id', $event_id);
            $users = $usersModel->find();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Ответы пользователей');
            $sheet->setCellValue("A1", "#");
            $sheet->setCellValue("B1", "Фамилия");
            $sheet->setCellValue("C1", "Имя");
            $sheet->setCellValue("D1", "Почта");
            $sheet->setCellValue("E1", "Статус");

            # Ширина столбцов
            $sheet->getColumnDimension("A")->setWidth(5);
            $sheet->getColumnDimension("B")->setWidth(20);
            $sheet->getColumnDimension("C")->setWidth(20);
            $sheet->getColumnDimension("D")->setWidth(20);
            $sheet->getColumnDimension("E")->setWidth(20);

            # Жирность
            $sheet->getStyle("A1")->getFont()->setBold(true);
            $sheet->getStyle("B1")->getFont()->setBold(true);
            $sheet->getStyle("C1")->getFont()->setBold(true);
            $sheet->getStyle("D1")->getFont()->setBold(true);
            $sheet->getStyle("E1")->getFont()->setBold(true);

            if (!empty($users)) {
                $i = 1;
                foreach ($users as $user) {
                    $ue_status = ($user->ue_status == 0) ? '' : (($user->ue_status == 1) ? 'Принят' : 'Отклонен');

                    // Запись данных
                    $sheet->setCellValue("A" . ($i + 1), $i);
                    $sheet->setCellValue("B" . ($i + 1), $user->surname);
                    $sheet->setCellValue("C" . ($i + 1), $user->name);
                    $sheet->setCellValue("D" . ($i + 1), $user->email);
                    $sheet->setCellValue("E" . ($i + 1), $ue_status);

                    // Переносы строк и автовысота
                    $sheet->getStyle("A" . ($i + 1))->getAlignment()->setWrapText(true);
                    $sheet->getStyle("B" . ($i + 1))->getAlignment()->setWrapText(true);
                    $sheet->getStyle("C" . ($i + 1))->getAlignment()->setWrapText(true);
                    $sheet->getStyle("D" . ($i + 1))->getAlignment()->setWrapText(true);
                    $sheet->getStyle("E" . ($i + 1))->getAlignment()->setWrapText(true);

                    $i++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            ob_start();
            $writer->save('php://output');
            $xlsData = ob_get_contents();
            ob_end_clean();
            echo json_encode('data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,' . base64_encode($xlsData));

        } catch (\Exception $e) {
            Output::error(['message' => $e->getMessage()]);
        }
    }
}
