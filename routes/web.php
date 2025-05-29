<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController as Enter;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;

Route::get('/', function () {
    return view('welcome');
});

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/orders', [CustomerDashboardController::class, 'getOrders']);
    Route::get('/order-counts', [CustomerDashboardController::class, 'getOrderCounts']);
    Route::get('/services', [CustomerDashboardController::class, 'getServices']);
    Route::get('/services/{id}', [CustomerDashboardController::class, 'getService']);
    Route::post('/orders', [CustomerDashboardController::class, 'createOrderApi']);
    Route::post('/orders/{id}/cancel', [CustomerDashboardController::class, 'cancelOrder']);
    Route::get('/reservations', [CustomerDashboardController::class, 'getReservations']);
    Route::post('/reservations', [CustomerDashboardController::class, 'createReservation']);
    Route::post('/reservations/{id}/cancel', [CustomerDashboardController::class, 'cancelReservation']);
    Route::get('/notifications', [CustomerDashboardController::class, 'getNotifications']);
    Route::post('/profile', [CustomerDashboardController::class, 'updateProfile']);
    
    // New API controller routes
    Route::get('/orders/counts', [ApiOrderController::class, 'getCounts']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/users', [Enter::class, 'showUserManagement'])->name('admin.users');
    Route::get('/dashboard', [Enter::class, 'showDashboard'])->name('dashboard');
    Route::get('/service-catalog', [CustomerDashboardController::class, 'showServiceCatalog'])->name('service-catalog');
    Route::post('/service-catalog/{service}/order', [CustomerDashboardController::class, 'createOrder'])->name('service-catalog.order');
    Route::post('/admin/users', [Enter::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [Enter::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [Enter::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [Enter::class, 'destroy'])->name('admin.users.delete');
    
    // Customer Recent Orders
    Route::get('/recent-orders', [CustomerDashboardController::class, 'showRecentOrders'])->name('recent-orders');
    
    // Admin Order Management
    Route::get('/admin/orders', function () {
        return view('admin.order-management');
    })->middleware('auth:admin')->name('admin.orders');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
