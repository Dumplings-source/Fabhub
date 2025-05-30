<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Service;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Admin methods
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $reservations = Reservation::with(['service', 'user'])->orderBy('created_at', 'desc')->get();
        $services = Service::all(); // For the sidebar "Manage Materials" form

        return view('admin.reservations', compact('reservations', 'services'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $reservation->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.reservations')->with('success', 'Reservation status updated successfully');
    }

    // Customer methods
    public function customerIndex(Request $request)
    {
        $reservations = Reservation::with(['service'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // If it's an AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'reservations' => $reservations
            ]);
        }

        // Otherwise, return the view
        return view('reservations');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'reservation_date' => 'required|date|after:today',
            'time_slot' => 'required|string',
            'notes' => 'nullable|string|max:1000',
            'contact_info' => 'required|string|max:255',
        ]);

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'reservation_date' => $validated['reservation_date'],
            'time_slot' => $validated['time_slot'],
            'notes' => $validated['notes'],
            'contact_info' => $validated['contact_info'],
            'status' => 'pending',
        ]);

        $reservation->load(['service', 'user']);

        return response()->json([
            'message' => 'Reservation created successfully!',
            'reservation' => $reservation
        ]);
    }

    public function cancel($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($reservation->status === 'confirmed') {
            return response()->json([
                'error' => 'Cannot cancel a confirmed reservation. Please contact admin.'
            ], 400);
        }

        $reservation->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Reservation cancelled successfully'
        ]);
    }

    public function getAvailableTimeSlots(Request $request)
    {
        $serviceId = $request->query('service_id');
        $date = $request->query('date');

        if (!$serviceId || !$date) {
            return response()->json(['error' => 'Service ID and date are required'], 400);
        }

        $timeSlots = TimeSlot::where('service_id', $serviceId)
            ->where('is_available', true)
            ->get();

        return response()->json([
            'time_slots' => $timeSlots
        ]);
    }
}