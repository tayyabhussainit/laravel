<?php

use App\Http\Controllers\api\AttributeController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ProjectController;
use App\Http\Controllers\api\TimesheetController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/logout', [AuthController::class, 'logout']);


Route::middleware('auth:api')->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('timesheets', TimesheetController::class);
    Route::apiResource('attributes', AttributeController::class);
    Route::post('/projects/{project}/attributes', [ProjectController::class, 'setAttributes']);
    Route::get('/projects', [ProjectController::class, 'filterProjects']);

});
