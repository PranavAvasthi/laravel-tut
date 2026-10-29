<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function getAllTasks(int $userId): Collection
    {
        return Task::where('user_id', $userId)->get();
    }

    // public function findTask(int $userId, int $id): ?Task
    // {
    //     return Task::where('user_id', $userId)->find($id);
    // }

    public function findTask(int $userId, int $id): ?Task
    {
        return Task::query()
            ->with('user:id,name')
            ->where('user_id', $userId)
            ->find($id);
    }

    public function getPendingTasks(int $userId): Collection
    {
        return Task::where('user_id', $userId)
            ->where('completed', false)
            ->get();
    }

    public function getCompletedTasks(int $userId): Collection
    {
        return Task::where('user_id', $userId)
            ->where('completed', true)
            ->get();
    }

    public function createTask(int $userId, array $data): Task
    {
        $task = new Task();

        $task->title = $data['title'];
        $task->completed = $data['completed'] ?? false;
        $task->user_id = $userId;

        $task->save();

        return $task;
    }

    private function findOwnedTaskOrFail(
        int $userId,
        int $id
    ): Task {
        return Task::where('user_id', $userId)->findOrFail($id);
    }

    public function updateTask(
        int $userId,
        int $id,
        array $data
    ): Task {
        $task = $this->findOwnedTaskOrFail($userId, $id);

        $task->update($data);

        return $task->refresh();
    }

    public function deleteTask(int $userId, int $id): void
    {
        $task = $this->findOwnedTaskOrFail($userId, $id);

        $task->delete();
    }

    public function reopenTask(int $userId, int $id): Task
    {
        return $this->updateTask($userId, $id, [
            'completed' => false
        ]);
    }

    public function getPaginatedTasks(
        int $userId,
        int $perPage = 10
    ) : LengthAwarePaginator {
        return Task::query()
            ->where('user_id', $userId)
            ->with('user:id,name')
            ->orderByDesc('id')
            ->paginate($perPage);
    }
}