<?php
/**
 * Created by PhpStorm.
 * User: kostjami
 * Date: 19.09.18
 * Time: 16:29
 */

namespace App\Model;


use App\Core\Util;
use phpDocumentor\Reflection\Types\Object_;

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
     * Returns $entity
     *
     * @return object
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * Returns $entityList
     *
     * @return array
     */
    public function getEntityList() {
        return $this->entityList;
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
                $getProperty= "get".ucfirst($name);
                if (!$value["validator"]->validate($entity->$getProperty())) {
                    $result = false;
                    $this->errors["entity"][$name] = $value["message"];
                }
            }
        }
        return $result;
    }

}