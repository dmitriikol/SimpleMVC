<?php

namespace App\Controller;

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
        if ($this->request->getMethod() === Request::METHOD_POST) {
            $this->mainPost();
        } else {
            $this->mainGet();
        }
    }

    public function mainGet(): void
    {
        $tasks = Task::getAll();
        $response = new Response($this->env->render('main.html', ['tasks' => $tasks]));
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