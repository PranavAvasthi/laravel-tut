<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    // public function index(Request $request): JsonResponse
    // {
    //     return response()->json([
    //         'data' => $this->taskService->getAllTasks(
    //             $request->user()->id
    //         )
    //     ]);
    // }
    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ]);

        $perPage = (int) ($validated['per_page'] ?? 10);

        $tasks = $this->taskService->getPaginatedTasks(
            $request->user()->id,
            $perPage
        );

        return TaskResource::collection(
            $tasks->withQueryString()
        );
    }

    // public function show(Request $request, int $id): JsonResponse
    // {
    //     $task = $this->taskService->findTask(
    //         $request->user()->id,
    //         $id
    //     );

    //     if ($task === null) {
    //         return response()->json([
    //             'message' => 'Task not found'
    //         ], 404);
    //     }

    //     return response()->json(['data' => $task]);
    // }
    public function show(Request $request, int $id): TaskResource
    {
        $task = $this->taskService->findTask(
            $request->user()->id,
            $id
        );

        if ($task === null) {
            abort(404, 'Task not found');
        }

        return new TaskResource($task);
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