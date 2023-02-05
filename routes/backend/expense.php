<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ConsultationController;
use App\Http\Controllers\Backend\ExpenseController;

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

Route::get('/report/day/{date}', [ExpenseController::class, 'expenseByDays'])->name('report.day');
Route::get('/index', [ExpenseController::class, 'index'])->name('index');
Route::post('/store', [ExpenseController::class, 'store'])->name('store');
Route::get('/show/{id}', [ExpenseController::class, 'show'])->name('show');
Route::get('/delete/{id}', [ExpenseController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [ExpenseController::class, 'update'])->name('update');





