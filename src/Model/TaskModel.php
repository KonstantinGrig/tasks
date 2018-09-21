<?php


namespace App\Model;


use App\Core\Request;
use App\Core\Util;
use App\Entity\Task;
use App\Repository\TaskRepository;

class TaskModel extends BaseModel implements ModelInterface
{
    const ALLOW_IMAGE_WITH = 320;
    const ALLOW_IMAGE_HEIGHT = 240;
    const ALLOW_IMAGE_TYPES = ["image/png", "image/jpeg", "image/gif"];
    const ERROR_MESSAGE_IMAGE_TYPES = "Разрешены только JPG/GIF/PNG";

    /**
     * Resolve entity from Post And File
     *
     * @param Request $request
     *
     * @return void
     */
    public function fillModelForTaskCreate(Request $request)
    {
        $stdClass = (object)$request->post;
        if (is_null($stdClass)) {
            $this->errors["error"] = "Error in post array";
        } else {
            $entity = Util::cast(new Task(), $stdClass);
            $this->entity = $entity;
        }

        if (isset($request->files['image'])) {
            $this->image = $request->files['image'];
        }
    }

    /**
     * @return bool
     */
    public function isErrors() {
        return count($this->errors) > 0;
    }

    public function insertEntityFromModel()
    {
        $ts = (new \DateTime())->getTimestamp();
        $imageUrl = "/uploads/".$ts."/".$this->image['name'];
        $uploadDir = __DIR__."/../../public"."/uploads/".$ts;
        $uploadfile = $uploadDir."/".$this->image['name'];
        mkdir($uploadDir, 0777, true);
        $tmpName = $this->image['tmp_name'];

        list($width, $height, $type, $attr) = getimagesize($this->image["tmp_name"]);
        if ($width > self::ALLOW_IMAGE_WITH || $height > self::ALLOW_IMAGE_HEIGHT) {
            $imageType = $this->image['type'];
            $imgResourceResized = Util::resizeImage($tmpName, $imageType, self::ALLOW_IMAGE_WITH, self::ALLOW_IMAGE_HEIGHT);
            switch ($imageType) {
                case 'image/jpeg':
                    imagejpeg ($imgResourceResized, $uploadfile);
                    break;
                case 'image/gif':
                    imagegif($imgResourceResized, $uploadfile);
                    break;
                default:
                    imagepng($imgResourceResized, $uploadfile);
                    break;
            }
        } else {
            move_uploaded_file($tmpName, $uploadfile);
        }

        $entity = $this->entity;
        $entity->imagePath = $imageUrl;
        $taskRepository = new TaskRepository();
        $taskRepository->insert($entity);
    }

    public function fillModelForTaskList(array $query)
    {
        $this->order = 'id';
        $this->direction = 'ASC';
        $this->offset = 0;
        $this->limit = 3;
        $taskRepository = new TaskRepository();
        if (isset($query['order']) && Util::hasClassProperty(Task::class, $query['order'])) {
            $this->order = $query['order'];
        }
        if (isset($query['direction']) && in_array($query['direction'], ['ASC', 'DESC'])) {
            $this->direction = $query['direction'];
        }
        if (isset($query['offset'])) {
            $this->offset = (int)$query['offset'];
        }
        if (isset($query['limit'])) {
            $this->limit = (int)$query['limit'];
        }
        $tasks = $taskRepository->ordered($this->order, $this->direction, $this->offset, $this->limit);
        if (count($tasks) > 0) {
            $this->entityList = $tasks;
        }
        $this->totalRecords = $taskRepository->totalRecords();
    }

    public function fillModelById(int $id)
    {
        $taskRepository = new TaskRepository();
        $task = $taskRepository->findById($id);
        $this->entity = $task;
    }
    public function fillModelForTaskUpdate($post)
    {
        if (isset($post['id'])) {
            $this->fillModelById($post['id']);
            if (isset($this->entity)) {
                if ($post['text']) {
                    $this->entity->text = $post['text'];
                }
                if ($post['executed']) {
                    $this->entity->executed = true;
                } else {
                    $this->entity->executed = false;
                }
            }
        }
    }

    public function updateEntityFromModel()
    {
        if (isset($this->entity)) {
            $taskRepository = new TaskRepository();
            $taskRepository->update($this->entity);
        }
    }

    public function validate(): bool
    {
        $result = parent::validate();
        if (isset($this->image["tmp_name"])) {
            if (in_array($this->image["tmp_name"], self::ALLOW_IMAGE_TYPES)) {
                $this->errors["entity"]["image"] = self::ERROR_MESSAGE_IMAGE_TYPES;
                $result = false;
            }
        }
        return $result;
    }
}