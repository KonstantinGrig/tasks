<?php


namespace App\Repository;


use App\Config\Config;
use App\Entity\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function insert(Task $task)
    {
        $db = Config::getDb();
        $insert = "INSERT INTO task (userName, email, text, imagePath, executed) 
                VALUES (:userName, :email, :text, :imagePath, :executed)";
        $stmt = $db->prepare($insert);
        $userName = $task->userName;
        $email = $task->email;
        $text = $task->text;
        $imagePath = $task->imagePath;
        $executed = $task->executed;
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->bindParam(':executed', $executed);
        $stmt->execute();
    }

    public function findById(int $id)
    {
        $db = Config::getDb();
        $sql = 'SELECT * FROM task WHERE id = ?';
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $task = $stmt->fetchObject(Task::class);
        if ($task === false) {
            return null;
        }
        return $task;
    }

    public function ordered(string $fieldNameByOrder = 'id', string $direction = 'ASC', int $offset = 0, int $limit = 3)
    {
        $db = Config::getDb();
        $sql = "SELECT * FROM task ORDER BY $fieldNameByOrder $direction LIMIT $limit OFFSET $offset";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $task = $stmt->fetchAll(\PDO::FETCH_CLASS, Task::class);
        return $task;
    }

    public function totalRecords(): int
    {
        $db = Config::getDb();
        $sql = "SELECT count(id) as totalRecords FROM task";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return (int)$result['totalRecords'];
    }

    public function update(Task $task)
    {
        $db = Config::getDb();
        $updateSql = "UPDATE task SET text = :text, executed = :executed WHERE id = :id";
        $stmt = $db->prepare($updateSql);
        $text = $task->text;
        $executed = $task->executed;
        $id = $task->id;
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':executed', $executed);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}