<?php

namespace App\Controller;


use App\Core\BaseController;
use App\Core\Request;
use App\Core\Response;
use App\Core\Util;
use App\Model\UserModel;


class UserController extends BaseController
{
    public function loginForm(Request $request): Response
    {
        return new Response($this->twig->render('login.html', []));
    }

    public function loginPost(Request $request): Response
    {
        $model = new UserModel();
        $model->resolveEntityFromPost($request);
        if ($model->validate()) {
            Util::setSessionUser($model->getEntity()->userName);
            Util::redirect('/');
        }
        return new Response($this->twig->render('login.html', ["model" => $model]));
    }

    public function logout(Request $request): Response
    {
            Util::setSessionUser(Util::USER_ANONYMOUS);
            Util::redirect('/');
    }
}
