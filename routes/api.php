<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminUserController;

// Public API routes for customers
Route::get('/services', [CustomerDashboardController::class, 'getServices']);
Route::get('/services/{id}', [CustomerDashboardController::class, 'getService']);
Route::get('/orders', [CustomerDashboardController::class, 'getOrders']);
Route::post('/orders', [CustomerDashboardController::class, 'createOrder']);
Route::post('/orders/{id}/cancel', [CustomerDashboardController::class, 'cancelOrder']);
Route::get('/reservations', [CustomerDashboardController::class, 'getReservations']);
Route::post('/reservations', [CustomerDashboardController::class, 'createReservation']);
Route::post('/reservations/{id}/cancel', [CustomerDashboardController::class, 'cancelReservation']);
Route::get('/notifications', [CustomerDashboardController::class, 'getNotifications']);
Route::post('/profile', [CustomerDashboardController::class, 'updateProfile']);

// Admin API routes (protected by auth:sanctum)
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/users', [AdminUserController::class, 'store']);
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::patch('/orders/{id}', [AdminOrderController::class, 'update']);
    Route::post('/orders/{id}/accept', [AdminOrderController::class, 'acceptOrder']);
});

Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working!']);
});