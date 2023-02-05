<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\RoleController;
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
Route::get('/index', [RoleController::class, 'index'])->name('index');
Route::get('/create', [RoleController::class, 'create'])->name('create');
Route::post('/store', [RoleController::class, 'store'])->name('store');
Route::get('/show/{id}', [RoleController::class, 'show'])->name('show');
Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('delete');
Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
Route::get('/trashed-roles', [RoleController::class, 'trashedRoles'])->name('trashed-roles');
Route::get('/restore/{id}', [RoleController::class, 'restore'])->name('restore');
Route::get('/hard-delete/{id}', [RoleController::class, 'hardDelete'])->name('hard-delete');
