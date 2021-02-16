<?php

namespace App\Controller;

use App\Config;
use App\Model\Task;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class MainController implements Controller
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
        if ($this->request->getMethod() === Request::METHOD_GET) {
            $this->mainGet();
        } else {
            $this->mainPost();
        }
    }

    public function mainGet(): void
    {
        $user = null;
        if ($_ENV['user'] === Config::ADMIN_LOGIN) {
            $user = Config::ADMIN_LOGIN;
        }

        $tasks = Task::getAll();
        $response = new Response($this->env->render('main.html', ['tasks' => $tasks, 'user' => $user]));
        $response->send();
    }

    public function mainPost(): void
    {
        $settings = $this->request->get('settings');
        $username = $settings['name'];
        $email = $settings['email'];
        $text = $settings['text'];
        $status = false;
        Task::addTask($username, $email, $text, $status);

        $response = new RedirectResponse('/');
        $response->send();
    }
}