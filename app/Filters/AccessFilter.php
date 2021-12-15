<?php namespace App\Filters;

use App\Libraries\Output;
use CodeIgniter\Config\Services;
use App\Libraries\ErrorMessages;
use App\Entities\Users\UserSession;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AccessFilter implements FilterInterface
{
    /**
     * Метод который вывывается перед любым контроллером!
     *
     * @param RequestInterface $request
     * @param null $arguments
     * @return \CodeIgniter\HTTP\RedirectResponse|mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $router = Services::router()->getMatchedRouteOptions();
        if (in_array($router['name'], ['auth', 'cli', 'recovery', 'registration', 'api/auth', 'logout', '/', 'uploads/get']))
            return;

        $user = UserSession::getUser();
        if ($user !== false) {
            if ($user->hasPrivilege($router['name']))
                return;
        }
        if ($request->isAJAX())
            Output::error(['message' => ErrorMessages::get(4)]);
        else
            Output::output(view('errors/html/error_403'));
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