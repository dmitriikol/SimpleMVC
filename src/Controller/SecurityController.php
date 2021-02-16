<?php


namespace App\Controller;


use App\Config;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class SecurityController implements Controller
{
    private Request $request;
    private Environment $env;

    public function __construct(Request $request, Environment $env)
    {
        $this->request = $request;
        $this->env = $env;
    }

    public function route(): void
    {
        $uri = $this->request->getRequestUri();
        echo $uri;
        switch ($uri) {
            case '/login':
                if ($this->request->getMethod() === Request::METHOD_GET) {
                    $this->loginGet();
                } else {
                    $this->loginPost();
                }
                break;
            case '/logout':
                $this->logout();
                break;
        }

    }

    public function loginGet(): void
    {
        $user = getenv('user');
        $response = new Response($this->env->render('login.html'));
        $response->send();
    }

    public function loginPost(): void
    {
        $login = $this->request->get('login');
        $password = $this->request->get('password');
        $errors = [];

        if ($login === Config::ADMIN_LOGIN and $password === Config::ADMIN_PASSWORD) {
            $hash = Config::ADMIN_HASH;
            setcookie('user_login', Config::ADMIN_LOGIN, time()+60*60*24*30);
            setcookie('user_hash', $hash, time()+60*60*24*30);
            $_ENV['user'] = 'admin';

            $response = new RedirectResponse('/');
            $response->send();
        } else {
            $errors[] = 'Invalid login or password';
        }

        $response = new Response($this->env->render('login.html', ['errors' => $errors]));
        $response->send();
    }

    public function logout(): void
    {
        setcookie("user_login", "", time() - 3600*24*30*12, "/");
        setcookie("user_hash", "", time() - 3600*24*30*12, "/");
        $_ENV['user'] = 'none';

        $response = new RedirectResponse('/');
        $response->send();
    }
}