<?php

use App\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

include dirname(__DIR__).'/vendor/autoload.php';

$loader = new FilesystemLoader('../src/View');
$twig = new Environment($loader);
$request = Request::createFromGlobals();
$router = new Router($request, $twig);
$router->handle();