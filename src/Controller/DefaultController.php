<?php

namespace App\Controller;


use App\Core\BaseController;
use App\Core\Response;


class DefaultController extends BaseController
{

    /**
     * Returns Page not found
     *
     * @return Response
     */
    public function notFound(): Response {
        $response = new Response("Page not found", 404);
        return $response;
    }

}