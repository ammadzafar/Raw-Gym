<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\NewsletterController;
use App\Http\Controllers\Backend\ConsultationController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);
Route::get('logout', 'QovexController@logout')->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/clear', function () {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        return redirect()->back();
    });
});

Route::post('reset/password',[\App\Http\Controllers\Backend\ForgotPasswordController::class,'forgotPassword'])->name('forgot-password');
Route::get('reset/password/{token}',[\App\Http\Controllers\Auth\ResetPasswordController::class,'showResetForm'])->name('reset-password');
Route::post('password/update',[\App\Http\Controllers\Backend\ForgotPasswordController::class,'updatePassword'])->name('update-password');

//Route::get('/frontend/{any}', function ($any) {
//    return view('frontend.' . $any);
//});

Route::post('/newletter',[NewsletterController::class,'store'])->name('newsletter');
Route::post('/consultation',[ConsultationController::class,'store'])->name('consultation');
Route::get('/email',function (){
    return view('backend.email.welcomeEmail');
});

Route::get('/birthday',function (){
    return view('backend.email.birthdayEmail');
});
