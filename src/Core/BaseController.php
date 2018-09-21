<?php


namespace App\Core;


use App\Model\ModelInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class BaseController
{
    /**
     * @var Twig_Environment
     */
    public $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
        $this->twig = new Twig_Environment($loader, [
            'cache' => false,
            'auto_reload' => true,
            'debug' => true,
        ]);
    }

    /**
    * Returns errors Response
    *
    * @param ModelInterface $model
    *
    * @return Response
    */
    public function errorResponse(ModelInterface $model): Response
    {
        $errors = $model->getErrors();
        $response = new Response(json_encode(["errors" => $errors]), 400);
        return $response;
    }

}