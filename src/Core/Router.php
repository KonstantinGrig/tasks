<?php


namespace App\Core;


use App\Config\Routes;

class Router
{
    const CONTROLLER_PATH = "App\Controller\\";

    /**
     * @var array
     */
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function getController(Request $request): BaseController
    {
        $route = $this->getRoute($request);
        $controllerName = $route["controller"];
        $controllerFullPath = self::CONTROLLER_PATH.$controllerName;
        $controller = new $controllerFullPath();
        return $controller;
    }

    public function getAction(Request $request): string
    {
        $route = $this->getRoute($request);
        return $route["action"];
    }

    private function getRoute(Request $request): array
    {
        $method = $request->method;
        $path = $request->path == "" ? "/" : $request->path;
        $routes = Routes::$routes;
        $route = $routes["default"]["GET"];
        if (isset($routes[$path][$method])) {
            $route = $routes[$path][$method];
        }

        return $route;
    }
}