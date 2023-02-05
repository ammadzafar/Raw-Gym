<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AttendanceController;
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
Route::get('/index/{date?}', [AttendanceController::class, 'index'])->name('index');
Route::get('/create', [AttendanceController::class, 'create'])->name('create');
Route::post('/store', [AttendanceController::class, 'store'])->name('store');
Route::get('/show/{id}', [AttendanceController::class, 'show'])->name('show');
Route::get('/delete/{id}', [AttendanceController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [AttendanceController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [AttendanceController::class, 'update'])->name('update');
Route::get('/status/{clock_out}/{id}',[AttendanceController::class,'status'])->name('status');
Route::get('/index/{date?}', [AttendanceController::class, 'index'])->name('index');
