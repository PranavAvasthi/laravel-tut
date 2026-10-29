<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->taskService->getAllTasks(
                $request->user()->id
            )
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $task = $this->taskService->findTask(
            $request->user()->id,
            $id
        );

        if ($task === null) {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }

        return response()->json(['data' => $task]);
    }

    public function pending(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->taskService->getPendingTasks(
                $request->user()->id
            )
        ]);
    }

    public function completed(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->taskService->getCompletedTasks(
                $request->user()->id
            )
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask(
            $request->user()->id,
            $request->validated()
        );

        return response()->json(['data' => $task], 201);
    }

    public function update(
        UpdateTaskRequest $request,
        int $id
    ): JsonResponse {
        $task = $this->taskService->updateTask(
            $request->user()->id,
            $id,
            $request->validated()
        );

        return response()->json(['data' => $task]);
    }

    public function destroy(Request $request, int $id): Response
    {
        $this->taskService->deleteTask(
            $request->user()->id,
            $id
        );

        return response()->noContent();
    }

    public function reopen(Request $request, int $id): JsonResponse
    {
        $task = $this->taskService->reopenTask(
            $request->user()->id,
            $id
        );

        return response()->json(['data' => $task]);
    }
}