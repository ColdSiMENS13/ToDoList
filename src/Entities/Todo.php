<?php

namespace App\Entities;
class Todo implements \JsonSerializable
{
    private $id;
    private $task;

    public function __construct($id, $task)
    {
        $this->id = $id;
        $this->task = $task;
    }

    public function jsonSerialize(): array
    {
        return [$this->id, $this->task];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTask()
    {
        return $this->task;
    }
}
