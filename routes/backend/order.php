<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\OrderController;
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

Route::get('/index', [OrderController::class, 'index'])->name('index');
Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
Route::get('/delete/{id}', [OrderController::class, 'destroy'])->name('delete');
Route::get('/status/{id}/{status}', [OrderController::class, 'status'])->name('status');
