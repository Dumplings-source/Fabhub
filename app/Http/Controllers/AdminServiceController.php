<?php
namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Events\NewServiceAdded;

class AdminServiceController extends Controller
{
    public function index()
    {
        return response()->json(['services' => Service::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'file_formats' => 'required|array',
            'materials' => 'required|array',
            'estimated_time' => 'required|string',
            'status' => 'required|string'
        ]);
        $service = Service::create($validated);
        broadcast(new NewServiceAdded($service))->toOthers();
        return response()->json(['service' => $service]);
    }
}
