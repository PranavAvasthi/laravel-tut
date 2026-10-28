<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function getAllTasks(): Collection
    {
        return Task::all();
    }

    public function findTask(int $id): ?Task
    {
        return Task::find($id);
    }

    public function getPendingTasks(): Collection
    {
        return Task::where('completed', false)->get();
    }

    public function getCompletedTasks(): Collection
    {
        return Task::where('completed', true)->get();
    }

    public function createTask(array $data): Task
    {
        return Task::create([
            'title' => $data['title'],
            'completed' => $data['completed'] ?? false
        ]);
    }

    public function updateTask(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);

        $task->update($data);

        return $task->refresh();
    }

    public function deleteTask(int $id): void
    {
        $task = Task::findOrFail($id);

        $task->delete();
    }
}