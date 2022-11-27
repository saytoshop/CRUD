<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

Route::get('/categories', [CategoryController::class,'index']);
Route::get('/categories/{id}', [CategoryController::class,'show']);
Route::get('/products', [ProductController::class,'index']);
Route::get('/categories/{id}/products', [CategoryController::class,'showProducts']);

Route::post('/categories', [CategoryController::class, 'store']);
Route::post('/categories/{id}', [CategoryController::class, 'update']);


Route::post('/products', [ProductController::class, 'store']);
Route::post('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
