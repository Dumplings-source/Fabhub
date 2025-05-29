<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Management') }}
            </h2>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="bg-primary text-white px-4 py-2 !rounded-button font-medium hover:bg-primary/90 transition whitespace-nowrap">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 flex flex-wrap gap-2">
                    <button onclick="filterOrders('all')" class="filter-btn filter-all bg-blue-100 text-blue-800 px-4 py-2 rounded-md text-sm font-medium">
                        All Orders
                    </button>
                    <button onclick="filterOrders('pending')" class="filter-btn filter-pending bg-yellow-50 text-yellow-800 px-4 py-2 rounded-md text-sm font-medium">
                        Pending
                    </button>
                    <button onclick="filterOrders('processing')" class="filter-btn filter-processing bg-blue-50 text-blue-800 px-4 py-2 rounded-md text-sm font-medium">
                        Processing
                    </button>
                    <button onclick="filterOrders('completed')" class="filter-btn filter-completed bg-green-50 text-green-800 px-4 py-2 rounded-md text-sm font-medium">
                        Completed
                    </button>
                    <button onclick="filterOrders('cancelled')" class="filter-btn filter-cancelled bg-red-50 text-red-800 px-4 py-2 rounded-md text-sm font-medium">
                        Cancelled
                    </button>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Customer Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="orders-table-body">
                                <!-- Orders will be loaded dynamically -->
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center text-gray-500">Loading orders...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="order-details-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Order Details</h3>
                    <button onclick="closeOrderDetailsModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="order-details-content" class="space-y-4">
                    <!-- Order details will be loaded dynamically -->
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button onclick="closeOrderDetailsModal()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200">
                        Close
                    </button>
                    <div id="order-action-buttons">
                        <!-- Action buttons will be added dynamically based on status -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .status-badge {
            @apply px-3 py-1 text-xs font-medium rounded-full;
        }
        .status-pending {
            @apply bg-yellow-100 text-yellow-800;
        }
        .status-processing {
            @apply bg-blue-100 text-blue-800;
        }
        .status-completed {
            @apply bg-green-100 text-green-800;
        }
        .status-cancelled {
            @apply bg-red-100 text-red-800;
        }
        .order-row {
            @apply hover:bg-gray-50 transition-colors;
        }
        .filter-btn {
            @apply hover:opacity-80 transition-opacity;
        }
        .filter-btn.active {
            @apply ring-2 ring-offset-2;
        }
    </style>

    <script>
        let allOrders = [];
        let currentFilter = 'all';

        // Fetch all orders
        function loadOrders() {
            fetch('/api/admin/orders', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(orders => {
                allOrders = orders;
                displayOrders(orders);
                updateFilterButtons();
            })
            .catch(error => {
                console.error('Error loading orders:', error);
                document.getElementById('orders-table-body').innerHTML = `
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-red-500">
                            Error loading orders. Please try again later.
                        </td>
                    </tr>
                `;
            });
        }

        // Display orders in the table based on filter
        function displayOrders(orders) {
            const tbody = document.getElementById('orders-table-body');
            
            if (orders.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No orders found</td>
                    </tr>
                `;
                return;
            }
            
            // Sort orders: pending first, then processing, then others by date (newest first)
            orders.sort((a, b) => {
                if (a.status === 'pending' && b.status !== 'pending') return -1;
                if (a.status !== 'pending' && b.status === 'pending') return 1;
                if (a.status === 'processing' && b.status !== 'processing') return -1;
                if (a.status !== 'processing' && b.status === 'processing') return 1;
                return new Date(b.created_at) - new Date(a.created_at);
            });
            
            tbody.innerHTML = orders.map(order => `
                <tr class="order-row" data-status="${order.status}" data-order-id="${order.id}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">#${order.id}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${order.user.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${order.service.name}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${order.material}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${order.quantity}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${formatDate(order.preferred_date)}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="status-badge ${getStatusClass(order.status)}">
                            ${capitalizeFirstLetter(order.status)}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">${formatDate(order.created_at)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button onclick="viewOrderDetails(${order.id})" class="text-indigo-600 hover:text-indigo-900">
                            View
                        </button>
                        ${order.status === 'pending' ? `
                            <button onclick="acceptOrder(${order.id}, event)" class="ml-3 text-green-600 hover:text-green-900">
                                Accept
                            </button>
                        ` : ''}
                    </td>
                </tr>
            `).join('');
        }

        // Filter orders by status
        function filterOrders(status) {
            currentFilter = status;
            
            let filteredOrders;
            if (status === 'all') {
                filteredOrders = allOrders;
            } else {
                filteredOrders = allOrders.filter(order => order.status === status);
            }
            
            displayOrders(filteredOrders);
            updateFilterButtons();
        }

        // Update filter button styles
        function updateFilterButtons() {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            document.querySelector(`.filter-${currentFilter}`).classList.add('active');
        }

        // View order details
        function viewOrderDetails(orderId) {
            const order = allOrders.find(o => o.id === orderId);
            if (!order) return;
            
            const modal = document.getElementById('order-details-modal');
            const content = document.getElementById('order-details-content');
            const actionButtons = document.getElementById('order-action-buttons');
            
            // Generate order details content
            content.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Order Information</h4>
                        <div class="mt-2 border border-gray-200 rounded-md overflow-hidden">
                            <dl class="divide-y divide-gray-200">
                                <div class="px-4 py-3 grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Order ID</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">#${order.id}</dd>
                                </div>
                                <div class="px-4 py-3 grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">
                                        <span class="status-badge ${getStatusClass(order.status)}">
                                            ${capitalizeFirstLetter(order.status)}
                                        </span>
                                    </dd>
                                </div>
                                <div class="px-4 py-3 grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">${formatDate(order.created_at)}</dd>
                                </div>
                                <div class="px-4 py-3 grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Preferred Date</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">${formatDate(order.preferred_date)}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Customer Information</h4>
                        <div class="mt-2 border border-gray-200 rounded-md overflow-hidden">
                            <dl class="divide-y divide-gray-200">
                                <div class="px-4 py-3 grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">${order.user.name}</dd>
                                </div>
                                <div class="px-4 py-3 grid grid-cols-3">
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="text-sm text-gray-900 col-span-2">${order.user.email}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-500">Service Details</h4>
                    <div class="mt-2 border border-gray-200 rounded-md overflow-hidden">
                        <dl class="divide-y divide-gray-200">
                            <div class="px-4 py-3 grid grid-cols-3">
                                <dt class="text-sm font-medium text-gray-500">Service</dt>
                                <dd class="text-sm text-gray-900 col-span-2">${order.service.name}</dd>
                            </div>
                            <div class="px-4 py-3 grid grid-cols-3">
                                <dt class="text-sm font-medium text-gray-500">Material</dt>
                                <dd class="text-sm text-gray-900 col-span-2">${order.material}</dd>
                            </div>
                            <div class="px-4 py-3 grid grid-cols-3">
                                <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                                <dd class="text-sm text-gray-900 col-span-2">${order.quantity}</dd>
                            </div>
                            ${order.notes ? `
                            <div class="px-4 py-3 grid grid-cols-3">
                                <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                <dd class="text-sm text-gray-900 col-span-2">${order.notes}</dd>
                            </div>
                            ` : ''}
                            ${order.file_path ? `
                            <div class="px-4 py-3 grid grid-cols-3">
                                <dt class="text-sm font-medium text-gray-500">File</dt>
                                <dd class="text-sm text-gray-900 col-span-2">
                                    <a href="${order.file_path}" class="text-blue-600 hover:underline" target="_blank">
                                        View Uploaded File
                                    </a>
                                </dd>
                            </div>
                            ` : ''}
                        </dl>
                    </div>
                </div>
            `;
            
            // Add action buttons based on status
            actionButtons.innerHTML = '';
            
            if (order.status === 'pending') {
                actionButtons.innerHTML = `
                    <button onclick="acceptOrder(${order.id})" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">
                        Accept Order
                    </button>
                `;
            } else if (order.status === 'processing') {
                actionButtons.innerHTML = `
                    <button onclick="completeOrder(${order.id})" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                        Mark as Completed
                    </button>
                `;
            }
            
            // Show the modal
            modal.classList.remove('hidden');
        }

        // Close order details modal
        function closeOrderDetailsModal() {
            document.getElementById('order-details-modal').classList.add('hidden');
        }

        // Accept an order
        function acceptOrder(orderId, event) {
            if (event) {
                event.stopPropagation(); // Prevent the viewOrderDetails from being triggered
            }
            
            if (!confirm('Are you sure you want to accept this order?')) {
                return;
            }
            
            fetch(`/api/admin/orders/${orderId}/accept`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to accept order');
                }
                return response.json();
            })
            .then(data => {
                // Update the order in our local array
                const orderIndex = allOrders.findIndex(o => o.id === orderId);
                if (orderIndex !== -1) {
                    allOrders[orderIndex].status = 'processing';
                }
                
                // Refresh the display
                filterOrders(currentFilter);
                
                // Show success message
                showNotification('Order accepted successfully!');
                
                // Close the modal if it's open
                closeOrderDetailsModal();
            })
            .catch(error => {
                console.error('Error accepting order:', error);
                showNotification('Error accepting order. Please try again.', 'error');
            });
        }

        // Mark an order as completed
        function completeOrder(orderId) {
            if (!confirm('Are you sure you want to mark this order as completed?')) {
                return;
            }
            
            fetch(`/api/admin/orders/${orderId}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: 'completed' })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to complete order');
                }
                return response.json();
            })
            .then(data => {
                // Update the order in our local array
                const orderIndex = allOrders.findIndex(o => o.id === orderId);
                if (orderIndex !== -1) {
                    allOrders[orderIndex].status = 'completed';
                }
                
                // Refresh the display
                filterOrders(currentFilter);
                
                // Show success message
                showNotification('Order marked as completed!');
                
                // Close the modal
                closeOrderDetailsModal();
            })
            .catch(error => {
                console.error('Error completing order:', error);
                showNotification('Error completing order. Please try again.', 'error');
            });
        }

        // Helper function to format date
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            return new Date(dateString).toLocaleDateString(undefined, options);
        }

        // Helper function to get status badge class
        function getStatusClass(status) {
            switch(status) {
                case 'pending': return 'status-pending';
                case 'processing': return 'status-processing';
                case 'completed': return 'status-completed';
                case 'cancelled': return 'status-cancelled';
                default: return '';
            }
        }

        // Helper function to capitalize first letter
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    ${type === 'success' 
                        ? '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' 
                        : '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'
                    }
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="absolute top-1 right-1 text-white hover:text-gray-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            document.body.appendChild(notification);
            
            // Remove the notification after 5 seconds
            setTimeout(() => notification.remove(), 5000);
        }

        // Load orders when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadOrders();
        });
    </script>
</x-app-layout> 