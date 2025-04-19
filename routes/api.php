<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:api')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);


    // Project Route

    Route::get('/projects/', [ProjectController::class, 'index']);
    Route::post('/projects/create', [ProjectController::class, 'create']);
    Route::put('/projects/edit/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/delete/{id}', [ProjectController::class, 'destroy']);


    // Task
    Route::get('/task/{id}', [TaskController::class, 'show']);
    Route::post('/task/create', [TaskController::class, 'create']);
    Route::put('/task/edit/{id}', [TaskController::class, 'update']);
    Route::delete('/task/delete/{id}', [TaskController::class, 'destroy']);

    // Task remarks

    Route::get('/task/remarks/{id}', [TaskController::class, 'remark_show']);
    Route::post('/task/remark/create', [TaskController::class, 'remark_create']);
    Route::put('/task/remark/edit/{id}', [TaskController::class, 'remark_update']);
    Route::delete('/task/remark/delete/{id}', [TaskController::class, 'remark_destroy']);

    // Report
    Route::get('/projects/{id}/report', [ProjectController::class, 'report']);







});
