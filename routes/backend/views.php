<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PageController;
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

Route::get('/members', [PageController::class, 'members'])->name('members');
Route::get('/users', [PageController::class, 'users'])->name('users');
Route::get('/roles', [PageController::class, 'roles'])->name('roles');
Route::get('/memberships', [PageController::class, 'memberships'])->name('memberships');
Route::get('/attendances/days', [PageController::class, 'attendancesByDays'])->name('attendances.days');
Route::get('/attendances/months', [PageController::class, 'attendancesByMonths'])->name('attendances.months');
Route::get('/attendances/months/{month?}', [PageController::class, 'attendancesBySingleMonths'])->name('attendances.singlemonths');

Route::get('/attendances/{date?}', [PageController::class, 'attendances'])->name('attendances');
Route::get('/profile', [PageController::class, 'userProfile'])->name('profile');
Route::get('/newsletters', [PageController::class, 'newsletter'])->name('newsletters');
Route::get('consultation', [PageController::class, 'consultation'])->name('consultations');
Route::get('expense', [PageController::class, 'expense'])->name('expenses');
Route::get('/welcome', [PageController::class, 'welcome'])->name('welcome');
Route::get('/tags', [PageController::class, 'tags'])->name('tags');
Route::get('/brands', [PageController::class, 'brands'])->name('brands');
Route::get('/user/attendance', [PageController::class, 'attendancesInDays'])->name('userAttendances');
Route::get('/userattendances/{date?}', [PageController::class, 'userAttendance'])->name('attendancesbydates');
Route::get('/categories', [PageController::class, 'category'])->name('categories');
Route::get('/attributes', [PageController::class, 'attribute'])->name('attributes');
Route::get('/values', [PageController::class, 'value'])->name('values');
Route::get('/product/create', [PageController::class, 'addProduct'])->name('product.create');
Route::get('/listProducts', [PageController::class, 'listProduct'])->name('listProducts');
Route::get('/products', [PageController::class, 'product'])->name('products');
Route::get('/lockers', [PageController::class, 'lockers'])->name('lockers');
Route::get('/memberships/trashed', [PageController::class, 'trashedMemberships'])->name('memberships.trashed');
Route::get('/roles/trashed', [PageController::class, 'trashedRoles'])->name('roles.trashed');
Route::get('/users/trashed', [PageController::class, 'trashedUsers'])->name('users.trashed');
Route::get('/members/trashed', [PageController::class, 'trashedMembers'])->name('members.trashed');
Route::get('/goals', [PageController::class, 'goals'])->name('goals');
Route::get('/orders', [PageController::class, 'orders'])->name('orders');
Route::get('/classes', [PageController::class, 'classes'])->name('classes');

Route::get('/expense/category', [PageController::class, 'expenseCategory'])->name('expense.category.index');
Route::post('/expense/category/store', [PageController::class, 'expenseCategoryStore'])->name('expense.category.store');
Route::get('/expense/category/edit', [PageController::class, 'expenseCategoryEdit'])->name('expense.category.edit');
Route::post('/expense/category/update', [PageController::class, 'expenseCategoryUpdate'])->name('expense.category.update');
Route::delete('/expense/category/delete', [PageController::class, 'expenseCategoryDelete'])->name('expense.category.delete');

Route::get('/financial/report', [PageController::class, 'financialReport'])->name('financialReport');
Route::get('/attendance/record', [PageController::class, 'attendanceRecord'])->name('attendanceRecord');
