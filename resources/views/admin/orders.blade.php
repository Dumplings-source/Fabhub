@extends('admin.dashboard')

@section('content')
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="w-full lg:w-64 bg-gray-800 text-white p-6 lg:min-h-screen">
            <h2 class="text-xl font-semibold mb-6">Admin Menu</h2>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('services') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Service Management</a>
                <a href="{{ route('admin.orders') }}" class="block px-4 py-2 rounded bg-gray-700">Orders</a>
                <a href="{{ route('admin.reservations') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Reservations</a>
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
                    <h2 class="text-2xl font-semibold mb-6">Order Management</h2>

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

                    <!-- Filter Section -->
                    <div class="mb-6">
                        <div class="flex flex-wrap items-center gap-2 md:gap-4">
                            <span class="text-sm font-medium text-gray-700 mb-2 md:mb-0 w-full md:w-auto">Filter by Status:</span>
                            <div class="flex flex-wrap gap-2 w-full md:w-auto">
                                <a href="{{ route('admin.orders', ['status' => '']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    All
                                </a>
                                <a href="{{ route('admin.orders', ['status' => 'processing']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ request('status') == 'processing' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Processing
                                </a>
                                <a href="{{ route('admin.orders', ['status' => 'completed']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ request('status') == 'completed' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Completed
                                </a>
                                <a href="{{ route('admin.orders', ['status' => 'pending']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ request('status') == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Pending
                                </a>
                                <a href="{{ route('admin.orders', ['status' => 'cancelled']) }}" 
                                   class="px-3 py-2 text-xs md:text-sm rounded-md {{ request('status') == 'cancelled' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                    Cancelled
                                </a>
                            </div>
                        </div>
                        
                        <!-- Filter summary -->
                        <div class="mt-3 text-sm text-gray-600">
                            @if(request('status'))
                                Showing {{ ucfirst(request('status')) }} orders
                                <span class="text-xs ml-2 text-gray-500">({{ $orders->total() }} {{ Str::plural('order', $orders->total()) }})</span>
                            @else
                                Showing all orders
                                <span class="text-xs ml-2 text-gray-500">({{ $orders->total() }} {{ Str::plural('order', $orders->total()) }})</span>
                            @endif
                        </div>
                    </div>

                    <!-- Orders Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Order ID</th>
                                    <th class="py-3 px-6 text-left">User</th>
                                    <th class="py-3 px-6 text-left">Service</th>
                                    <th class="py-3 px-6 text-left">Material</th>
                                    <th class="py-3 px-6 text-left">Quantity</th>
                                    <th class="py-3 px-6 text-left">Preferred Date</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-left">Date</th>
                                    <th class="py-3 px-6 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($orders as $order)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6">{{ $order->id }}</td>
                                        <td class="py-3 px-6">{{ $order->user->name }}</td>
                                        <td class="py-3 px-6">{{ $order->service->name }}</td>
                                        <td class="py-3 px-6">{{ $order->material }}</td>
                                        <td class="py-3 px-6">{{ $order->quantity }}</td>
                                        <td class="py-3 px-6">{{ $order->preferred_date }}</td>
                                        <td class="py-3 px-6">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6">{{ $order->created_at->toFormattedDateString() }}</td>
                                        <td class="py-3 px-6 flex space-x-2">
                                            @if($order->status === 'pending')
                                                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="text-blue-500 hover:underline">Accept</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="text-red-500 hover:underline">Reject</button>
                                                </form>
                                            @endif
                                            
                                            @if($order->status === 'processing')
                                                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="text-green-500 hover:underline">Mark as Complete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if($orders->isEmpty())
                                    <tr>
                                        <td colspan="9" class="py-3 px-6 text-center">
                                            @if(request('status'))
                                                No {{ request('status') }} orders found
                                            @else
                                                No orders available
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        </main>
    </div>
@endsection
```