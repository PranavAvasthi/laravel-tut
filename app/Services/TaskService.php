<?php

namespace App\Services;

class TaskService
{
    private array $tasks = [
        [
            "id" => 1,
            "title" => "Learn PHP",
            "completed" => true
        ],
        [
            "id" => 2,
            "title" => "Learn Laravel",
            "completed" => false
        ]
    ];

    public function getAllTasks(): array {
        return $this->tasks;
    }

    public function findTask(int $id): ?array {
        foreach($this->tasks as $task) {
            if($task["id"] === $id) {
                return $task;
            }
        }

        return null;
    }

    public function getPendingTasks(): array {
        $pendingTasks = [];

        foreach($this->tasks as $task) {
            if($task["completed"] === false) {
                $pendingTasks[] = $task;
            }
        }

        return $pendingTasks;
    }
}