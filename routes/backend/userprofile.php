<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserProfileController;

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
Route::get('/index', [UserProfileController::class, 'index'])->name('index');
Route::get('/create', [UserProfileController::class, 'create'])->name('create');
Route::post('/store', [UserProfileController::class, 'store'])->name('store');
Route::get('/show/{id}', [UserProfileController::class, 'show'])->name('show');
Route::get('/delete/{id}', [UserProfileController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [UserProfileController::class, 'edit'])->name('edit');
Route::post('/update', [UserProfileController::class, 'update'])->name('update');
Route::post("/resetpassword", [UserProfileController::class, 'resetPassword'])->name('resetpassword');
