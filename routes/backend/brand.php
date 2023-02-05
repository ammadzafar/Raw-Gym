<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BrandController;

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
Route::get('/index', [BrandController::class, 'index'])->name('index');
Route::get('/create', [BrandController::class, 'create'])->name('create');
Route::post('/store', [BrandController::class, 'store'])->name('store');
Route::get('/show/{id}', [BrandController::class, 'show'])->name('show');
Route::get('/delete/{id}', [BrandController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [BrandController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [BrandController::class, 'update'])->name('update');
Route::get('/status/{id}', [BrandController::class, 'status'])->name('status');

