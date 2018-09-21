<?php


namespace App\Tests\Repository;


use App\Config\Config;
use App\Entity\Task;
use App\Repository\TaskRepository;
use PHPUnit\Framework\TestCase;


class TaskRepositoryTest extends TestCase
{
    protected function setUp()
    {
        Config::$environment = 'test';
        Config::clearDb();
    }


    public function testInsert()
    {
        $task = new Task();
        $task->setUserName('Jon123');
        $task->setEmail('jon1@exmple.com');
        $task->setText('text1');
        $task->setImagePath('/tmp');
        $task->setExecuted(true);
        $repository = new TaskRepository();
        $repository->insert($task);

        $task = $repository->findById(1);

        $this->assertEquals('Jon123',$task->getUserName());
    }

    public function testFindById()
    {
        $task = new Task();
        $task->setUserName('Jon123');
        $task->setEmail('jon1@exmple.com');
        $task->setText('text1');
        $task->setImagePath('/tmp');
        $task->setExecuted(true);
        $repository = new TaskRepository();
        $repository->insert($task);
        $repository = new TaskRepository();
        $task = $repository->findById(1);

        $this->assertEquals('Jon123',$task->getUserName());
    }

    public function testOrdered()
    {
        $repository = new TaskRepository();

        $task = new Task();
        $task->setUserName('Jon1');
        $task->setEmail('jon1@exmple.com');
        $task->setText('text1');
        $task->setImagePath('/tmp');
        $task->setExecuted(true);
        $repository->insert($task);

        $task = new Task();
        $task->setUserName('Jon2');
        $task->setEmail('jon2@exmple.com');
        $task->setText('text2');
        $task->setImagePath('/tmp');
        $task->setExecuted(false);
        $repository->insert($task);

        $task = new Task();
        $task->setUserName('Jon3');
        $task->setEmail('jon3@exmple.com');
        $task->setText('text3');
        $task->setImagePath('/tmp');
        $task->setExecuted(true);
        $repository->insert($task);

        $task = new Task();
        $task->setUserName('Jon4');
        $task->setEmail('jon4@exmple.com');
        $task->setText('text4');
        $task->setImagePath('/tmp');
        $task->setExecuted(false);
        $repository->insert($task);

        $taskList = $repository->ordered("userName", "ASC", 2, 2);
        $this->assertEquals(2,count($taskList));
        $this->assertEquals('Jon3', $taskList[0]->getUserName());

        $taskList = $repository->ordered("userName", "DESC", 3, 1);
        $this->assertEquals(1,count($taskList));
        $this->assertEquals('Jon1', $taskList[0]->getUserName());
    }

    public function testTotalRecords()
    {
        $repository = new TaskRepository();
        $task = new Task();
        $task->setUserName('Jon1');
        $task->setEmail('jon1@exmple.com');
        $task->setText('text1');
        $task->setImagePath('/tmp');
        $task->setExecuted(true);
        $repository->insert($task);

        $task = new Task();
        $task->setUserName('Jon2');
        $task->setEmail('jon2@exmple.com');
        $task->setText('text2');
        $task->setImagePath('/tmp');
        $task->setExecuted(false);
        $repository->insert($task);

        $task = new Task();
        $task->setUserName('Jon3');
        $task->setEmail('jon3@exmple.com');
        $task->setText('text3');
        $task->setImagePath('/tmp');
        $task->setExecuted(true);
        $repository->insert($task);

        $totalRecords = $repository->totalRecords();

        $this->assertEquals(3, $totalRecords);
    }

}