<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeachersController;
use App\Http\Controllers\Api\GroupsController;
use App\Http\Controllers\Api\SchedulesController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('groups', GroupsController::class);
Route::apiResource('teachers', TeachersController::class);
Route::apiResource('schedules', SchedulesController::class);
