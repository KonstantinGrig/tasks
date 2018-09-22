<?php
/**
 * Created by PhpStorm.
 * User: kostjami
 * Date: 22.09.18
 * Time: 9:19
 */

namespace App\Repository;


use App\Entity\Task;

interface TaskRepositoryInterface
{
    public function insert(Task $task);
    public function findById(int $id);
    public function ordered(string $fieldNameByOrder = 'id', string $direction = 'ASC', int $offset = 0, int $limit = 3);
    public function totalRecords(): int;
    public function update(Task $task);
}