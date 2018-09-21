<?php


namespace App\Tests\Model;


use App\Model\TaskModel;
use PHPUnit\Framework\TestCase;

class TaskModelTest extends TestCase
{
    public function testResolveRequestOk()
    {
        $model = new TaskModel();
        $body = '{"userName":"Jon","email":"jon@example.com"}';
        $model->resolveEntityFromJson($body);
        $entity = $model->getEntity();
        $this->assertEquals('Jon', $entity->getUserName());
        $this->assertEquals('jon@example.com', $entity->getEmail());
    }

    public function testResolveRequestErrorJson()
    {
        $model = new TaskModel();
        $body = '{"userName":"Jon","email":"jon@example.com"}';
        $model->resolveEntityFromJson($body);
        $entity = $model->getEntity();
        $this->assertEquals('Jon', $entity->getUserName());
        $this->assertEquals('jon@example.com', $entity->getEmail());
    }

    public function testValidationOk()
    {
        $model = new TaskModel();
        $body = '{"userName":"Jon","email":"jon@example.com"}';
        $model->resolveEntityFromJson($body);

        $model->validate();

        $this->assertEquals([], $model->getErrors());
    }

    public function testValidationError()
    {
        $model = new TaskModel();
        $body = '{"userName":"J on","email":"jon example.com"}';
        $model->resolveEntityFromJson($body);

        $model->validate();

        $errors = $model->getErrors();
        $this->assertEquals("Имя пользователя не должно содержать пробелов, длина должа быть 1-15 симворлов", $errors["entity"]["userName"]);
        $this->assertEquals("Ожидается корректный email", $errors["entity"]["email"]);
    }
}
