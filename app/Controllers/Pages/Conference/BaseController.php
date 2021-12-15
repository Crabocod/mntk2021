<?php
namespace App\Controllers\Pages\Conference;

use App\Entities\Users\UserSession;
use App\Libraries\DateTime;
use App\Models\BusinessPrograms;
use App\Models\Conference;
use App\Models\SortBlocksModel;
use CodeIgniter\Config\Services;
use http\Client\Curl\User;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

class BaseController extends \App\Controllers\BaseController
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    public static $events = [];
    public static $programs = [];
    public static $sections = [];

    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();

        $conferenceModel = new Conference();
        $sortBlocksModel = new SortBlocksModel();

        $router = Services::router()->getMatchedRoute();
        $path = '';
        if(!empty($router[0]))
            $path = $router[0];

        if($path !== 'acquaintance') {
            $conference = $conferenceModel->asArray()->first();
            $timerBlock = $sortBlocksModel->where('id', 3)->first();
            if(!empty($timerBlock) && empty($timerBlock['hide']) && !empty($conference['timer'])) {
                $now = DateTime::byUserTimeZone(UserSession::getUser(), date('Y-m-d H:i:s'));
                $timer = DateTime::byUserTimeZone(UserSession::getUser(), $conference['timer']);

                if(strtotime($now) > strtotime($timer)) {
                    header('Location: /acquaintance');
                    exit();
                }
            }
        }

        $this->setEvents();
        $this->setPrograms();
        $this->setSections();
    }

    protected function setEvents() {
        $eventsModel = new \App\Models\Events();

        $eventsModel->asArray();
        self::$events = $eventsModel->find();
    }

    protected function setPrograms() {
        $programsModel = new BusinessPrograms();

        $programsModel->asArray();
        $programsModel->where('is_published', 1);
        self::$programs = $programsModel->find();
    }

    protected function setSections() {
        $sectionsModel = new \App\Models\Sections();

        $sectionsModel->asArray();
        $sectionsModel->where('is_publication', 1);
        self::$sections = $sectionsModel->find();
    }

    public static function getEvents($type_id = 0) {
        $result = [];
        if(!empty($type_id)) {
            foreach (self::$events as $event) {
                if($event['event_type_id'] == $type_id)
                    $result[] = $event;
            }
        } else {
            $result = self::$events;
        }
        return $result;
    }
}
