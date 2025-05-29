<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReservationController;
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

    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::patch('/admin/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');

    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    Route::get('/settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('admin.reservations');
    Route::patch('/admin/reservations/{reservation}', [ReservationController::class, 'update'])->name('admin.reservations.update');
    Route::post('/admin/services/update-materials', [ServiceController::class, 'updateMaterials'])->name('services.updateMaterials');
    Route::post('/admin/services/update-time-slots', [ServiceController::class, 'updateTimeSlots'])->name('services.updateTimeSlots');
    Route::post('/admin/services/{id}/toggle-availability', [ServiceController::class, 'toggleAvailability'])->name('services.toggleAvailability');
    Route::post('/admin/services/{id}/update-material-prices', [ServiceController::class, 'updateMaterialPrices'])->name('services.updateMaterialPrices');
});