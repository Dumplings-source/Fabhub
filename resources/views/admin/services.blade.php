@extends('admin.dashboard')

@section('content')
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="w-full lg:w-64 bg-gray-800 text-white p-6 lg:min-h-screen">
            <h2 class="text-xl font-semibold mb-6">Admin Menu</h2>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('services') }}" class="block px-4 py-2 rounded bg-gray-700">Service Management</a>
                <a href="{{ route('admin.orders') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Orders</a>
                <a href="{{ route('admin.reservations') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Reservations</a>
                <!-- Material Management Section -->
                <div class="mt-4">
                    <h3 class="text-lg font-semibold mb-2">Manage Materials</h3>
                    <form method="POST" action="{{ route('services.updateMaterials') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="service_id" class="block text-sm font-medium">Select Service</label>
                            <select name="service_id" id="service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900" required>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="materials" class="block text-sm font-medium">Materials (comma-separated)</label>
                            <input type="text" name="materials" id="materials" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900" placeholder="e.g., PLA, ABS, PETG">
                        </div>
                        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Materials</button>
                    </form>
                </div>
                
                <!-- Time Slot Management Section -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">Manage Time Slots</h3>
                    <form method="POST" action="{{ route('services.updateTimeSlots') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="timeslot_service_id" class="block text-sm font-medium">Select Service</label>
                            <select name="service_id" id="timeslot_service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900" required>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-medium">Available Time Slots</label>
                            
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="time_slots[]" id="slot_9_10" value="9:00 AM - 10:00 AM" class="rounded text-blue-500 focus:ring-blue-500">
                                <label for="slot_9_10" class="text-sm">9:00 AM - 10:00 AM</label>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="time_slots[]" id="slot_10_11" value="10:00 AM - 11:00 AM" class="rounded text-blue-500 focus:ring-blue-500">
                                <label for="slot_10_11" class="text-sm">10:00 AM - 11:00 AM</label>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="time_slots[]" id="slot_11_12" value="11:00 AM - 12:00 PM" class="rounded text-blue-500 focus:ring-blue-500">
                                <label for="slot_11_12" class="text-sm">11:00 AM - 12:00 PM</label>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="time_slots[]" id="slot_1_2" value="1:00 PM - 2:00 PM" class="rounded text-blue-500 focus:ring-blue-500">
                                <label for="slot_1_2" class="text-sm">1:00 PM - 2:00 PM</label>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="time_slots[]" id="slot_2_3" value="2:00 PM - 3:00 PM" class="rounded text-blue-500 focus:ring-blue-500">
                                <label for="slot_2_3" class="text-sm">2:00 PM - 3:00 PM</label>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="time_slots[]" id="slot_3_4" value="3:00 PM - 4:00 PM" class="rounded text-blue-500 focus:ring-blue-500">
                                <label for="slot_3_4" class="text-sm">3:00 PM - 4:00 PM</label>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Time Slots</button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(!auth('admin')->check())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-6" role="alert">
                    <p class="font-bold">Access Denied</p>
                    <p>You do not have permission to view this page.</p>
                </div>
            @else
                <div class="bg-white shadow rounded-lg p-6 m-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Service Management</h2>
                        <button onclick="document.getElementById('add-service-form').classList.toggle('hidden')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Service</button>
                    </div>

                    <!-- Add Service Form -->
                    <div id="add-service-form" class="hidden mb-6">
                        <form method="POST" action="{{ route('services.store') }}">
                            @csrf
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label for="rate" class="block text-sm font-medium text-gray-700">Rate ($)</label>
                                    <input type="number" name="rate" id="rate" step="0.01" value="{{ old('rate') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                                    <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label for="estimated_time" class="block text-sm font-medium text-gray-700">Estimated Time</label>
                                    <input type="text" name="estimated_time" id="estimated_time" value="{{ old('estimated_time') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label for="availability" class="block text-sm font-medium text-gray-700">Availability</label>
                                    <select name="availability" id="availability" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="1" {{ old('availability') == 1 ? 'selected' : '' }}>Available</option>
                                        <option value="0" {{ old('availability') == 0 ? 'selected' : '' }}>Unavailable</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                                </div>
                                <div>
                                    <label for="file_formats" class="block text-sm font-medium text-gray-700">File Formats</label>
                                    <input type="text" name="file_formats" id="file_formats" value="{{ old('file_formats') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                                <div>
                                    <label for="materials" class="block text-sm font-medium text-gray-700">Materials</label>
                                    <input type="text" name="materials" id="materials" value="{{ old('materials') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end space-x-2">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
                                <button type="button" onclick="document.getElementById('add-service-form').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Services Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">Rate</th>
                                    <th class="py-3 px-6 text-left">Price</th>
                                    <th class="py-3 px-6 text-left">Estimated Time</th>
                                    <th class="py-3 px-6 text-left">Availability</th>
                                    <th class="py-3 px-6 text-left">Description</th>
                                    <th class="py-3 px-6 text-left">File Formats</th>
                                    <th class="py-3 px-6 text-left">Materials</th>
                                    <th class="py-3 px-6 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($services as $service)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6">{{ $service->name }}</td>
                                        <td class="py-3 px-6">${{ number_format($service->rate, 2) }}</td>
                                        <td class="py-3 px-6">${{ number_format($service->price, 2) }}</td>
                                        <td class="py-3 px-6">{{ $service->estimated_time }}</td>
                                        <td class="py-3 px-6">{{ $service->availability ? 'Available' : 'Unavailable' }}</td>
                                        <td class="py-3 px-6">{{ $service->description ?? 'No description' }}</td>
                                        <td class="py-3 px-6">{{ $service->file_formats }}</td>
                                        <td class="py-3 px-6">{{ $service->materials }}</td>
                                        <td class="py-3 px-6 flex space-x-2">
                                            <a href="{{ route('services.edit', $service->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                            <form method="POST" action="{{ route('services.destroy', $service->id) }}" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                            </form>
                                            <form method="POST" action="{{ route('services.toggleAvailability', $service->id) }}">
                                                @csrf
                                                <button type="submit" class="{{ $service->availability ? 'text-red-500' : 'text-green-500' }} hover:underline">
                                                    {{ $service->availability ? 'Set Unavailable' : 'Set Available' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(empty($services) || $services->isEmpty())
                                    <tr>
                                        <td colspan="9" class="py-3 px-6 text-center">No services available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </main>
    </div>
@endsection