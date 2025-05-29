@extends('admin.dashboard')

@section('content')
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="w-full lg:w-64 bg-gray-800 text-white p-6 lg:min-h-screen">
            <h2 class="text-xl font-semibold mb-6">Admin Menu</h2>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('services') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Service Management</a>
                <a href="{{ route('admin.orders') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Orders</a>
                <a href="{{ route('admin.reservations') }}" class="block px-4 py-2 rounded bg-gray-700">Reservations</a>
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
                        <h2 class="text-2xl font-semibold">Reservations</h2>
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

                    <!-- Reservations Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Reservation ID</th>
                                    <th class="py-3 px-6 text-left">Service</th>
                                    <th class="py-3 px-6 text-left">Date/Time</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($reservations as $reservation)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6">{{ $reservation->id }}</td>
                                        <td class="py-3 px-6">{{ $reservation->service->name ?? 'N/A' }}</td>
                                        <td class="py-3 px-6">{{ $reservation->reservation_date ? \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td class="py-3 px-6">{{ $reservation->status ?? 'N/A' }}</td>
                                        <td class="py-3 px-6 flex space-x-2">
                                            @if($reservation->status === 'pending')
                                                <form method="POST" action="{{ route('admin.reservations.update', $reservation->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="text-green-500 hover:underline">Confirm</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.reservations.update', $reservation->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="text-red-500 hover:underline">Cancel</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if(empty($reservations) || $reservations->isEmpty())
                                    <tr>
                                        <td colspan="5" class="py-3 px-6 text-center">No reservations available</td>
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