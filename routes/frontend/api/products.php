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

Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('/product/variant/{id}', [\App\Http\Controllers\Api\ProductController::class, 'getVariant']);
Route::get('/product/{id}', [\App\Http\Controllers\Api\ProductController::class, 'get']);
Route::get('/products/search', [\App\Http\Controllers\Api\ProductController::class, 'search']);
Route::get('/products/category/{category_slug}', [\App\Http\Controllers\Api\ProductController::class, 'searchByCategory']);
Route::get('/products/sub-category/{category_slug}', [\App\Http\Controllers\Api\ProductController::class, 'searchBySubCategory']);
Route::get('/products/featured', [\App\Http\Controllers\Api\ProductController::class, 'featured']);
Route::get('/products/top', [\App\Http\Controllers\Api\ProductController::class, 'top']);
