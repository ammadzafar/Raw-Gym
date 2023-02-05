<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/wishlist/{customer_id}', [\App\Http\Controllers\Api\WishlistController::class, 'wishlist']);
Route::post('/wishlist/add', [\App\Http\Controllers\Api\WishlistController::class, 'add']);
Route::post('/wishlist/remove', [\App\Http\Controllers\Api\WishlistController::class, 'remove']);
