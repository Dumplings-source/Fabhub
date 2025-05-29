<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $reservations = Reservation::with('service')->get();
        $services = Service::all(); // For the sidebar "Manage Materials" form

        return view('admin.reservations', compact('reservations', 'services'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $reservation->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.reservations')->with('success', 'Reservation status updated successfully');
    }
}