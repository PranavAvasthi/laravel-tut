<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TaskController extends Controller {
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

    public function index() : JsonResponse {
        return response()->json([
            "data" => $this->tasks
        ]);
    }

    public function show(string $id) : JsonResponse {
        foreach($this->tasks as $task) {
            if((string)$task["id"] === $id) {
                return response()->json([
                    "data" => $task
                ]);
            }
        }

        return response()->json([
            "message" => "Task not found"
        ], 404);
    }
}
