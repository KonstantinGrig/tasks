<?php
/**
 * Created by PhpStorm.
 * User: kostjami
 * Date: 14.09.18
 * Time: 23:03
 */

namespace App\Core;


class Request
{
    /**
     * @var string
     */
    public $method;

    /**
     * @var string
     */
    public $query;

    /**
     * @var array
     */
    public $queryArray;


    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $pathArray;

    /**
     * @var string
     */
    public $body;

    /**
     * @var array
     */
    public $post;

    /**
     * @var array
     */
    public $files;

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return static
     */
    public static function createFromGlobals()
    {
        $request = new Request();
        $request->query = $_SERVER["QUERY_STRING"];
        $request->queryArray = $_REQUEST;
        $request->method = strtoupper($_SERVER["REQUEST_METHOD"]);
        $request->uri = $_SERVER["REQUEST_URI"];
        $request->path = strtolower(rtrim(parse_url($request->uri, PHP_URL_PATH), "/"));
        $request->pathArray = explode("/", trim($request->path, "/"));
        $request->body = file_get_contents('php://input');
        $request->post = $_POST;
        $request->files = $_FILES;

        return $request;
    }

}