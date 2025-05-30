<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $services = Service::all();
        return view('admin.services', compact('services'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'estimated_time' => 'required|string|max:255',
            'availability' => 'boolean',
            'description' => 'nullable|string',
            'file_formats' => 'required|string',
            'materials' => 'required|string',
        ]);

        // Set default availability if not provided
        $validated['availability'] = $request->has('availability') ? (bool)$request->availability : true;

        Service::create($validated);
        return redirect()->route('services')->with('success', 'Service added successfully');
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'estimated_time' => 'required|string|max:255',
            'availability' => 'boolean',
            'description' => 'nullable|string',
            'file_formats' => 'required|string',
            'materials' => 'required|string',
        ]);

        // Set default availability if not provided
        $validated['availability'] = $request->has('availability') ? (bool)$request->availability : false;

        $service = Service::findOrFail($id);
        $service->update($validated);
        return redirect()->route('services')->with('success', 'Service updated successfully');
    }

    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        Service::findOrFail($id)->delete();
        return redirect()->route('services')->with('success', 'Service deleted successfully');
    }

    public function updateMaterials(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'materials' => 'required|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $service->materials = $validated['materials'];
        $service->save();

        return redirect()->back()->with('success', 'Materials updated successfully');
    }
    
    public function updateTimeSlots(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'time_slots' => 'nullable|array',
            'time_slots.*' => 'string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        // Clear existing time slots for this service
        TimeSlot::where('service_id', $service->id)->delete();
        
        // Create new time slots
        if (!empty($validated['time_slots'])) {
            foreach ($validated['time_slots'] as $slotName) {
                TimeSlot::create([
                    'service_id' => $service->id,
                    'name' => $slotName,
                    'is_available' => true
                ]);
            }
        }

        return redirect()->back()->with('success', 'Time slots updated successfully');
    }
    
    public function toggleAvailability($id)
    {
        if (!Auth::guard('admin')->check()) {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        $service = Service::findOrFail($id);
        $previousAvailability = $service->availability;
        $service->availability = !$service->availability;
        $service->save();

        // Broadcast the availability update
        try {
            broadcast(new \App\Events\ServiceAvailabilityUpdated($service, $previousAvailability));
        } catch (\Exception $e) {
            \Log::error('Failed to broadcast service availability update: ' . $e->getMessage());
        }

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'service' => [
                    'id' => $service->id,
                    'name' => $service->name,
                    'availability' => $service->availability,
                    'description' => $service->description,
                    'price' => $service->price,
                ],
                'message' => 'Service availability updated successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Service availability updated successfully');
    }

    public function updateMaterialPrices(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Unauthorized action.');
        }

        $service = Service::findOrFail($id);
        
        $validated = $request->validate([
            'material_prices' => 'required|array',
            'material_prices.*' => 'required|numeric|min:0',
        ]);
        
        // Clear existing material prices for this service
        $service->materialPrices()->delete();
        
        // Create new material prices
        foreach ($validated['material_prices'] as $materialName => $price) {
            $service->materialPrices()->create([
                'material_name' => $materialName,
                'price' => $price,
            ]);
        }

        return redirect()->back()->with('success', 'Material prices updated successfully');
    }
}