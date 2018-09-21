<?php


namespace App\Model;


use App\Core\Request;
use App\Core\Util;
use App\Entity\User;

class UserModel extends BaseModel
{
    const ADMIN_NAME = "admin";
    const ADMIN_PASSWORD = "123";

    /**
     * Resolve entity from Post
     *
     * @param Request $request
     *
     * @return void
     */
    public function resolveEntityFromPost(Request $request)
    {
        $stdClass = (object)$request->post;
        if (is_null($stdClass)) {
            $this->errors["error"] = "Error in post array";
        } else {
            $entity = Util::cast(new User(), $stdClass);
            $this->entity = $entity;
        }
    }


    public function validate():bool
    {
        $res = false;
        if (isset($this->entity->userName) && (isset($this->entity->userName))
            && $this->entity->userName == self::ADMIN_NAME && $this->entity->password == self::ADMIN_PASSWORD) {
            $res = true;
        } else {
            $this->errors["error"] = "Неверное имя или пароль";
        }

        return $res;
    }

}