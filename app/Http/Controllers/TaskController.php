<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ){}

    public function index(): JsonResponse
    {
        return response()->json([
            "data" => $this->taskService->getAllTasks()
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->findTask($id);

        if($task === null) {
            return response()->json([
                "message" => "Task not found"
            ], 404);
        }

        return response()->json([
            "data" => $task
        ]);
    }

    public function pending(): JsonResponse
    {
        return response()->json([
            "data" => $this->taskService->getPendingTasks()
        ]);
    }

    public function completed(): JsonResponse
    {
        return response()->json([
            "data" => $this->taskService->getCompletedTasks()
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $request->validated();

        $task = $this->taskService->createTask($data);

        return response()->json([
            "data" => $task
        ], 201);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $task = $this->taskService->updateTask($id, $data);

        return response()->json([
            'data' => $task,
        ]);
    }
}
