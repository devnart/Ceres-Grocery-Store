<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
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
// Public Routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::get("/products/search/{name}", [ProductController::class,'search']);
Route::get("/products", [ProductController::class,'index']);
Route::get('products/{id}', [ProductController::class,'show']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/products', [ProductController::class,'store']);
    Route::put('/products/{id}',[ProductController::class, 'update']);
    Route::delete('/products/{id}',[ProductController::class, 'destroy']);
});
