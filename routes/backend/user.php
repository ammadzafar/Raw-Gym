<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
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
Route::get('/index', [UserController::class, 'index'])->name('index');
Route::get('/create', [UserController::class, 'create'])->name('create');
Route::post('/store', [UserController::class, 'store'])->name('store');
Route::get('/show/{id}', [UserController::class, 'show'])->name('show');
Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
Route::get("/role",[UserController::class,'getrole'])->name('role');
Route::post('/salary/{id}',[UserController::class,'paySalary'])->name('salary');
Route::get('/history/{id}',[UserController::class,'salaryHistory'])->name('salary.history');
Route::post('/verify/auth', [UserController::class, 'verifyAuth'])->name('verify');
Route::get('/trashed-roles', [UserController::class, 'trashedUsers'])->name('trashed-users');
Route::get('/restore/{id}', [UserController::class, 'restore'])->name('restore');
Route::get('/hard-delete/{id}', [UserController::class, 'hardDelete'])->name('hard-delete');
Route::get('/on-salary-data/{id}', [UserController::class, 'onSalaryData'])->name('onSalaryData');
