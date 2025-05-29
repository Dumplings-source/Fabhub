<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Get all orders for the authenticated user
     */
    public function index()
    {
        $orders = Order::with(['service'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    /**
     * Get counts of orders by status
     */
    public function getCounts()
    {
        $userId = Auth::id();
        
        // Get counts directly from the database for better performance
        $pending = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();
            
        $processing = Order::where('user_id', $userId)
            ->where('status', 'processing')
            ->count();
            
        $completed = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();
        
        return response()->json([
            'active' => $processing,
            'completed' => $completed,
            'pending' => $pending
        ]);
    }
} 