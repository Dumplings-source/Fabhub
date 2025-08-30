<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        // Get all services for reservations (don't filter by availability)
        // Users should be able to see all services to make reservations
        $services = Service::select('id', 'name', 'rate', 'availability')
            ->orderBy('name')
            ->get();
            
        return response()->json($services);
    }
}
