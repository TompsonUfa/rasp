<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CategoryController;

Route::post('/create', [AdminController::class, 'create']);

Route::get('/{name?}', [AdminController::class, 'index'])->where('name', '[A-Za-z]+')->name('admin');

Route::get('/import-status/{filename}', [AdminController::class, 'status']);

Route::get('/data/groups', [GroupController::class, 'show']);
Route::post('/data/groups/delete', [GroupController::class, 'delete']);
Route::post('/data/groups/edit', [GroupController::class, 'edit']);

Route::get('/data/teachers', [TeacherController::class, 'show']);
Route::post('/data/teachers/delete', [TeacherController::class, 'delete']);
Route::post('/data/teachers/edit', [TeacherController::class, 'edit']);

Route::get('/data/categories', [CategoryController::class, 'show']);
Route::post('/data/categories/delete', [CategoryController::class, 'delete']);
Route::post('/data/categories/edit', [CategoryController::class, 'edit']);
