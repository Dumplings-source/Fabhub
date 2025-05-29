<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $status = $request->input('status');
        
        // Start with a base query
        $query = Order::with(['user', 'service']);
        
        // Apply status filter if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        // Get the paginated results
        $orders = $query->latest()->paginate($perPage)->appends($request->query());
        
        return view('admin.orders', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        // Notify the user about the status change
        try {
            $order->user->notify(new \App\Notifications\OrderStatusUpdated($order));
        } catch (\Exception $e) {
            Log::error('Failed to send OrderStatusUpdated notification for order #' . $order->id . ': ' . $e->getMessage());
        }

        return redirect()->route('admin.orders')->with('success', 'Order status updated successfully.');
    }
}
