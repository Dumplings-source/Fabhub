<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Recent Orders') }}
            </h2>
            <div class="flex items-center">
                <div class="text-sm text-gray-600">
                    <a href="/" class="hover:text-primary transition-colors">Home</a> / 
                    <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a> / 
                    <span class="font-medium">Recent Orders</span>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Pusher for real-time updates -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto mt-4 sm:px-6 lg:px-8">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Bar -->
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <nav class="d-flex p-3 border-bottom" aria-label="Tabs">
                    <a href="{{ route('dashboard') }}" class="btn fw-semibold me-3 text-secondary border-0">
                        Dashboard
                    </a>
                    <a href="{{ route('service-catalog') }}" class="btn fw-semibold me-3 text-secondary border-0">
                        Service Catalog
                    </a>
                    <a href="{{ route('recent-orders') }}" class="btn fw-semibold me-3 text-primary border-0">
                        Recent Orders
                    </a>
                    <a href="{{ route('dashboard') }}?tab=reservations" class="btn fw-semibold me-3 text-secondary border-0">
                        Reservations
                    </a>
                    <a href="{{ route('dashboard') }}?tab=notifications" class="btn fw-semibold me-3 text-secondary border-0">
                        Notifications
                    </a>
                </nav>
            </div>
            
            <!-- Recent Orders Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-900">My Orders</h3>
                        <div class="text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $orders->count() }} {{ Str::plural('order', $orders->count()) }}
                            </span>
                        </div>
                    </div>
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <p class="text-gray-500 text-sm">No orders yet</p>
                            <a href="{{ route('service-catalog') }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                                Browse services to place an order
                            </a>
                        </div>
                    @else
                        <!-- Desktop Table View -->
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preferred Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">#{{ $order->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->service->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->material }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ \Carbon\Carbon::parse($order->preferred_date)->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                ">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Mobile Card View -->
                        <div class="md:hidden space-y-4">
                            @foreach($orders as $order)
                                <div class="border border-gray-200 rounded-lg shadow-sm mb-4 overflow-hidden">
                                    <div class="flex justify-between items-center bg-gray-50 px-4 py-3 border-b border-gray-200">
                                        <div>
                                            <span class="text-sm font-medium">Order #{{ $order->id }}</span>
                                            <span class="text-xs text-gray-500 ml-2">{{ $order->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Service</span>
                                                <span class="text-sm font-medium text-gray-900 mt-1">{{ $order->service->name }}</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Material</span>
                                                <span class="text-sm font-medium text-gray-900 mt-1">{{ $order->material }}</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</span>
                                                <span class="text-sm font-medium text-gray-900 mt-1">{{ $order->quantity }}</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Preferred Date</span>
                                                <span class="text-sm font-medium text-gray-900 mt-1">{{ \Carbon\Carbon::parse($order->preferred_date)->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        
                                        @if($order->status === 'processing')
                                            <div class="mt-4 pt-4 border-t border-gray-200">
                                                <div class="flex items-start space-x-3 mb-3">
                                                    <div class="h-6 w-6 text-white rounded-full flex items-center justify-center flex-shrink-0 bg-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">Order Accepted</p>
                                                        <p class="text-xs text-gray-500">Your order has been accepted and is being processed</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($order->status === 'completed')
                                            <div class="mt-4 pt-4 border-t border-gray-200">
                                                <div class="flex items-start space-x-3 mb-3">
                                                    <div class="h-6 w-6 text-white rounded-full flex items-center justify-center flex-shrink-0 bg-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">Order Completed</p>
                                                        <p class="text-xs text-gray-500">Your order has been completed and is ready for pickup</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if($order->notes)
                                            <div class="mt-4 pt-4 border-t border-gray-200">
                                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</span>
                                                <p class="text-sm text-gray-700 mt-1">{{ $order->notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Setup Pusher for real-time updates
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Pusher
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true
        });
        
        // Subscribe to the user's channel
        const channel = pusher.subscribe('user-{{ Auth::id() }}');
        
        // Listen for order status updates
        channel.bind('order-status-updated', function(data) {
            // Refresh the page to show updated order status
            window.location.reload();
            
            // Show a toast notification
            showToastNotification(data);
        });
    });
    
    // Show toast notification
    function showToastNotification(data) {
        // Create a toast element
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-blue-500 text-white p-4 rounded-lg shadow-lg z-50';
        
        // Determine the icon based on status
        let statusIcon = '';
        if (data.order.status === 'processing') {
            statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
        } else if (data.order.status === 'completed') {
            statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
        } else if (data.order.status === 'cancelled') {
            statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
        }
        
        // Set the toast content
        toast.innerHTML = `
            <div class="flex items-center">
                ${statusIcon}
                <div>
                    <p class="font-medium">${data.message}</p>
                    <p class="text-sm opacity-90">Order #${data.order.id} for ${data.order.service.name}</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="absolute top-1 right-1 text-white hover:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        
        // Add the toast to the page
        document.body.appendChild(toast);
        
        // Remove the toast after 5 seconds
        setTimeout(() => {
            toast.style.opacity = 0;
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }
</script> 