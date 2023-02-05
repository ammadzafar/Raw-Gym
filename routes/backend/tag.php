<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\TagController;

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
Route::get('/index', [TagController::class, 'index'])->name('index');
Route::get('/create', [TagController::class, 'create'])->name('create');
Route::post('/store', [TagController::class, 'store'])->name('store');
Route::get('/show/{id}', [TagController::class, 'show'])->name('show');
Route::get('/delete/{id}', [TagController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [TagController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [TagController::class, 'update'])->name('update');
Route::get('/status/{id}', [TagController::class, 'status'])->name('status');

