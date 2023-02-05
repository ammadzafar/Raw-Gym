<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AttributeValueController;

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
Route::get('/index', [AttributeValueController::class, 'index'])->name('index');
Route::post('/store', [AttributeValueController::class, 'store'])->name('store');
Route::get('/show/{id}', [AttributeValueController::class, 'show'])->name('show');
Route::get('/delete/{id}', [AttributeValueController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [AttributeValueController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [AttributeValueController::class, 'update'])->name('update');
Route::get('/status/{id}', [AttributeValueController::class, 'status'])->name('status');
Route::get('/attributes', [AttributeValueController::class, 'getValuesByAttribute']);
