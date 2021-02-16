<?php

use App\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

include dirname(__DIR__).'/vendor/autoload.php';

/*
 * Simple authentication
 */
$_ENV['user'] = 'none';
if (isset($_COOKIE['user_hash'])) {
    if ($_COOKIE['user_hash'] === \App\Config::ADMIN_HASH) {
        $_ENV['user'] = 'admin';
    }
}

// Twig env register
$loader = new FilesystemLoader('../src/View');
$twig = new Environment($loader);

// Create Symfony component Request
$request = Request::createFromGlobals();
$router = new Router($request, $twig);
$router->handle();