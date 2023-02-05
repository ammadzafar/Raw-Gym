<?php
use Illuminate\Support\Facades\Route;

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
Route::get('/index', [\App\Http\Controllers\Backend\GoalController::class, 'index'])->name('index');
Route::post('/store', [\App\Http\Controllers\Backend\GoalController::class, 'store'])->name('store');
Route::get('/delete/{id}', [\App\Http\Controllers\Backend\GoalController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [\App\Http\Controllers\Backend\GoalController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [\App\Http\Controllers\Backend\GoalController::class, 'update'])->name('update');
