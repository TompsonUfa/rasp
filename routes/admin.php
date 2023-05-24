<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\CategoriesController;

Route::post('/create', [AdminController::class, 'create']);

Route::get('/{name?}', [AdminController::class, 'index'])->where('name', '[A-Za-z]+')->name('admin');

Route::get('/import-status/{filename}', [AdminController::class, 'status']);

Route::get('/data/groups', [GroupsController::class, 'show']);
Route::post('/data/groups/delete', [GroupsController::class, 'delete']);
Route::post('/data/groups/edit', [GroupsController::class, 'edit']);

Route::get('/data/teachers', [TeachersController::class, 'show']);
Route::post('/data/teachers/delete', [TeachersController::class, 'delete']);
Route::post('/data/teachers/edit', [TeachersController::class, 'edit']);

Route::get('/data/categories', [CategoriesController::class, 'show']);
Route::post('/data/categories/delete', [CategoriesController::class, 'delete']);
Route::post('/data/categories/edit', [CategoriesController::class, 'edit']);
