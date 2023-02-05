<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RegisterLogController;
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
Route::get('/index/{id}', [RegisterLogController::class, 'index'])->name('index');
Route::post('store/{id}',[RegisterLogController::class,'store'])->name('store');
