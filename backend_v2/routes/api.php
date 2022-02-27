<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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
Route::post('/login', [AuthController::class,'login'])->name('login');
Route::get("/products/search/{name}", [ProductController::class,'search']);
Route::get('products/{id}', [ProductController::class,'show']);
Route::get('/products', [ProductController::class,'index']);

Route::get('/admin', function() {
    return 'Hi there, this is an admin page';
})->name('admin');



// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/checkout', [OrdersController::class,'store']);
    Route::get('/orders/{id}', [OrdersController::class,'show']);
    Route::delete('/orders/{id}', [OrdersController::class,'destroy']);
    Route::get('/orders/user/{id}', [OrdersController::class,'getOrdersByUserId']);
    // Admin routes
    Route::group(['middleware' => ['admin']], function () {

        Route::get('/users', [UserController::class,'index']);
        Route::get('/orders', [OrdersController::class,'index']);
        Route::post('/products', [ProductController::class,'store']);
        Route::put('/products/{id}',[ProductController::class, 'update']);
        Route::delete('/products/{id}',[ProductController::class, 'destroy']);

    });
});
