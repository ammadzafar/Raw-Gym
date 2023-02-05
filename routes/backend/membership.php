<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\MembershipController;

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

Route::get('/index', [MembershipController::class, 'index'])->name('index');
Route::get('/create', [MembershipController::class, 'create'])->name('create');
Route::post('/store', [MembershipController::class, 'store'])->name('store');
Route::get('/show/{id}', [MembershipController::class, 'show'])->name('show');
Route::get('/delete/{id}', [MembershipController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [MembershipController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [MembershipController::class, 'update'])->name('update');
Route::get('/status/{id}', [MembershipController::class, 'status'])->name('status');
Route::get('/featured/{id}', [MembershipController::class, 'featured'])->name('featured');
Route::get('/restore/{id}', [MembershipController::class, 'restore'])->name('restore');
Route::get('/hard-delete/{id}', [MembershipController::class, 'hardDelete'])->name('hard-delete');
