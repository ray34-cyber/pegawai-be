<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;

// Mendefinisikan rute untuk resource Task
Route::apiResource('/tasks', TaskController::class);
Route::get('/tasks/{id}/employees', [TaskController::class, 'getEmployees']);
Route::get('/tasks/{task}/employees/{employee}', [EmployeeController::class, 'show']);
Route::put('/tasks/{task}/employees/{employee}', [EmployeeController::class, 'update']);
