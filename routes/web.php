<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('home');

Route::get('/admin/{name?}', [AdminController::class, 'index'])->where('name', '[A-Za-z]+')->name('admin');

Route::post('/admin/create', [AdminController::class, 'create']);
Route::get('/import-status/{filename}', [AdminController::class, 'status']);
// Auth::routes();
