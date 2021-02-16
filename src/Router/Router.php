<?php

namespace App\Router;

use App\Controller\MainController;
use App\Controller\SecurityController;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class Router
{
    private Request $request;
    private Environment $env;

    public function __construct(Request $request, Environment $env)
    {
        $this->request = $request;
        $this->env = $env;
    }

    public function handle(): void
    {
        if ($this->request->getMethod() === Request::METHOD_POST) {
            echo "Methods POSTS";
        }

        $requestUri = $this->request->getRequestUri();
        $controller = null;

        switch ($requestUri) {
            case '/':
                $controller = new MainController($this->request, $this->env);
                break;
            case '/login' or '/logout':
                $controller = new SecurityController($this->request, $this->env);
                break;
        }

        $controller->route();
    }
}