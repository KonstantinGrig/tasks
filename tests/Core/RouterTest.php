<?php


namespace App\Tests\Core;


use App\Config\Routes;
use App\Core\Request;
use App\Core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testGetControllerDefaultController()
    {
        $router = new Router(Routes::$routes);
        $request = new Request();
        $request->method = "POST";
        $request->path = "/undefined_path";
        $controller = $router->getController($request);

        $this->assertInstanceOf("App\Controller\DefaultController", $controller);
    }

    public function testGetActionDefaultController()
    {
        $router = new Router(Routes::$routes);
        $request = new Request();
        $request->method = "POST";
        $request->path = "/undefined_path";
        $action = $router->getAction($request);

        $this->assertEquals("notFound", $action);
    }

    public function testGetControllerTaskController()
    {
        $router = new Router(Routes::$routes);
        $request = new Request();
        $request->method = "POST";
        $request->path = "/task";
        $controller = $router->getController($request);

        $this->assertInstanceOf("App\Controller\TaskController", $controller);
    }

    public function testGetActionTaskController()
    {
        $router = new Router(Routes::$routes);
        $request = new Request();
        $request->method = "POST";
        $request->path = "/task";
        $action = $router->getAction($request);

        $this->assertEquals("createTask", $action);
    }

}