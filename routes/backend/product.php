<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ProductController;

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
Route::get('/index', [ProductController::class, 'index'])->name('index');
Route::post('/store', [ProductController::class, 'store'])->name('store');
Route::get('/show/{id}', [ProductController::class, 'show'])->name('show');
Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
Route::get('/status/{id}', [ProductController::class, 'status'])->name('status');
Route::get('/featured/{id}', [ProductController::class, 'featured'])->name('featured');
Route::get('/top/{id}', [ProductController::class, 'top'])->name('top');
