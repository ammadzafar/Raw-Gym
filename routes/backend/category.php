<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;

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
Route::get('/index', [CategoryController::class, 'index'])->name('index');
Route::post('/store', [CategoryController::class, 'store'])->name('store');
Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
Route::post('/category', [CategoryController::class, 'getCategories'])->name('category');
Route::get('/status/{id}', [CategoryController::class, 'status'])->name('status');
Route::get('/change/{id}', [CategoryController::class, 'change'])->name('change');
