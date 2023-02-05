<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/index', [\App\Http\Controllers\Backend\MemberController::class, 'index'])->name('index');
Route::get('/create', [\App\Http\Controllers\Backend\MemberController::class, 'create'])->name('create');
Route::post('/store', [\App\Http\Controllers\Backend\MemberController::class, 'store'])->name('store');
Route::get('/show/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'show'])->name('show');
Route::get('/delete/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'update'])->name('update');
Route::get('/status/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'status'])->name('status');
Route::post('/payment/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'makePayment'])->name('payment');
Route::get('/payment/history/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'edit'])->name('payment.history');
Route::get('/payment/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'getPayment'])->name('getPayment');
Route::post('/pending/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'getPending'])->name('getPending');
Route::get('/restore/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'restore'])->name('restore');
Route::get('/hard-delete/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'hardDelete'])->name('hard-delete');
Route::post('/classes/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'classes'])->name('classes');
Route::get('/classes/edit/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'editClass'])->name('editClass');
Route::post('/classes/update/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'updateClass'])->name('updateClass');
Route::post('/classes/payment/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'makeClassesPayment'])->name('classesPayment');
Route::delete('/payment/delete/{id}', [\App\Http\Controllers\Backend\MemberController::class, 'deletePayment'])->name('deletePayment');
//Route::get('/financial/report', [\App\Http\Controllers\Backend\MemberController::class, 'financialReport'])->name('financialReport');




