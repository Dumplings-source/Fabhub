<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Activity;
use App\Events\OrderStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return Order::with(['service', 'user'])->get();
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:completed,cancelled',
        ]);

        // Store previous status
        $previousStatus = $order->status;
        
        // Update order status
        $order->update(['status' => $validated['status']]);
        
        // Reload the order with relationships before broadcasting
        $order = $order->fresh()->load(['service', 'user']);
        
        // Activity logging removed
        
        // Broadcast the update to the customer
        broadcast(new OrderStatusUpdated($order, $previousStatus))->toOthers();
        
        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order
        ]);
    }
    
    /**
     * Accept an order (change status to processing)
     */
    public function acceptOrder($id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $order = Order::findOrFail($id);
        
        if ($order->status !== 'pending') {
            return response()->json(['error' => 'Order is not in pending state'], 400);
        }
        
        // Store previous status
        $previousStatus = $order->status;
        
        // Update order status
        $order->update(['status' => 'processing']);
        
        // Reload the order with relationships before broadcasting
        $order = $order->fresh()->load(['service', 'user']);
        
        // Activity logging removed
        
        // Broadcast the update to the customer
        broadcast(new OrderStatusUpdated($order, $previousStatus))->toOthers();
        
        return response()->json([
            'message' => 'Order accepted successfully',
            'order' => $order
        ]);
    }
}