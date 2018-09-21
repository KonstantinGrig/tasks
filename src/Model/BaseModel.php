<?php
/**
 * Created by PhpStorm.
 * User: kostjami
 * Date: 19.09.18
 * Time: 16:29
 */

namespace App\Model;


use App\Core\Util;

class BaseModel
{
    /**
     * @var string
     */
    public $current_user = Util::USER_ANONYMOUS;

    /**
     * @var object
     */
    public $entity;

    /**
     * @var array
     */
    public $entityList = [];

    /**
     * @var string
     */
    public $order = 'id';

    /**
     * @var array
     */
    public $image = [];

    /**
     * @var string
     */
    public $direction = 'ASC';

    /**
     * @var int
     */
    public $offset = 0;

    /**
     * @var int
     */
    public $limit = 3;

    /**
     * @var int
     */
    public $totalRecords = 0;

    /**
     * @var array
     */
    public $errors = [];

    public function __construct()
    {
        $this->current_user  = Util::getSessionUser();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function validate():bool
    {
        $result = true;
        $entity = $this->entity;
        if ($entity != null) {
            $validators = $entity->getValidators();
            foreach ($validators as $name => $value) {
                if (!$value["validator"]->validate($entity->$name)) {
                    $result = false;
                    $this->errors["entity"][$name] = $value["message"];
                }
            }
        }
        return $result;
    }

}