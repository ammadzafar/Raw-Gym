<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserAttendanceController;
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
Route::get('/index/{date?}', [UserAttendanceController::class, 'index'])->name('index');
Route::get('/create', [UserAttendanceController::class, 'create'])->name('create');
Route::post('/store', [UserAttendanceController::class, 'store'])->name('store');
Route::get('/show/{id}', [UserAttendanceController::class, 'show'])->name('show');
Route::get('/delete/{id}', [UserAttendanceController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [UserAttendanceController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [UserAttendanceController::class, 'update'])->name('update');
Route::post('/status/{id}',[UserAttendanceController::class,'status'])->name('status');
Route::get('/approval/{id}',[UserAttendanceController::class,'approval'])->name('approval');
Route::post('/bulkapproval',[UserAttendanceController::class,'bulkapproval'])->name('bulkapproval');
