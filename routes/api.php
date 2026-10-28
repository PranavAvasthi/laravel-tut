<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/pending', [TaskController::class, 'pending']);
Route::get('/tasks/completed', [TaskController::class, 'completed']);
Route::get('/tasks/{id}', [TaskController::class, 'show'])
    ->whereNumber('id');