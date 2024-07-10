<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::post('/product', [ProductController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::post('/payments', [PaymentController::class, 'processPayment']);
});

Route::get("/test-me", function () {
    return 'Hello from Laravel!';
});