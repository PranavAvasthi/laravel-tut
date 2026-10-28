<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Retrieve tasks
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/pending', [TaskController::class, 'pending']);
Route::get('/tasks/completed', [TaskController::class, 'completed']);

// Create task
Route::post('/tasks', [TaskController::class, 'store']);

// Retrieve a single task
Route::get('/tasks/{id}', [TaskController::class, 'show'])
    ->whereNumber('id');

// Update task
Route::patch('/tasks/{id}', [TaskController::class, 'update'])
    ->whereNumber('id');

// Delete task
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])
    ->whereNumber('id');