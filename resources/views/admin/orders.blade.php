@extends('admin.dashboard')

@section('page-title', 'Order Management')

@section('content')
    <style>
        :root {
            --primary-accent: #001740;
            --primary-base: #F4D462;
            --complementary-accent: #0F2A71;
            --secondary-accent: #FFC300;
            --secondary-palette: #FFFDF0;
        }
        
        .status-pending {
            background: linear-gradient(45deg, #fbbf24, #f59e0b);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-completed {
            background: linear-gradient(45deg, #22c55e, #16a34a);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-processing {
            background: linear-gradient(45deg, #3b82f6, #2563eb);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-cancelled {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .order-card {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #ffffff 100%);
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px rgba(0, 23, 64, 0.1);
            border-radius: 16px;
            transition: all 0.3s ease;
        }
        
        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 23, 64, 0.15);
        }
        
        /* Enhanced Order Details Modal Styling */
        .order-details-modal {
            background: rgba(0, 23, 64, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        .order-details-container {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #ffffff 100%);
            border: 2px solid var(--primary-base);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 23, 64, 0.2);
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .order-details-header {
            background: linear-gradient(135deg, var(--primary-accent) 0%, var(--complementary-accent) 100%);
            color: white;
            border-radius: 18px 18px 0 0;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }
        
        .order-details-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
            border-radius: 50%;
            transform: translate(30px, -30px);
            opacity: 0.2;
        }
        
        .order-details-close {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            color: white;
            padding: 8px 12px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .order-details-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .detail-section {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .detail-section:hover {
            border-color: var(--primary-base);
            box-shadow: 0 8px 25px rgba(244, 212, 98, 0.2);
            transform: translateY(-2px);
        }
        
        .detail-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
        }
        
        .detail-section-title {
            color: var(--primary-accent);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .detail-section-title i {
            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
            color: var(--primary-accent);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-row:hover {
            background: linear-gradient(90deg, transparent 0%, rgba(244, 212, 98, 0.1) 50%, transparent 100%);
            transform: translateX(8px);
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--complementary-accent);
            font-size: 14px;
        }
        
        .detail-value {
            color: var(--primary-accent);
            font-weight: 500;
            text-align: right;
        }
        
        .order-status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .file-preview-card {
            background: linear-gradient(135deg, #ffffff 0%, var(--secondary-palette) 100%);
            border: 2px solid var(--primary-base);
            border-radius: 16px;
            padding: 20px;
            margin-top: 16px;
            transition: all 0.3s ease;
        }
        
        .file-preview-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(244, 212, 98, 0.3);
        }
        
        .file-info {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        
        .file-icon {
            background: linear-gradient(45deg, var(--complementary-accent), var(--primary-accent));
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 16px;
        }
        
        .file-actions {
            display: flex;
            gap: 12px;
        }
        
        .file-action-btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }
        
        .btn-preview {
            background: linear-gradient(45deg, #22c55e, #16a34a);
            color: white;
            border: none;
        }
        
        .btn-preview:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.4);
            color: white;
        }
        
        .btn-download {
            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
            color: var(--primary-accent);
            border: none;
        }
        
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244, 212, 98, 0.4);
            color: var(--primary-accent);
        }
        
        .image-preview-container {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border: 2px solid var(--primary-base);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            margin-top: 16px;
        }
        
        .image-preview-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary-base);
        }
        
        .image-preview-title {
            color: var(--primary-accent);
            font-weight: 600;
            flex-grow: 1;
        }
        
        .image-preview-close {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        
        .image-preview-close:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
        
        .preview-image {
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 23, 64, 0.15);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .preview-image:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 35px rgba(0, 23, 64, 0.25);
        }
        
        .customer-notes-section {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 2px solid var(--secondary-accent);
            border-radius: 16px;
            padding: 24px;
        }
        
        .notes-content {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            font-style: italic;
            color: var(--primary-accent);
            line-height: 1.6;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .loading-spinner {
            color: var(--primary-base);
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .error-state {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            border: 2px solid #ef4444;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            color: #dc2626;
        }
        
        .success-state {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px solid #22c55e;
            border-radius: 16px;
            padding: 16px;
            color: #15803d;
        }
    </style>

            @if(!auth('admin')->check())
        <div class="alert-error p-4 mb-6 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-lg"></i>
                <div>
                    <p class="font-bold">Access Denied</p>
                    <p>You do not have permission to view this page.</p>
                </div>
            </div>
                </div>
            @else
        <div class="order-card p-8">
            <div class="mb-8">
                <h3 class="text-3xl font-bold text-primary-accent mb-2">Order Management</h3>
                <p class="text-complementary">Track and manage customer service requests</p>
            </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                <div class="alert-success p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-lg"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                        </div>
                    @endif
                    @if(session('error'))
                <div class="alert-error p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        </div>
                    @endif

                    <!-- Orders Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Order ID</th>
                            <th class="py-3 px-6 text-left">Customer</th>
                                    <th class="py-3 px-6 text-left">Service</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-left">Date</th>
                                    <th class="py-3 px-6 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach($orders as $order)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">#{{ $order->id }}</td>
                                <td class="py-3 px-6">{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="py-3 px-6">{{ $order->service->name ?? 'N/A' }}</td>
                                        <td class="py-3 px-6">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                <td class="py-3 px-6">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-6 flex space-x-2">
                                    <button onclick="viewOrderDetails({{ $order->id }})" class="text-blue-500 hover:underline">
                                        <i class="fas fa-eye mr-1"></i>View Details
                                    </button>
                                    <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs border rounded px-2 py-1">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                                </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($orders->isEmpty())
                                    <tr>
                                <td colspan="6" class="py-3 px-6 text-center">No orders found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-6">
                @if(method_exists($orders, 'links'))
                        {{ $orders->links() }}
                @endif
            </div>
        </div>

        <!-- Enhanced Order Details Modal -->
        <div id="order-details-modal" class="hidden fixed inset-0 order-details-modal overflow-y-auto h-full w-full flex items-center justify-center z-50">
            <div class="order-details-container p-8 border w-full max-w-6xl shadow-2xl max-h-screen overflow-y-auto mx-4">
                <div class="order-details-header flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">📋 Order Details</h3>
                        <p class="text-blue-100 opacity-90">Complete order information and customer details</p>
                    </div>
                    <button onclick="closeOrderDetailsModal()" class="order-details-close">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                
                <div id="order-details-content">
                    <!-- Order details will be loaded here -->
                    <div class="text-center py-8">
                        <div class="loading-spinner inline-block text-4xl mb-4">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                        <p class="text-complementary font-semibold">Loading order details...</p>
                        <p class="text-gray-500 text-sm mt-2">Please wait while we fetch the information</p>
                    </div>
                </div>
                    </div>
                </div>
            @endif
@endsection

@push('scripts')
<script>
    function viewOrderDetails(orderId) {
        document.getElementById('order-details-modal').classList.remove('hidden');
        
        // Reset content to loading state
        document.getElementById('order-details-content').innerHTML = `
            <div class="text-center py-4">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                <p class="mt-2 text-gray-600">Loading order details...</p>
            </div>
        `;
        
        // Fetch order details
        fetch(`/admin/orders/${orderId}/details`)
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response OK:', response.ok);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                if (data.success) {
                    displayOrderDetails(data.order);
                } else {
                    document.getElementById('order-details-content').innerHTML = `
                        <div class="text-center py-4 text-red-600">
                            <p>Failed to load order details: ${data.message || 'Unknown error'}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                document.getElementById('order-details-content').innerHTML = `
                    <div class="text-center py-4 text-red-600">
                        <p>An error occurred while loading order details</p>
                        <p class="text-sm text-gray-500 mt-2">Error: ${error.message}</p>
                    </div>
                `;
            });
    }
    
    function displayOrderDetails(order) {
        const content = document.getElementById('order-details-content');
        
        // Function to determine if file is an image
        function isImageFile(filePath) {
            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
            const extension = filePath.split('.').pop().toLowerCase();
            return imageExtensions.includes(extension);
        }
        
        // Function to get file name from path
        function getFileName(filePath) {
            return filePath.split('/').pop();
        }
        
        content.innerHTML = `
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Order Information -->
                <div class="detail-section">
                    <h4 class="detail-section-title">
                        <i class="fas fa-clipboard-list"></i>
                        Order Information
                    </h4>
                    <div class="space-y-2">
                        <div class="detail-row">
                            <span class="detail-label">Order ID:</span>
                            <span class="detail-value font-bold">#${order.id}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <span class="order-status-badge ${getStatusClass(order.status)}">
                                    ${capitalizeFirst(order.status)}
                                </span>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Order Date:</span>
                            <span class="detail-value">${formatDate(order.created_at)}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Preferred Date:</span>
                            <span class="detail-value">${formatDate(order.preferred_date)}</span>
                        </div>
                        ${order.time_slot ? `
                        <div class="detail-row">
                            <span class="detail-label">Time Slot:</span>
                            <span class="detail-value font-semibold">${order.time_slot}</span>
                        </div>
                        ` : ''}
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="detail-section">
                    <h4 class="detail-section-title">
                        <i class="fas fa-user"></i>
                        Customer Information
                    </h4>
                    <div class="space-y-2">
                        <div class="detail-row">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value font-semibold">${order.user.name}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">${order.user.email}</span>
                        </div>
                        ${order.user.phone ? `
                        <div class="detail-row">
                            <span class="detail-label">Phone:</span>
                            <span class="detail-value">${order.user.phone}</span>
                        </div>
                        ` : ''}
                    </div>
                </div>

                <!-- Service Details -->
                <div class="detail-section lg:col-span-2">
                    <h4 class="detail-section-title">
                        <i class="fas fa-cogs"></i>
                        Service Details
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <div class="detail-row">
                                <span class="detail-label">Service:</span>
                                <span class="detail-value font-bold">${order.service.name}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Material:</span>
                                <span class="detail-value font-semibold">${order.material}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Quantity:</span>
                                <span class="detail-value font-semibold">${order.quantity}</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            ${order.service.description ? `
                            <div class="detail-row flex-col items-start">
                                <span class="detail-label mb-2">Service Description:</span>
                                <p class="detail-value text-left leading-relaxed">${order.service.description}</p>
                            </div>
                            ` : ''}
                            ${order.service.price ? `
                            <div class="detail-row">
                                <span class="detail-label">Service Price:</span>
                                <span class="detail-value font-bold text-lg">$${parseFloat(order.service.price).toFixed(2)}</span>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>

                <!-- Uploaded File Section -->
                ${order.file_path ? `
                <div class="detail-section lg:col-span-2">
                    <h4 class="detail-section-title">
                        <i class="fas fa-file-upload"></i>
                        Uploaded File
                    </h4>
                    <div class="space-y-4">
                        ${order.file_exists !== false ? `
                        <div class="file-preview-card">
                            <div class="file-info">
                                <div class="flex items-center">
                                    <div class="file-icon">
                                        ${order.is_image || isImageFile(order.file_path) ? `
                                            <i class="fas fa-image"></i>
                                        ` : `
                                            <i class="fas fa-file"></i>
                                        `}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-primary-accent">${order.file_name || getFileName(order.file_path)}</p>
                                        <p class="text-sm text-complementary">
                                            ${order.is_image || isImageFile(order.file_path) ? 'Image File' : 'Document File'}
                                            ${order.file_size ? ` • ${(order.file_size / 1024).toFixed(1)} KB` : ''}
                                        </p>
                                    </div>
                                </div>
                                <div class="file-actions">
                                    ${order.is_image || isImageFile(order.file_path) ? `
                                        <button onclick="previewImage('/storage/${order.file_path}', '${order.file_name || getFileName(order.file_path)}', '${order.id}')" 
                                                class="file-action-btn btn-preview">
                                            <i class="fas fa-eye"></i>Preview
                                        </button>
                                    ` : ''}
                                    <a href="/storage/${order.file_path}" target="_blank" download 
                                       class="file-action-btn btn-download">
                                        <i class="fas fa-download"></i>Download
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Image Preview Container (hidden by default) -->
                            ${order.is_image || isImageFile(order.file_path) ? `
                                <div id="image-preview-${order.id}" class="hidden">
                                    <div class="image-preview-container">
                                        <div class="image-preview-header">
                                            <span class="image-preview-title">Image Preview: ${order.file_name || getFileName(order.file_path)}</span>
                                            <button onclick="hideImagePreview('${order.id}')" class="image-preview-close">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="text-center">
                                            <img src="/storage/${order.file_path}" alt="Order file preview" 
                                                 class="preview-image max-w-full h-auto max-h-96 mx-auto block"
                                                 onclick="window.open('/storage/${order.file_path}', '_blank')"
                                                 onerror="handleImageError(this, '${order.file_path}')"
                                                 onload="console.log('Image loaded successfully: /storage/${order.file_path}')">
                                            <p class="text-sm text-complementary mt-3 font-medium">Click image to view full size</p>
                                        </div>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                        ` : `
                        <div class="error-state">
                            <div class="flex items-center justify-center space-x-3 mb-2">
                                <i class="fas fa-exclamation-triangle text-2xl"></i>
                                <div>
                                    <p class="font-bold">File not found</p>
                                    <p class="text-sm">The uploaded file "${order.file_name || getFileName(order.file_path)}" could not be located.</p>
                                </div>
                            </div>
                        </div>
                        `}
                    </div>
                </div>
                ` : ''}

                <!-- Customer Notes -->
                ${order.notes ? `
                <div class="customer-notes-section lg:col-span-2">
                    <h4 class="detail-section-title mb-4">
                        <i class="fas fa-sticky-note"></i>
                        Customer Notes
                    </h4>
                    <div class="notes-content">
                        <p class="whitespace-pre-wrap">${order.notes}</p>
                    </div>
                </div>
                ` : ''}
            </div>
        `;
    }
    
    function previewImage(imagePath, fileName, orderId) {
        const previewContainer = document.getElementById(`image-preview-${orderId}`);
        
        if (previewContainer) {
            previewContainer.classList.remove('hidden');
            previewContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            // Fallback: open in new window if container not found
            window.open(imagePath, '_blank');
        }
    }
    
    function hideImagePreview(orderId) {
        const previewContainer = document.getElementById(`image-preview-${orderId}`);
        if (previewContainer) {
            previewContainer.classList.add('hidden');
        }
    }
    
    function closeOrderDetailsModal() {
        document.getElementById('order-details-modal').classList.add('hidden');
    }
    
    function getStatusClass(status) {
        switch (status) {
            case 'pending':
                return 'bg-yellow-100 text-yellow-800';
            case 'processing':
                return 'bg-blue-100 text-blue-800';
            case 'completed':
                return 'bg-green-100 text-green-800';
            case 'cancelled':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }
    
    function capitalizeFirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    function handleImageError(img, filePath) {
        console.error(`Error loading image: ${filePath}`);
        console.error(`Full URL attempted: ${img.src}`);
        console.error(`Current window location: ${window.location.origin}`);
        
        // Try alternative URL constructions
        const alternativeUrls = [
            `${window.location.origin}/storage/${filePath}`,
            `${window.location.protocol}//${window.location.host}/storage/${filePath}`,
            `/storage/${filePath}`
        ];
        
        console.log('Alternative URLs to try:', alternativeUrls);
        
        // Replace with error message
        img.parentElement.innerHTML = `
            <div class="text-center py-4">
                <p class="text-red-500 mb-2">Failed to load image</p>
                <p class="text-xs text-gray-500 mb-2">File: ${filePath}</p>
                <p class="text-xs text-gray-400">Check browser console for more details</p>
                <button onclick="retryImageLoad('${filePath}', this.parentElement)" 
                        class="mt-2 px-3 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">
                    Retry Load
                </button>
            </div>
        `;
    }
    
    function retryImageLoad(filePath, container) {
        const baseUrl = window.location.origin;
        const fullUrl = `${baseUrl}/storage/${filePath}`;
        
        console.log(`Retrying image load with URL: ${fullUrl}`);
        
        container.innerHTML = `
            <div class="text-center py-4">
                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
                <p class="mt-2 text-gray-600 text-xs">Retrying...</p>
            </div>
        `;
        
        const img = new Image();
        img.onload = function() {
            container.innerHTML = `
                <img src="${fullUrl}" alt="Order file preview" 
                     class="max-w-full h-auto max-h-96 rounded border shadow-sm mx-auto block cursor-pointer"
                     onclick="window.open('${fullUrl}', '_blank')">
                <p class="text-xs text-gray-500 mt-2">Click image to view full size</p>
            `;
        };
        img.onerror = function() {
            container.innerHTML = `
                <p class="text-red-500 text-center">Image still cannot be loaded</p>
                <p class="text-xs text-gray-500 text-center mt-1">URL: ${fullUrl}</p>
            `;
        };
        img.src = fullUrl;
    }
    
    // Close modal when clicking outside
    document.getElementById('order-details-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeOrderDetailsModal();
        }
    });
</script>
@endpush
