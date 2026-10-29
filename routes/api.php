<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public authentication endpoints
Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/pending', [TaskController::class, 'pending']);
    Route::get('/tasks/completed', [TaskController::class, 'completed']);

    Route::post('/tasks', [TaskController::class, 'store']);

    Route::get('/tasks/{id}', [TaskController::class, 'show'])
        ->whereNumber('id');

    Route::patch('/tasks/{id}', [TaskController::class, 'update'])
        ->whereNumber('id');

    Route::patch('/tasks/{id}/reopen', [TaskController::class, 'reopen'])
        ->whereNumber('id');

    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])
        ->whereNumber('id');
});