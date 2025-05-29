<?php
namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        return response()->json(['bookings' => Reservation::with(['user', 'service'])->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'reservation_date' => 'required|date',
            'time_slot' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|string'
        ]);
        $booking = Reservation::create($validated);
        return response()->json(['booking' => $booking]);
    }
}



