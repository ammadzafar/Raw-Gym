<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\LockerController;
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

Route::get('/index', [LockerController::class, 'index'])->name('index');
Route::get('/create', [LockerController::class, 'create'])->name('create');
Route::post('/store', [LockerController::class, 'store'])->name('store');
Route::get('/show/{id}', [LockerController::class, 'show'])->name('show');
Route::get('/delete/{id}', [LockerController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [LockerController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [LockerController::class, 'update'])->name('update');
?>
