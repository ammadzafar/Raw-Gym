<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ClassesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/index', [ClassesController::class, 'index'])->name('index');
Route::get('/create', [ClassesController::class, 'create'])->name('create');
Route::post('/store', [ClassesController::class, 'store'])->name('store');
Route::get('/show/{id}', [ClassesController::class, 'show'])->name('show');
Route::get('/delete/{id}', [ClassesController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [ClassesController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [ClassesController::class, 'update'])->name('update');

