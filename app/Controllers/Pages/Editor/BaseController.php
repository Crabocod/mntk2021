<?php
namespace App\Controllers\Pages\Editor;

use App\Entities\Users\UserSession;
use App\Libraries\ErrorMessages;
use App\Libraries\Output;
use App\Models\Conferences;

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

class BaseController extends \App\Controllers\Pages\BaseController
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    protected $conference = null;

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

//        $conferenceModel = new Conferences();
//        $logsModel = new \App\Models\Logs();
//        $logs = new \App\Entities\Logs\Log();
//
//        $conference_id = $this->request->uri->getSegment(2);
//
//        $conference = $conferenceModel->find($conference_id);
//
//        if (empty($conference)) {
//            if($this->request->isAJAX())
//                Output::error(['message' => ErrorMessages::get(300)]);
//            else
//                Output::output(view('errors/html/error_404'));
//        }
//        $this->conference = $conference;
//
//        if ($this->request->getMethod() == 'post'){
//            try {
//                $user = UserSession::getUser();
//
//                $request = $this->request->uri->getPath();
//                $logs->user_id = $user->id;
//                $logs->request = $request;
//                $logs->data = json_encode($this->request->getPost());
//                $logsModel->save($logs);
//            } catch (\Exception $e) {
//                print_r($e->getMessage());exit();
//            }
//        }
    }
}
