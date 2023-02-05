<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AttributeController;

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
Route::get('/index', [AttributeController::class, 'index'])->name('index');
Route::post('/store', [AttributeController::class, 'store'])->name('store');
Route::get('/show/{id}', [AttributeController::class, 'show'])->name('show');
Route::get('/delete/{id}', [AttributeController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [AttributeController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [AttributeController::class, 'update'])->name('update');
Route::get('/status/{id}', [AttributeController::class, 'status'])->name('status');
Route::get('/values', [AttributeController::class, 'getValuesByAttribute'])->name('values');
