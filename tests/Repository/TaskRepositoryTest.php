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
        $task->userName = 'Jon123';
        $task->email = 'jon1@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository = new TaskRepository();
        $repository->insert($task);

        $task = $repository->findById(1);

        $this->assertEquals('Jon123',$task->userName);
    }

    public function testFindById()
    {
        $task = new Task();
        $task->userName = 'Jon123';
        $task->email = 'jon1@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository = new TaskRepository();
        $repository->insert($task);
        $repository = new TaskRepository();
        $task = $repository->findById(1);

        $this->assertEquals('Jon123',$task->userName);
    }

    public function testOrdered()
    {
        $repository = new TaskRepository();

        $task = new Task();
        $task->userName = 'Jon1';
        $task->email = 'jon1@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository->insert($task);

        $task = new Task();
        $task->userName = 'Jon2';
        $task->email = 'jon2@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository->insert($task);

        $task = new Task();
        $task->userName = 'Jon3';
        $task->email = 'jon3@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository->insert($task);

        $task = new Task();
        $task->userName = 'Jon4';
        $task->email = 'jon4@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository->insert($task);

        $taskList = $repository->ordered("userName", "ASC", 2, 2);
        $this->assertEquals(2,count($taskList));
        $this->assertEquals('Jon3', $taskList[0]->userName);

        $taskList = $repository->ordered("userName", "DESC", 3, 1);
        $this->assertEquals(1,count($taskList));
        $this->assertEquals('Jon1', $taskList[0]->userName);
    }

    public function testTotalRecords()
    {
        $repository = new TaskRepository();
        $task = new Task();
        $task->userName = 'Jon1';
        $task->email = 'jon1@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository->insert($task);

        $task = new Task();
        $task->userName = 'Jon2';
        $task->email = 'jon2@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository->insert($task);

        $task = new Task();
        $task->userName = 'Jon3';
        $task->email = 'jon3@exmple.com';
        $task->text = 'text1';
        $task->imagePath = '/tmp';
        $task->executed = true;
        $repository->insert($task);

        $totalRecords = $repository->totalRecords();

        $this->assertEquals(3, $totalRecords);
    }

}