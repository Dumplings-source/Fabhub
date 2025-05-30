@extends('admin.dashboard')

@section('page-title', 'Reservation Management')

@section('content')
    @if(!auth('admin')->check())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Access Denied</p>
            <p>You do not have permission to view this page.</p>
        </div>
    @else
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold">Reservation Management</h3>
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        Total Reservations: <span class="font-semibold">{{ $reservations->count() }}</span>
                    </div>
                    <div class="text-sm text-green-600">
                        Confirmed: <span class="font-semibold">{{ $reservations->where('status', 'confirmed')->count() }}</span>
                    </div>
                    <div class="text-sm text-yellow-600">
                        Pending: <span class="font-semibold">{{ $reservations->where('status', 'pending')->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                    <div class="flex">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Reservations Table -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">ID</th>
                            <th class="py-3 px-6 text-left">Customer</th>
                            <th class="py-3 px-6 text-left">Service</th>
                            <th class="py-3 px-6 text-left">Date & Time</th>
                            <th class="py-3 px-6 text-left">Contact</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($reservations as $reservation)
                            <tr class="border-b border-gray-200 hover:bg-gray-100 transition-colors duration-200">
                                <td class="py-3 px-6 font-medium">#{{ $reservation->id }}</td>
                                <td class="py-3 px-6">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $reservation->user->name ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500">{{ $reservation->user->email ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6">
                                    <span class="font-medium">{{ $reservation->service->name ?? 'N/A' }}</span>
                                </td>
                                <td class="py-3 px-6">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $reservation->reservation_date ? $reservation->reservation_date->format('M d, Y') : 'N/A' }}</span>
                                        <span class="text-xs text-gray-500">{{ $reservation->time_slot ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6">
                                    <span class="text-sm">{{ $reservation->contact_info ?? 'N/A' }}</span>
                                </td>
                                <td class="py-3 px-6">
                                    <span class="px-3 py-1 text-xs rounded-full font-medium
                                        {{ $reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $reservation->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6">
                                    <div class="flex items-center space-x-2">
                                        <form method="POST" action="{{ route('admin.reservations.update', $reservation->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" 
                                                class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="pending" {{ $reservation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="cancelled" {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                        @if($reservation->notes)
                                            <button onclick="showNotes('{{ addslashes($reservation->notes) }}')" 
                                                class="text-blue-600 hover:text-blue-800 text-xs">
                                                <i class="fas fa-sticky-note"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($reservations->isEmpty())
                            <tr>
                                <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-calendar-times text-4xl mb-4 text-gray-300"></i>
                                        <span class="text-lg font-medium">No reservations found</span>
                                        <span class="text-sm">Reservations will appear here when customers make them.</span>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                @if(method_exists($reservations, 'links'))
                    {{ $reservations->links() }}
                @endif
            </div>
        </div>

        <!-- Notes Modal -->
        <div id="notesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-medium">Reservation Notes</h3>
                        <button onclick="hideNotes()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <p id="notesContent" class="text-gray-700"></p>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function showNotes(notes) {
            document.getElementById('notesContent').innerText = notes;
            document.getElementById('notesModal').classList.remove('hidden');
        }

        function hideNotes() {
            document.getElementById('notesModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('notesModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideNotes();
            }
        });
        </script>
    @endif
@endsection