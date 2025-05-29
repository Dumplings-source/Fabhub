```
@extends('dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Bar -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <nav class="flex space-x-4 p-4" aria-label="Tabs">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                        Dashboard
                    </a>
                    <a href="{{ route('service-catalog') }}" class="px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                        Service Catalog
                    </a>
                    <a href="{{ route('user.orders-notifications') }}" class="px-3 py-2 text-sm font-medium rounded-md text-blue-700 bg-blue-100" aria-current="page">
                        Orders & Notifications
                    </a>
                </nav>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Orders</h3>
                    @if($orders->isEmpty())
                        <p class="text-gray-500">No orders yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preferred Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->service->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->material }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->preferred_date }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <a href="{{ asset('storage/' . $order->file_path) }}" target="_blank" class="text-blue-500 hover:underline">View File</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->created_at->toFormattedDateString() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Notifications</h3>
                    @if($notifications->isEmpty())
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-blue-800">No new notifications.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-blue-800">{{ $notification->data['message'] }}</h4>
                                    <p class="text-sm text-blue-500 mt-2">{{ $notification->created_at->toFormattedDateString() }}</p>
                                </div>
                            @endforeach
                        </div>
                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
```