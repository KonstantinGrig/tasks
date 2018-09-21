<?php

namespace App\Core;


use App\Config\Config;

class Kernel
{
    public function __construct(string $environment)
    {
        Config::$environment = $environment;
    }

    public function handle(Request $request, Router $router): Response
    {
        $controller = $router->getController($request);
        $action = $router->getAction($request);
        $response = call_user_func_array([$controller, $action], [$request]);
        return $response;
    }
}
