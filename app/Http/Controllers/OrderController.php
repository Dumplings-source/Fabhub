<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Activity;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

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

    public function show(Order $order)
    {
        try {
            \Log::info('OrderController@show called for order ID: ' . $order->id);
            
            // Load the related models
            $order->load(['user', 'service']);
            
            // Add file information if file exists
            if ($order->file_path) {
                $fullPath = storage_path('app/public/' . $order->file_path);
                $order->file_exists = file_exists($fullPath);
                $order->file_size = $order->file_exists ? filesize($fullPath) : 0;
                $order->file_name = basename($order->file_path);
                
                // Determine file type
                $extension = strtolower(pathinfo($order->file_path, PATHINFO_EXTENSION));
                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
                $order->is_image = in_array($extension, $imageExtensions);
                
                // Add URL information for debugging
                $order->storage_url = asset('storage/' . $order->file_path);
                $order->direct_url = url('storage/' . $order->file_path);
                
                \Log::info('File info: path=' . $order->file_path . ', exists=' . ($order->file_exists ? 'yes' : 'no') . ', is_image=' . ($order->is_image ? 'yes' : 'no'));
                \Log::info('Full file path: ' . $fullPath);
                \Log::info('Storage URL: ' . $order->storage_url);
                \Log::info('Direct URL: ' . $order->direct_url);
                \Log::info('APP_URL: ' . config('app.url'));
            }
            
            \Log::info('Order loaded successfully with relationships');
            
            return response()->json([
                'success' => true,
                'order' => $order
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch order details for order #' . $order->id . ': ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch order details: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:processing,completed,cancelled',
        ]);

        // Store previous status for comparison
        $previousStatus = $order->status;
        
        $order->update([
            'status' => $validated['status'],
        ]);
        
        // Activity logging removed
        
        // If status has changed, broadcast the event
        if ($previousStatus !== $validated['status']) {
            // Broadcast the update to the customer
            broadcast(new OrderStatusUpdated($order, $previousStatus));
        }

        // Notify the user about the status change
        try {
            $order->user->notify(new \App\Notifications\OrderStatusUpdated($order));
        } catch (\Exception $e) {
            Log::error('Failed to send OrderStatusUpdated notification for order #' . $order->id . ': ' . $e->getMessage());
        }

        return redirect()->route('admin.orders')->with('success', 'Order status updated successfully.');
    }
}
