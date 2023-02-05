<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BrandController;

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

Route::get('/', [\App\Http\Controllers\Backend\DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/report/income-expense/day/{date}', [\App\Http\Controllers\Backend\DashboardController::class, 'incomeExpenseDay'])->name('dashboard.report.income-expense.day');
Route::get('/report/income-expense/current-week', [\App\Http\Controllers\Backend\DashboardController::class, 'incomeExpenseWeek'])->name('dashboard.report.income-expense.week');
Route::get('/report/income-expense/month/{month}', [\App\Http\Controllers\Backend\DashboardController::class, 'incomeExpenseMonth'])->name('dashboard.report.income-expense.month');
Route::get('/report/income-expense/year/{year}', [\App\Http\Controllers\Backend\DashboardController::class, 'incomeExpenseYear'])->name('dashboard.report.income-expense.year');

Route::get('/income-expense', [\App\Http\Controllers\Backend\DashboardController::class, 'dashboardIncomeExpenseView'])->name('dashboard.income-expense-view');

//Route::get('/employee', [\App\Http\Controllers\Backend\DashboardController::class,'dashboardEmployee'])->name('employee');
Route::get('/members', [\App\Http\Controllers\Backend\DashboardController::class, 'dashboardMembersView'])->name('dashboard.members-view');
Route::post('/attendance/mark', [\App\Http\Controllers\Backend\DashboardController::class, 'markAttendance'])->name('dashboard.markAttendance');
Route::get('/report', [\App\Http\Controllers\Backend\DashboardController::class, 'report'])->name('dashboard.report');
Route::get('/report/attendance/percentage', [\App\Http\Controllers\Backend\DashboardController::class, 'attendancePercentage'])->name('dashboard.report.attendance.percentage');
Route::get('/payments/report', [\App\Http\Controllers\Backend\DashboardController::class, 'paymentsReport'])->name('dashboard.payments.report');
Route::get('/autocomplete-search', [\App\Http\Controllers\Backend\DashboardController::class, 'autocompleteSearch'])->name('dashboard.autocomplete-search');

Route::get('/expense/report', [\App\Http\Controllers\Backend\DashboardController::class, 'expenseReport'])->name('dashboard.expense.report');
Route::get('/daily/expense', [\App\Http\Controllers\Backend\DashboardController::class, 'dailyExpenditure'])->name('dashboard.daily.expenditure');
Route::get('/member/report', [\App\Http\Controllers\Backend\DashboardController::class, 'memberReport'])->name('dashboard.member.report');
Route::get('/membership-types/report', [\App\Http\Controllers\Backend\DashboardController::class, 'membershipTypeReport'])->name('dashboard.membership.type.report');
Route::get('/expense/income/report', [\App\Http\Controllers\Backend\DashboardController::class, 'expenseIncomeReport'])->name('dashboard.expense.income.report');
Route::get('/member/hours/spent', [\App\Http\Controllers\Backend\DashboardController::class, 'hoursSpentReport'])->name('dashboard.member.hours.spent');
