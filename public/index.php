<?php

require __DIR__.'/../vendor/autoload.php';

use App\Config\Routes;
use App\Core\Kernel;
use App\Core\Request;
use App\Core\Router;

session_start();
$env = $_SERVER['APP_ENV'] ?? 'dev';
$kernel = new Kernel($env);
$request = Request::createFromGlobals();
$router = new Router(Routes::$routes);
$response = $kernel->handle($request, $router);
$response->send();
