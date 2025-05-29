<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerDashboardController extends Controller
{
    public function showDashboard()
    {
        return view('dashboard');
    }

    public function showServiceCatalog(Request $request)
    {
        $perPage = $request->input('per_page', 6);
        $services = Service::paginate($perPage);
        
        // Load time slots for each service
        foreach ($services as $service) {
            $service->availableTimeSlots = $service->timeSlots()->where('is_available', true)->get();
        }
        
        return view('service-catalog', compact('services'));
    }

    public function createOrder(Request $request, $serviceId)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'material' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'preferred_date' => 'required|date|after:today',
            'time_slot' => 'required|string',
            'file' => 'required|file|max:10240', // Allow any file type, max 10MB
            'notes' => 'nullable|string',
        ]);

        // Store the file
        $filePath = $request->file('file')->store('order-files', 'public');

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'material' => $validated['material'],
            'quantity' => $validated['quantity'],
            'preferred_date' => $validated['preferred_date'],
            'time_slot' => $validated['time_slot'],
            'status' => 'pending',
            'file_path' => $filePath,
            'notes' => $request->input('notes', ''), // Optional notes field
        ]);

        // Notify admin about new order
        try {
            $admin = \App\Models\Admin::first();
            if ($admin) {
                $admin->notify(new \App\Notifications\NewOrderPlaced($order));
            } else {
                Log::warning('No admin found to notify for order #' . $order->id);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send NewOrderPlaced notification for order #' . $order->id . ': ' . $e->getMessage());
        }

        // Broadcast the new order event
        event(new \App\Events\NewOrderRequested($order));

        // Redirect to the recent orders page
        return redirect()->route('recent-orders')
            ->with('success', 'Order request submitted successfully! You can track your order status here.');
    }

    // Existing API methods (kept for backward compatibility)
    public function getServices(Request $request)
    {
        $perPage = $request->input('per_page', 6);
        $services = Service::paginate($perPage);
        return response()->json([
            'data' => $services->items(),
            'pagination' => [
                'current_page' => $services->currentPage(),
                'total_pages' => $services->lastPage(),
                'total_items' => $services->total(),
            ],
        ]);
    }

    public function getService($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function getOrders()
    {
        $orders = Order::with(['service'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    public function createOrderApi(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'material' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'preferred_date' => 'required|date|after:today',
            'file' => 'required|file|max:10240',
            'notes' => 'nullable|string',
        ]);

        $filePath = $request->file('file')->store('order-files', 'public');

        $order = Order::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'material' => $validated['material'],
            'quantity' => $validated['quantity'],
            'preferred_date' => $validated['preferred_date'],
            'status' => 'pending',
            'file_path' => $filePath,
            'notes' => $validated['notes'] ?? '', // Use empty string if notes is not provided
        ]);

        try {
            $admin = \App\Models\Admin::first();
            if ($admin) {
                $admin->notify(new \App\Notifications\NewOrderPlaced($order));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send NewOrderPlaced notification for order #' . $order->id . ': ' . $e->getMessage());
        }

        // Broadcast the new order event
        event(new \App\Events\NewOrderRequested($order));

        // Load the service relation to return full details
        $order->load(['service', 'user']);

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order
        ]);
    }

    public function cancelOrder($id) { return response()->json([]); }
    public function getReservations() { return response()->json([]); }
    public function createReservation(Request $request) { return response()->json([]); }
    public function cancelReservation($id) { return response()->json([]); }
    public function getNotifications() { return response()->json([]); }
    public function updateProfile(Request $request) { return response()->json([]); }

    public function showRecentOrders()
    {
        $orders = Order::with(['service'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('recent-orders', compact('orders'));
    }
}
