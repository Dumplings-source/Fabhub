<x-app-layout>
    <!-- Pusher for real-time updates -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <div class="container py-4">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Recent Orders Section -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-secondary border-0 shadow position-relative mb-4">
                    <div class="tech-pattern"></div>
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="text-warning section-title mb-0">My Orders</h2>
                            <span class="badge bg-warning text-primary rounded-pill px-3 py-2">
                                {{ $orders->count() }} {{ Str::plural('order', $orders->count()) }}
                            </span>
                        </div>
                        
                        @if($orders->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-box-seam fs-1 text-light opacity-50 mb-3"></i>
                                <p class="text-light mb-2">No orders yet</p>
                                <a href="{{ route('service-catalog') }}" class="btn btn-warning btn-sm text-primary">
                                    Browse services to place an order
                                </a>
                            </div>
                        @else
                            <!-- Desktop Table View -->
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Service</th>
                                            <th>Material</th>
                                            <th>Quantity</th>
                                            <th>Preferred Date</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="fw-medium">#{{ $order->id }}</td>
                                                <td>{{ $order->service->name }}</td>
                                                <td>{{ $order->material }}</td>
                                                <td>{{ $order->quantity }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->preferred_date)->format('M d, Y') }}</td>
                                                <td>
                                                    <span class="badge rounded-pill 
                                                        {{ $order->status === 'pending' ? 'bg-warning text-primary' : '' }}
                                                        {{ $order->status === 'processing' ? 'bg-info text-dark' : '' }}
                                                        {{ $order->status === 'completed' ? 'bg-success' : '' }}
                                                        {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}
                                                    ">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Mobile Card View -->
                            <div class="d-md-none">
                                @foreach($orders as $order)
                                    <div class="card bg-light mb-3 border-0 shadow-sm">
                                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-light fw-medium">Order #{{ $order->id }}</span>
                                                <small class="text-light opacity-75 ms-2">{{ $order->created_at->format('M d, Y') }}</small>
                                            </div>
                                            <span class="badge rounded-pill 
                                                {{ $order->status === 'pending' ? 'bg-warning text-primary' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-info text-dark' : '' }}
                                                {{ $order->status === 'completed' ? 'bg-success' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-danger' : '' }}
                                            ">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <h6 class="text-muted small text-uppercase mb-1">Service</h6>
                                                    <p class="fw-medium mb-0">{{ $order->service->name }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="text-muted small text-uppercase mb-1">Material</h6>
                                                    <p class="fw-medium mb-0">{{ $order->material }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="text-muted small text-uppercase mb-1">Quantity</h6>
                                                    <p class="fw-medium mb-0">{{ $order->quantity }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="text-muted small text-uppercase mb-1">Preferred Date</h6>
                                                    <p class="fw-medium mb-0">{{ \Carbon\Carbon::parse($order->preferred_date)->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            
                                            @if($order->status === 'processing')
                                                <div class="mt-3 pt-3 border-top">
                                                    <div class="d-flex align-items-start">
                                                        <div class="bg-secondary rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                            <i class="bi bi-check text-light small"></i>
                                                        </div>
                                                        <div>
                                                            <p class="fw-medium mb-0">Order Accepted</p>
                                                            <p class="text-muted small">Your order has been accepted and is being processed</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($order->status === 'completed')
                                                <div class="mt-3 pt-3 border-top">
                                                    <div class="d-flex align-items-start">
                                                        <div class="bg-success rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                            <i class="bi bi-check-lg text-light small"></i>
                                                        </div>
                                                        <div>
                                                            <p class="fw-medium mb-0">Order Completed</p>
                                                            <p class="text-muted small">Your order has been completed and is ready for pickup</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($order->notes)
                                                <div class="mt-3 pt-3 border-top">
                                                    <h6 class="text-muted small text-uppercase mb-1">Notes</h6>
                                                    <p class="mb-0">{{ $order->notes }}</p>
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
        // Determine the icon based on status
        let statusIcon = 'bi-info-circle';
        let bgClass = 'bg-primary';
        
        if (data.order.status === 'processing') {
            statusIcon = 'bi-arrow-clockwise';
            bgClass = 'bg-info';
        } else if (data.order.status === 'completed') {
            statusIcon = 'bi-check-circle';
            bgClass = 'bg-success';
        } else if (data.order.status === 'cancelled') {
            statusIcon = 'bi-x-circle';
            bgClass = 'bg-danger';
        }
        
        // Create toast HTML
        const toastHTML = `
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
                <div class="toast show ${bgClass} text-white" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header ${bgClass} text-white">
                        <i class="bi ${statusIcon} me-2"></i>
                        <strong class="me-auto">Order Update</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <p class="mb-0">${data.message}</p>
                        <p class="small mb-0">Order #${data.order.id} for ${data.order.service.name}</p>
                    </div>
                </div>
            </div>
        `;
        
        // Add the toast to the document
        document.body.insertAdjacentHTML('beforeend', toastHTML);
        
        // Remove the toast after 5 seconds
        setTimeout(() => {
            const toast = document.querySelector('.toast');
            if (toast) {
                toast.remove();
            }
        }, 5000);
    }
</script> 