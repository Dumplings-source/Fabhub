<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController as Enter;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\ServiceController as ApiServiceController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Changed from AdminUserController to CustomerDashboardController for regular users
    Route::get('/dashboard', [CustomerDashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/service-catalog', [CustomerDashboardController::class, 'showServiceCatalog'])->name('service-catalog');
    Route::post('/service-catalog/{service}/order', [CustomerDashboardController::class, 'createOrder'])->name('service-catalog.order');
    
    // Customer Recent Orders
    Route::get('/recent-orders', [CustomerDashboardController::class, 'showRecentOrders'])->name('recent-orders');

    // Customer Reservations
    Route::get('/reservations', [ReservationController::class, 'customerIndex'])->name('customer.reservations');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('customer.reservations.store');
    Route::patch('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('customer.reservations.cancel');
    Route::get('/reservations/time-slots', [ReservationController::class, 'getAvailableTimeSlots'])->name('customer.reservations.time-slots');

    // API Routes for AJAX calls
    Route::get('/api/services', [ApiServiceController::class, 'index']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin-auth.php';
