<?php

namespace App\Router;

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
//        echo $this->env->render('main.html');
        echo $this->request->getRequestUri();
    }
}