<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');

    // User Management Routes
    Route::get('/users', [AdminUserController::class, 'showUserManagement'])->name('admin.users');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.delete');
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::post('/users/bulk-action', [AdminUserController::class, 'bulkAction'])->name('admin.users.bulk-action');

    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{order}/details', [OrderController::class, 'show'])->name('admin.orders.details');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    Route::get('/settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('admin.reservations');
    Route::patch('/reservations/{reservation}', [ReservationController::class, 'update'])->name('admin.reservations.update');
    Route::post('/services/update-materials', [ServiceController::class, 'updateMaterials'])->name('services.updateMaterials');
    Route::post('/services/update-time-slots', [ServiceController::class, 'updateTimeSlots'])->name('services.updateTimeSlots');
    Route::post('/services/{id}/toggle-availability', [ServiceController::class, 'toggleAvailability'])->name('services.toggleAvailability');
    Route::post('/services/{id}/update-material-prices', [ServiceController::class, 'updateMaterialPrices'])->name('services.updateMaterialPrices');
});