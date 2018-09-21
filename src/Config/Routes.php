<?php


namespace App\Config;


class Routes
{
    static public $routes = [
        "default" => [
            "GET" => [
                "controller" => "DefaultController",
                "action" => "notFound"
            ]
        ],
        "/task" => [
            "POST" => [
                "controller" => "TaskController",
                "action" => "createTask"
            ]
        ],
        "/" => [
            "GET" => [
                "controller" => "TaskController",
                "action" => "taskList"
            ]
        ],
        "/taskcreateform" => [
            "GET" => [
                "controller" => "TaskController",
                "action" => "taskCreateForm"
            ]
        ],
        "/taskcreate" => [
            "POST" => [
                "controller" => "TaskController",
                "action" => "taskCreate"
            ]
        ],
        "/loginform" => [
            "GET" => [
                "controller" => "UserController",
                "action" => "loginForm"
            ]
        ],
        "/loginpost" => [
            "POST" => [
                "controller" => "UserController",
                "action" => "loginPost"
            ]
        ],
        "/logout" => [
            "GET" => [
                "controller" => "UserController",
                "action" => "logout"
            ]
        ],
        "/taskeditform" => [
            "GET" => [
                "controller" => "TaskController",
                "action" => "taskEditForm"
            ]
        ],
        "/taskedit" => [
            "POST" => [
                "controller" => "TaskController",
                "action" => "taskEdit"
            ]
        ],
        "/deny" => [
            "GET" => [
                "controller" => "TaskController",
                "action" => "deny"
            ]
        ],
    ];
}