<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ActivityController;

// Debugging route to check API availability
Route::get('/status', function() {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});

// Test route for debugging order counts
Route::get('/test-order-counts', function() {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['error' => 'Not authenticated', 'user' => null]);
    }
    
    $userId = $user->id;
    $pending = \App\Models\Order::where('user_id', $userId)->where('status', 'pending')->count();
    $processing = \App\Models\Order::where('user_id', $userId)->where('status', 'processing')->count();
    $completed = \App\Models\Order::where('user_id', $userId)->where('status', 'completed')->count();
    
    return response()->json([
        'user_id' => $userId,
        'user_name' => $user->name,
        'user_email' => $user->email,
        'counts' => [
            'active' => $processing,
            'completed' => $completed,
            'pending' => $pending
        ],
        'all_orders_count' => \App\Models\Order::count(),
        'all_orders_for_user' => \App\Models\Order::where('user_id', $userId)->count()
    ]);
});

// Fallback activity for guaranteed access
Route::get('/fallback-activity', function() {
    return response()->json([
        [
            'id' => 0,
            'user_id' => 0,
            'type' => 'welcome',
            'message' => 'Welcome to FabHub!',
            'data' => ['details' => 'Explore our fabrication services and place your first order.'],
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString()
        ]
    ]);
});

// Public API routes (no auth required)
Route::get('/services', [CustomerDashboardController::class, 'getServices']);
Route::get('/services/{id}', [CustomerDashboardController::class, 'getService']);

// Customer API routes (require web session authentication)
Route::middleware('auth:web')->group(function () {
    Route::get('/orders', [CustomerDashboardController::class, 'getOrders']);
    Route::get('/order-counts', [CustomerDashboardController::class, 'getOrderCounts']);
    Route::get('/orders/counts', [CustomerDashboardController::class, 'getOrderCounts']); // Alternative endpoint
    Route::post('/orders', [CustomerDashboardController::class, 'createOrder']);
    Route::post('/orders/{id}/cancel', [CustomerDashboardController::class, 'cancelOrder']);
    Route::get('/reservations', [CustomerDashboardController::class, 'getReservations']);
    Route::post('/reservations', [CustomerDashboardController::class, 'createReservation']);
    Route::post('/reservations/{id}/cancel', [CustomerDashboardController::class, 'cancelReservation']);
    Route::get('/notifications', [CustomerDashboardController::class, 'getNotifications']);
    Route::post('/profile', [CustomerDashboardController::class, 'updateProfile']);
    Route::get('/activities', [ActivityController::class, 'index']);
    Route::post('/activities', [ActivityController::class, 'store']);
});

// Admin API routes (protected by auth:sanctum for token-based access)
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/users', [AdminUserController::class, 'store']);
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::post('/orders/{id}/accept', [AdminOrderController::class, 'acceptOrder']);
});

Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working']);
});