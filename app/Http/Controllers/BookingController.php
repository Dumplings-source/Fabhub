<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $bookings = Booking::all();
        return view('bookings.index', compact('bookings'));
    }
}