<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function general()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        return view('settings.general');
    }
}