<?php namespace App\Controllers;

use App\Libraries\Output;
use CodeIgniter\Controller;
use CodeIgniter\Files\File;

/**
 * FilesController
 *
 * Контроллер для доступа к файлам
 *
 * Class FilesController
 * @package App\Controllers
 */
class FilesController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

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
    }

    public function get()
    {
        try {
            $filePath = WRITEPATH . $this->request->uri->getPath();
            if(!file_exists($filePath))
                throw new \Exception('Не найдено', 404);

            $file = new File($filePath);

            if (ob_get_level())
                ob_end_clean();
            header('Content-Type: ' . $file->getMimeType());
            header('Expires: ' . date(DATE_RFC2822, time() + 86400));
            header('Cache-Control: max-age=3600');
            header('Pragma: cache');
            header('Content-Length: ' . $file->getSize());
            readfile($filePath);
            exit();

        } catch (\Exception $e) {
            if($e->getCode() == '403')
                Output::output(view('errors/html/error_403'));
            elseif ($e->getCode() == '404')
                Output::output(view('errors/html/error_404'));
            else
                Output::output(view('errors/html/error_500'));
        }
    }
}
