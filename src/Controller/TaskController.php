<?php

namespace App\Controller;


use App\Core\BaseController;
use App\Core\Request;
use App\Core\Response;
use App\Core\Util;
use App\Model\TaskModel;
use App\Repository\TaskRepository;


class TaskController extends BaseController
{

    public function taskList(Request $request): Response
    {
        $model = new TaskModel(new TaskRepository());
        $model->fillModelForTaskList($request->queryArray);

        return new Response($this->twig->render('taskList.html', ['model' => $model]));
    }

    public function taskCreateForm(Request $request): Response
    {
        return new Response($this->twig->render('taskCreate.html', ['model' => '']));
    }

    public function taskCreate(Request $request): Response
    {
        $model = new TaskModel(new TaskRepository());
        $model->fillModelForTaskCreate($request);

        if ($model->isErrors() || !$model->validate()) {
            return $this->errorResponse($model);
        }

        $model->insertEntityFromModel();

        return new Response("Task created");
    }

    public function taskEditForm(Request $request): Response
    {
        $currentUser = Util::getSessionUser();
        if ($currentUser != 'admin') {
            Util::redirect('/deny');
        }
        if (!$request->queryArray['id']) {
            Util::redirect('/');
        }
        $model = new TaskModel(new TaskRepository());
        $model->fillModelById($request->queryArray['id']);
        return new Response($this->twig->render('taskEdit.html', ['model' => $model]));
    }

    public function taskEdit(Request $request): Response
    {
        $currentUser = Util::getSessionUser();
        if ($currentUser != 'admin') {
            Util::redirect('/deny');
        }
        $model = new TaskModel(new TaskRepository());
        $model->fillModelForTaskUpdate($request->post);
        $model->updateEntityFromModel();
        Util::redirect('/');
    }

    public function deny(Request $request): Response
    {
        return new Response($this->twig->render('deny.html', []));
    }
}