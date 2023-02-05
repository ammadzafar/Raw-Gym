<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ConsultationController;
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
Route::get('/index', [ConsultationController::class, 'index'])->name('index');
Route::get('/delete/{id}',[ConsultationController::class,'destroy'])->name('destroy');
Route::get('/detail/{id}',[ConsultationController::class,'detail'])->name('detail');
