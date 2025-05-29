<x-app-layout>
    <!-- Pusher for real-time updates -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    
    <!-- Import Tailwind directly -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Recent Activity Styling */
        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .activity-item {
            border-left: 3px solid #f8f9fa;
            padding-left: 15px;
            transition: all 0.3s ease;
        }
        
        .activity-item:hover {
            border-left-color: #ffc107;
            background-color: rgba(0,0,0,0.02);
        }
        
        #recent-activity {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }
    </style>
    
    <div class="container py-4">
        <!-- Dashboard Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-secondary text-light shadow border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-warning p-3 me-3 text-primary">
                                <i class="bi bi-stars fs-4"></i>
                            </div>
                            <h2 class="m-0 fs-3">Welcome, {{ Auth::user()->name }}!</h2>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm bg-primary">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-opacity-25 bg-light p-2 me-3">
                                                <i class="bi bi-file-earmark-text text-warning"></i>
                                            </div>
                                            <h5 class="card-title mb-0 fs-6 fw-semibold text-light">Active Orders</h5>
                                        </div>
                                        <p class="display-4 fw-bold mb-2 text-warning" id="active-orders-count">0</p>
                                        <p class="small mb-0 text-light opacity-75">Orders being processed</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm bg-secondary">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-opacity-25 bg-light p-2 me-3">
                                                <i class="bi bi-check-circle text-warning"></i>
                                            </div>
                                            <h5 class="card-title mb-0 fs-6 fw-semibold text-light">Completed Orders</h5>
                                        </div>
                                        <p class="display-4 fw-bold mb-2 text-warning" id="completed-orders-count">0</p>
                                        <p class="small mb-0 text-light opacity-75">Successfully completed projects</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card h-100 border-0 shadow-sm bg-warning">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-opacity-25 bg-primary p-2 me-3">
                                                <i class="bi bi-hourglass-split text-primary"></i>
                                            </div>
                                            <h5 class="card-title mb-0 fs-6 fw-semibold text-primary">Pending Orders</h5>
                                        </div>
                                        <p class="display-4 fw-bold mb-2 text-primary" id="pending-orders-count">0</p>
                                        <p class="small mb-0 text-primary opacity-75">Awaiting approval</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="row g-4">
            <!-- Left Sidebar - Quick Links -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm bg-secondary mb-4">
                    <div class="card-header bg-secondary text-light border-0">
                        <h5 class="mb-0 section-title">Navigation</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush rounded-0">
                            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active d-flex align-items-center">
                                <i class="bi bi-speedometer2 me-3"></i> Dashboard
                            </a>
                            <a href="{{ route('service-catalog') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-grid-3x3-gap me-3"></i> Service Catalog
                            </a>
                            <a href="{{ route('recent-orders') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-file-earmark-text me-3"></i> Recent Orders
                            </a>
                            <a href="{{ route('dashboard') }}?tab=reservations" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-calendar-check me-3"></i> Reservations
                            </a>
                            <a href="{{ route('dashboard') }}?tab=notifications" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-bell me-3"></i> Notifications
                            </a>
                            <a href="/profile/edit" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-person-circle me-3"></i> Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card border-0 shadow-sm bg-light mb-4">
                    <div class="card-header bg-warning text-primary border-0">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('service-catalog') }}" class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="bi bi-plus-circle me-2"></i> New Service Request
                            </a>
                            <a href="{{ route('recent-orders') }}" class="btn btn-secondary d-flex align-items-center justify-content-center">
                                <i class="bi bi-clock-history me-2"></i> View Order History
                            </a>
                        </div>
                    </div>
                </div>
                        </div>
                        
            <!-- Main Content Column -->
            <div class="col-lg-9">
                <!-- Featured Services -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 section-title">Featured Services</h5>
                        <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-warning text-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- 3D Printing -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="position-relative">
                                    <img src="https://readdy.ai/api/search-image?query=modern%25203D%2520printer%2520in%2520action%2520creating%2520a%2520detailed%2520prototype%2520with%2520vibrant%2520filament.%2520The%2520machine%2520is%2520shown%2520in%2520a%2520clean%2520workspace%2520with%2520soft%2520lighting%2520highlighting%2520the%2520printing%2520process.%2520The%2520image%2520has%2520a%2520professional%2520technical%2520feel%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=2&orientation=landscape" 
                                        alt="3D Printing Service" 
                                        class="card-img-top" 
                                        style="height: 130px; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 bg-warning text-primary m-2 px-2 py-1 rounded-pill">
                                            <small class="fw-bold">Popular</small>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2">3D Printing</h5>
                                        <p class="card-text small text-muted mb-2">
                                            Create physical objects from digital designs
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-primary border border-primary">₱150/hour</span>
                                            <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-primary">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Laser Cutting -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="https://readdy.ai/api/search-image?query=professional%2520laser%2520cutting%2520machine%2520precisely%2520cutting%2520a%2520pattern%2520into%2520a%2520sheet%2520of%2520material.%2520The%2520laser%2520beam%2520is%2520visible%2520with%2520a%2520slight%2520glow%2520as%2520it%2520works.%2520The%2520machine%2520is%2520in%2520a%2520clean%2520workspace%2520with%2520soft%2520lighting%2520and%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=3&orientation=landscape" 
                                        alt="Laser Cutting Service" 
                                        class="card-img-top" 
                                        style="height: 130px; object-fit: cover;">
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2">Laser Cutting</h5>
                                        <p class="card-text small text-muted mb-2">
                                            Precision cutting for various materials
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-primary border border-primary">₱200/hour</span>
                                            <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-primary">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Woodwork -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="https://readdy.ai/api/search-image?query=professional%2520woodworking%2520station%2520with%2520CNC%2520router%2520machine%2520carving%2520a%2520detailed%2520pattern%2520into%2520a%2520wooden%2520panel.%2520The%2520workspace%2520is%2520clean%2520with%2520wood%2520shavings%2520visible%2520around%2520the%2520project.%2520The%2520image%2520has%2520warm%2520tones%2520highlighting%2520the%2520natural%2520wood%2520material%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=4&orientation=landscape" 
                                        alt="Woodwork Service" 
                                        class="card-img-top" 
                                        style="height: 130px; object-fit: cover;">
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2">Woodwork</h5>
                                        <p class="card-text small text-muted mb-2">
                                            Custom woodworking and CNC routing
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-primary border border-primary">₱250/hour</span>
                                            <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-primary">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Embroidery -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="https://readdy.ai/api/search-image?query=modern%2520embroidery%2520machine%2520stitching%2520a%2520colorful%2520design%2520onto%2520fabric.%2520The%2520machine%2520is%2520shown%2520with%2520threads%2520of%2520various%2520colors%2520and%2520a%2520digital%2520control%2520panel.%2520The%2520image%2520shows%2520the%2520precision%2520of%2520the%2520needlework%2520in%2520a%2520clean%2520workspace%2520with%2520soft%2520lighting%2520and%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=5&orientation=landscape" 
                                        alt="Embroidery Service" 
                                        class="card-img-top" 
                                        style="height: 130px; object-fit: cover;">
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2">Embroidery</h5>
                                        <p class="card-text small text-muted mb-2">
                                            Custom embroidery for clothing and textiles
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-primary border border-primary">₱180/hour</span>
                                            <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-primary">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 section-title">Recent Activity</h5>
                        <span class="badge bg-warning text-primary rounded-pill">Live Updates</span>
                    </div>
                    <div class="card-body">
                        <div id="recent-activity">
                            <div class="border-start border-warning border-3 ps-3 py-2 mb-3">
                                <div class="d-flex">
                                    <div class="rounded-circle bg-warning p-2 me-3 flex-shrink-0 text-primary">
                                        <i class="bi bi-info-circle"></i>
                                    </div>
                                    <div>
                                        <p class="fw-medium mb-1">Welcome to FabHub!</p>
                                        <p class="text-muted small mb-1">Explore our fabrication services and place your first order.</p>
                                        <small class="text-muted">Just now</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="activity-placeholder" class="activity-item mb-3">
                                <div class="d-flex">
                                    <div class="activity-icon bg-warning me-3">
                                        <i class="bi bi-info-circle text-white"></i>
                                    </div>
                                    <div class="activity-content flex-grow-1">
                                        <p class="mb-1">Welcome to FabHub!</p>
                                        <p class="small mb-0">Explore our fabrication services and place your first order.</p>
                                        <p class="text-muted small mb-0">Just now</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- JavaScript for Order Counts and Real-time Updates -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get order counts
            fetch('/api/orders/counts')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('active-orders-count').textContent = data.active;
                    document.getElementById('completed-orders-count').textContent = data.completed;
                    document.getElementById('pending-orders-count').textContent = data.pending;
                })
                .catch(error => console.error('Error fetching order counts:', error));
                
            // Fetch recent activities
            fetch('/api/activities')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Activities data:', data);
                    // Remove placeholder if activities exist
                    if (data && data.length > 0) {
                        const placeholder = document.getElementById('activity-placeholder');
                        if (placeholder) {
                            placeholder.remove();
                        }
                        
                        // Display each activity
                        data.forEach(activity => {
                            displayActivity(activity);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching activities:', error);
                    
                    // Try the fallback endpoint
                    console.log('Trying fallback activity endpoint...');
                    fetch('/api/fallback-activity')
                        .then(response => response.json())
                        .then(data => {
                            console.log('Fallback activities data:', data);
                            
                            // Remove placeholder
                            const placeholder = document.getElementById('activity-placeholder');
                            if (placeholder) {
                                placeholder.remove();
                            }
                            
                            // Display each fallback activity
                            data.forEach(activity => {
                                displayActivity(activity);
                            });
                        })
                        .catch(fallbackError => {
                            console.error('Even fallback activity failed:', fallbackError);
                            
                            // Keep the placeholder visible with error message
                            const placeholder = document.getElementById('activity-placeholder');
                            if (placeholder) {
                                placeholder.innerHTML = '<p class="text-muted small fst-italic">Unable to load activities. Please try again later.</p>';
                            }
                            
                            // Add a hard-coded welcome message as absolute last resort
                            displayActivity({
                                type: 'welcome',
                                message: 'Welcome to FabHub!',
                                data: {details: 'Explore our fabrication services and place your first order.'},
                                created_at: new Date().toISOString()
                            });
                        });
                });

            // Setup Pusher for real-time updates
            try {
                const pusher = new Pusher('{{ config("broadcasting.connections.pusher.key") }}', {
                    cluster: '{{ config("broadcasting.connections.pusher.options.cluster") }}',
                    encrypted: true,
                    forceTLS: true
                });
                
                // Debug Pusher connection
                pusher.connection.bind('connected', function() {
                    console.log('Connected to Pusher');
                });
                
                pusher.connection.bind('error', function(err) {
                    console.error('Pusher connection error:', err);
                });

                // Listen for order status changes on the general orders channel
                const orderChannel = pusher.subscribe('orders');
                orderChannel.bind('order-status-changed', function(data) {
                    console.log('Order status changed event received:', data);
                    // Update order counts
                    fetch('/api/orders/counts')
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('active-orders-count').textContent = data.active;
                            document.getElementById('completed-orders-count').textContent = data.completed;
                            document.getElementById('pending-orders-count').textContent = data.pending;
                        });

                    // Add to recent activity
                    addActivity(data.message, data.timestamp, 'status-change');
                });
                
                // Subscribe to user-specific channel for order status updates
                try {
                    const userChannel = pusher.subscribe('user-{{ Auth::id() }}');
                    
                    userChannel.bind('pusher:subscription_succeeded', function() {
                        console.log('Successfully subscribed to user-{{ Auth::id() }} channel');
                    });
                    
                    userChannel.bind('pusher:subscription_error', function(error) {
                        console.error('Error subscribing to user channel:', error);
                    });
                    
                    // Debug all events on the user channel
                    userChannel.bind_global(function(eventName, data) {
                        console.log('User channel event received:', eventName, data);
                    });
                    
                    // Listen for order status updates with the custom event name
                    userChannel.bind('order.status.updated', function(data) {
                        console.log('Order status updated event received:', data);
                        
                        // Update order counts
                        fetch('/api/orders/counts')
                            .then(response => response.json())
                            .then(counts => {
                                document.getElementById('active-orders-count').textContent = counts.active;
                                document.getElementById('completed-orders-count').textContent = counts.completed;
                                document.getElementById('pending-orders-count').textContent = counts.pending;
                            });
                        
                        // Get status description
                        let statusText = data.currentStatus;
                        if (statusText === 'processing') statusText = 'being processed';
                        if (statusText === 'completed') statusText = 'completed';
                        if (statusText === 'cancelled') statusText = 'cancelled';
                        
                        // Add to recent activity
                        const message = `Your order #${data.order.id} for ${data.order.service.name} is now ${statusText}`;
                        const timestamp = new Date().toISOString();
                        
                        addActivity(message, timestamp, 'status-change');
                    });
                } catch (channelError) {
                    console.error('Error setting up user channel:', channelError);
                }
            } catch (pusherError) {
                console.error('Error initializing Pusher:', pusherError);
                
                // Add a visual error indicator in the recent activity section
                const activityContainer = document.getElementById('recent-activity');
                const errorHTML = `
                    <div class="alert alert-warning">
                        <p><i class="bi bi-exclamation-triangle-fill me-2"></i> Unable to connect to real-time updates.</p>
                        <small>You may need to refresh the page to see new activities.</small>
                    </div>
                `;
                
                if (activityContainer) {
                    activityContainer.insertAdjacentHTML('afterbegin', errorHTML);
                }
            }

            // Listen for new orders
            orderChannel.bind('new-order', function(data) {
                // Add to recent activity
                addActivity('New order placed: ' + data.service_name, data.timestamp, 'new-order');
                
                // Update order counts
                fetch('/api/orders/counts')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-orders-count').textContent = data.pending;
                    });
            });

            // Listen for the custom orderCreated event
            document.addEventListener('orderCreated', function() {
                // Add to recent activity
                const now = new Date();
                addActivity('You placed a new service request', now.toISOString(), 'new-order');
                
                // Update order counts after a short delay to allow server to process
                setTimeout(() => {
                    fetch('/api/orders/counts')
                .then(response => response.json())
                        .then(data => {
                            document.getElementById('pending-orders-count').textContent = data.pending;
                        });
                }, 1000);
            });

            // Function to display an activity from the API
            function displayActivity(activity) {
                // Safety check
                if (!activity) return;
                
                const activityContainer = document.getElementById('recent-activity');
                if (!activityContainer) return;
                
                // Set default values for potentially missing properties
                activity = {
                    type: activity.type || 'system',
                    message: activity.message || 'System notification',
                    data: activity.data || {},
                    created_at: activity.created_at || new Date().toISOString()
                };
                
                let iconClass = 'bi-info-circle';
                let bgClass = 'bg-warning';
                
                // Set icon based on activity type
                switch (activity.type) {
                    case 'order':
                        iconClass = 'bi-plus-circle';
                        bgClass = 'bg-primary';
                        break;
                    case 'status-change':
                        iconClass = 'bi-arrow-clockwise';
                        bgClass = 'bg-info';
                        break;
                    case 'login':
                        iconClass = 'bi-box-arrow-in-right';
                        bgClass = 'bg-secondary';
                        break;
                    case 'notification':
                        iconClass = 'bi-bell';
                        bgClass = 'bg-info';
                        break;
                    case 'welcome':
                        iconClass = 'bi-hand-thumbs-up';
                        bgClass = 'bg-success';
                        break;
                    case 'system':
                        iconClass = 'bi-info-circle';
                        bgClass = 'bg-warning';
                        break;
                }
                
                // Format date - handle both string timestamps and Date objects
                let date;
                try {
                    date = activity.created_at ? new Date(activity.created_at) : new Date();
                } catch (e) {
                    date = new Date();
                }
                
                // Format the timestamp
                let timeDisplay;
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.floor(diffMs / 60000);
                
                if (diffMins < 1) {
                    timeDisplay = 'Just now';
                } else if (diffMins < 60) {
                    timeDisplay = `${diffMins} ${diffMins === 1 ? 'minute' : 'minutes'} ago`;
                } else if (diffMins < 1440) {
                    const hours = Math.floor(diffMins / 60);
                    timeDisplay = `${hours} ${hours === 1 ? 'hour' : 'hours'} ago`;
                } else {
                    timeDisplay = date.toLocaleDateString();
                }
                
                // Get additional details from data if available
                let details = '';
                if (activity.data && typeof activity.data === 'object') {
                    // Handle various data formats
                    if (activity.data.details) {
                        details = `<p class="small mb-0">${activity.data.details}</p>`;
                    } else if (activity.data.service) {
                        details = `<p class="small mb-0">Service: ${activity.data.service}</p>`;
                    } else if (activity.data.order_id) {
                        details = `<p class="small mb-0">Order #${activity.data.order_id}</p>`;
                    }
                }
                
                // Create the activity HTML
                const activityHTML = `
                    <div class="activity-item mb-3">
                        <div class="d-flex">
                            <div class="activity-icon ${bgClass} me-3">
                                <i class="bi ${iconClass} text-white"></i>
                            </div>
                            <div class="activity-content flex-grow-1">
                                <p class="mb-1">${activity.message}</p>
                                ${details}
                                <p class="text-muted small mb-0">${timeDisplay}</p>
                            </div>
                        </div>
                    </div>
                `;
                
                // Add to the activity container
                activityContainer.insertAdjacentHTML('beforeend', activityHTML);
            }

            // Function to add a new activity to the display
            function addActivity(message, timestamp, type, details = null) {
                const activity = {
                    type: type || 'notification',
                    message: message,
                    created_at: timestamp || new Date().toISOString(),
                    data: details ? { details: details } : null
                };
                
                // Display the activity in the UI
                displayActivity(activity);
                
                // Remove the placeholder if it exists
                const placeholder = document.getElementById('activity-placeholder');
                if (placeholder) {
                    placeholder.remove();
                }
                
                // Optional: Log the activity to the server
                fetch('/api/activities', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(activity)
                })
                .then(response => response.json())
                .catch(error => console.error('Error logging activity:', error));
            }
        });
    </script>
</x-app-layout>