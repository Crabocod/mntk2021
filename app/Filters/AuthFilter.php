<?php namespace App\Filters;

use App\Models\Conferences;
use App\Models\Users;
use App\Libraries\Output;
use CodeIgniter\Config\Services;
use App\Libraries\ErrorMessages;
use App\Entities\Users\UserSession;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Entities\Roles\RoleStorage;
use App\Entities\FileExts\FileExtsStorage;

/**
 * Аутентификация пользователя
 *
 * Class AuthFilter
 * @package App\Filters
 */
class AuthFilter implements FilterInterface
{
    public $session;

    public function __construct()
    {
        $this->session = session();
    }

    /**
     * Метод который вывывается перед любым контроллером!
     * Маршруты auth и logout не обрабатываются
     *
     * @param RequestInterface $request
     * @param null $arguments
     * @return \CodeIgniter\HTTP\RedirectResponse|mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $router = Services::router()->getMatchedRouteOptions();
            if (in_array($router['name'], ['auth', 'cli', 'recovery', 'registration', 'logout', 'uploads/get']))
                return;

            if (empty($userSession = UserSession::getUser()))
                throw new \Exception();

            $usersModel = new Users();
            $usersModel->withPermissions()->where('email', $userSession->email);
            if (empty($user = $usersModel->first()))
                throw new \Exception();

            if (!UserSession::checkSession($user))
                throw new \Exception();

            // Обновление служебных данных пользователя.
            $sessionCorrect = $userSession->updated_at == $user->updated_at;
            if (!$sessionCorrect)
                \App\Entities\Users\UserSession::set($user);
            if (!$sessionCorrect or empty(RoleStorage::get())) {
                $rolesModel = new \App\Models\Roles();
                $roles = $rolesModel->handleById()->findAll();
                RoleStorage::set($roles);
            }
            if (!$sessionCorrect or empty(FileExtsStorage::get())) {
                $fileExtsModel = new \App\Models\FileExts();
                $fileExts = $fileExtsModel->handleById()->findAll();
                FileExtsStorage::set($fileExts);
            }

            // Проверка на авторизацию в разных частях сайта (админ, редактор, участник)
            $uriSegments = $request->uri->getSegments();
            if (!empty($uriSegments[0]) && $uriSegments[0] == 'admin') {
                if (!$user->hasPrivilege('admin'))
                    throw new \Exception();
            } else {
                if (!$user->hasPrivilege('conference'))
                    throw new \Exception();
            }

        } catch (\Exception $e) {
            if ($request->isAJAX()) {
                $output = new Output();
                $output->error(['message' => ErrorMessages::get(2)]);
            } else {
                helper('cookie');
                set_cookie('lastPagePath', $request->uri->getPath(), 60 * 60 * 24);
                if ($router['name'] == 'uploads/get') {
                    Output::output(view('errors/html/error_403'));
                } else {
                    $firstSegment = $request->uri->getSegment(1);
                    if ($firstSegment == 'admin')
                        return redirect()->to('/admin/auth');
                    else
                        return redirect()->to('/auth');
                }
            }
        }
    }

    /**
     * Метод который вызывается после контроллера.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param null $arguments
     * @return mixed|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
