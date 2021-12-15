<?php namespace App\Controllers\Pages\OldConference;

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

    protected $conference;

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

        $confModel = new Conferences();

        $url_segments = $request->uri->getSegments();
        $conference = $confModel->where('url_segment', $url_segments[0])->first();

        if(empty($conference)) {
            if($request->isAJAX())
                Output::error(ErrorMessages::get(300));
            else
                Output::output(view('errors/html/error_404'));
        }

        $this->conference = $conference;
    }

}