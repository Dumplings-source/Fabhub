<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center">
                <div class="text-sm text-gray-600">
                    <a href="/" class="hover:text-primary transition-colors">Home</a> / <span class="font-medium">Dashboard</span>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Pusher for real-time updates -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Bar -->
            <div class="bg-white shadow-sm rounded-lg mb-6">
                <nav class="d-flex p-3 border-bottom" aria-label="Tabs">
                    <button onclick="showTab('dashboard')" id="dashboard-tab" class="btn fw-semibold me-3 {{ request()->is('dashboard') ? 'text-primary border-0' : 'text-secondary border-0' }}">
                        Dashboard
                    </button>
                    <a href="{{ route('service-catalog') }}" class="btn fw-semibold me-3 text-secondary border-0">
                        Service Catalog
                    </a>
                    <a href="{{ route('recent-orders') }}" class="btn fw-semibold me-3 text-secondary border-0">
                        Recent Orders
                    </a>
                    <button onclick="showTab('reservations')" id="reservations-tab" class="btn fw-semibold me-3 text-secondary border-0">
                        Reservations
                    </button>
                    <button onclick="showTab('notifications')" id="notifications-tab" class="btn fw-semibold me-3 text-secondary border-0">
                        Notifications
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div id="dashboard" class="tab-content">
                <!-- Welcome Section -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-light p-3 me-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h3 class="fs-4 fw-bold m-0">Welcome, {{ Auth::user()->name }}!</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light border-0 h-100 rounded shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-info-subtle p-2 me-3 text-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <h5 class="card-title mb-0 fs-6 fw-semibold">Active Orders</h5>
                                        </div>
                                        <p class="display-2 fw-bold text-info mb-2" id="active-orders-count">0</p>
                                        <p class="text-muted small mb-0">Orders currently being processed</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light border-0 h-100 rounded shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-success-subtle p-2 me-3 text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <h5 class="card-title mb-0 fs-6 fw-semibold">Completed Orders</h5>
                                        </div>
                                        <p class="display-2 fw-bold text-success mb-2" id="completed-orders-count">0</p>
                                        <p class="text-muted small mb-0">Successfully completed projects</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light border-0 h-100 rounded shadow-sm">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="rounded-circle bg-warning-subtle p-2 me-3 text-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h5 class="card-title mb-0 fs-6 fw-semibold">Pending Orders</h5>
                                        </div>
                                        <p class="display-2 fw-bold text-warning mb-2" id="pending-orders-count">0</p>
                                        <p class="text-muted small mb-0">Awaiting approval</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Services -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fs-5 fw-semibold mb-0">Featured Services</h3>
                            <a href="{{ route('service-catalog') }}" class="text-decoration-none">View all services</a>
                        </div>
                        
                        <div class="row g-3">
                            <!-- 3D Printing -->
                            <div class="col-md-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="https://readdy.ai/api/search-image?query=modern%25203D%2520printer%2520in%2520action%2520creating%2520a%2520detailed%2520prototype%2520with%2520vibrant%2520filament.%2520The%2520machine%2520is%2520shown%2520in%2520a%2520clean%2520workspace%2520with%2520soft%2520lighting%2520highlighting%2520the%2520printing%2520process.%2520The%2520image%2520has%2520a%2520professional%2520technical%2520feel%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=2&orientation=landscape" 
                                        alt="3D Printing Service" 
                                        class="card-img-top" 
                                        style="height: 130px; object-fit: cover;">
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2">3D Printing</h5>
                                        <p class="card-text small text-muted mb-2">
                                            Create physical objects from digital designs
                                        </p>
                                        <p class="text-primary fw-semibold small mb-3">₱150/hour</p>
                                        <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-primary w-100">Request</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Laser Cutting -->
                            <div class="col-md-3">
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
                                        <p class="text-primary fw-semibold small mb-3">₱200/hour</p>
                                        <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-primary w-100">Request</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Woodwork -->
                            <div class="col-md-3">
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
                                        <p class="text-primary fw-semibold small mb-3">₱250/hour</p>
                                        <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-primary w-100">Request</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Embroidery -->
                            <div class="col-md-3">
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
                                        <p class="text-primary fw-semibold small mb-3">₱180/hour</p>
                                        <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-primary w-100">Request</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links & Recent Activity -->
                <div class="row g-4">
                    <!-- Quick Links -->
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title fs-5 fw-semibold mb-3">Quick Links</h3>
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('service-catalog') }}" class="text-decoration-none">
                                        <div class="d-flex align-items-center p-2 rounded bg-light">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="fs-6 fw-semibold text-dark mb-0">Make a New Request</h5>
                                                <p class="text-muted small mb-0">Book a fabrication service</p>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ route('recent-orders') }}" class="text-decoration-none">
                                        <div class="d-flex align-items-center p-2 rounded bg-light">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="fs-6 fw-semibold text-dark mb-0">View Order History</h5>
                                                <p class="text-muted small mb-0">Check your past orders</p>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <a href="/profile/edit" class="text-decoration-none">
                                        <div class="d-flex align-items-center p-2 rounded bg-light">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="fs-6 fw-semibold text-dark mb-0">Edit Profile</h5>
                                                <p class="text-muted small mb-0">Update your information</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-md-8">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h3 class="card-title fs-5 fw-semibold mb-3">Recent Activity</h3>
                                <div id="recent-activity">
                                    <div class="border-start border-primary border-3 ps-3 py-2 mb-3">
                                        <div class="d-flex">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="fw-medium mb-1">Welcome to FabHub!</p>
                                                <p class="text-muted small mb-1">Explore our fabrication services and place your first order.</p>
                                                <small class="text-muted">Just now</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="activity-placeholder">
                                        <p class="text-muted small fst-italic">Your recent activities will appear here.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="reservations" class="tab-content d-none">
                <!-- Reservations -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="fs-5 fw-semibold mb-0">My Reservations</h3>
                            </div>
                            
                            <button onclick="showReservationForm()" class="btn btn-primary d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                New Reservation
                            </button>
                        </div>
                        
                        <!-- Reservation form (hidden by default) -->
                        <div id="reservation-form" class="card bg-light mb-4 d-none">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="fs-6 fw-semibold mb-0">Schedule a Equipment Reservation</h4>
                                    <button onclick="hideReservationForm()" class="btn-close" aria-label="Close"></button>
                                </div>
                                
                                <form id="create-reservation-form">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="equipment" class="form-label">Equipment</label>
                                            <select id="equipment" name="equipment" class="form-select">
                                                <option value="">Select equipment</option>
                                                <option value="3d_printer">3D Printer</option>
                                                <option value="laser_cutter">Laser Cutter</option>
                                                <option value="cnc_router">CNC Router</option>
                                                <option value="embroidery_machine">Embroidery Machine</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="reservation_date" class="form-label">Date</label>
                                            <input type="date" id="reservation_date" name="reservation_date" min="{{ date('Y-m-d') }}" class="form-control">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <select id="start_time" name="start_time" class="form-select">
                                                <option value="">Select time</option>
                                                <option value="09:00">9:00 AM</option>
                                                <option value="10:00">10:00 AM</option>
                                                <option value="11:00">11:00 AM</option>
                                                <option value="13:00">1:00 PM</option>
                                                <option value="14:00">2:00 PM</option>
                                                <option value="15:00">3:00 PM</option>
                                                <option value="16:00">4:00 PM</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="duration" class="form-label">Duration (hours)</label>
                                            <select id="duration" name="duration" class="form-select">
                                                <option value="1">1 hour</option>
                                                <option value="2">2 hours</option>
                                                <option value="3">3 hours</option>
                                                <option value="4">4 hours</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="purpose" class="form-label">Purpose</label>
                                            <textarea id="purpose" name="purpose" rows="2" class="form-control" placeholder="Briefly describe what you'll be working on"></textarea>
                                        </div>
                                        
                                        <div class="col-12 text-end">
                                            <button type="button" onclick="submitReservation()" class="btn btn-primary">
                                                Submit Reservation
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Reservations Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Reservation ID</th>
                                        <th>Equipment</th>
                                        <th>Date/Time</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="reservations-table-body">
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="rounded-circle bg-light p-3 mb-3 text-muted">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <p class="fw-medium mb-1">No reservations yet</p>
                                                <p class="text-gray-400">Schedule time on our fabrication equipment</p>
                                                <button onclick="showReservationForm()" class="btn btn-primary btn-sm d-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Create your first reservation
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="notifications" class="tab-content d-none">
                <!-- Notifications -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <h3 class="fs-5 fw-semibold mb-0">Notifications</h3>
                        </div>
                        
                        <div id="notifications-container">
                            <div class="card bg-light mb-3">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3 text-primary flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="card-title fs-6 fw-semibold mb-1">Welcome to FabHub!</h5>
                                            <p class="card-text mb-2">Explore our fabrication services and make your first order or reservation.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Just now</small>
                                                <button class="btn btn-sm btn-link p-0">Mark as read</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Single Back to Home Button -->
            <div class="text-center mt-4 mb-5">
                <a href="/" class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Back to Home Page</span>
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript for tab switching and functionality -->
    <script>
        // Tab switching functionality
        function showTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('d-none');
            });
            
            // Show the selected tab content
            document.getElementById(tabId).classList.remove('d-none');
            
            // Reset all tab buttons
            document.querySelectorAll('nav button').forEach(button => {
                button.classList.remove('text-primary');
                button.classList.add('text-secondary');
            });
            
            // Highlight the active tab button
            const activeButton = document.getElementById(tabId + '-tab');
            if (activeButton) {
                activeButton.classList.remove('text-secondary');
                activeButton.classList.add('text-primary');
            }
            
            // Update URL with the current tab (without reloading the page)
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            window.history.pushState({}, '', url);

            // Load data for the tab
            loadTabData(tabId);
        }

        // Clear notification dot when switching to orders tab
        function clearOrderNotification() {
            const dot = document.getElementById('orders-notification-dot');
            if (dot) dot.remove();
        }

        // Load data for each tab
        function loadTabData(tabId) {
            switch(tabId) {
                case 'dashboard':
                    loadDashboardStats();
                    loadRecentActivity();
                    break;
                case 'reservations':
                    loadReservations();
                    break;
                case 'notifications':
                    loadNotifications();
                    break;
            }
        }

        // Load dashboard stats
        function loadDashboardStats() {
            fetch('/api/orders')
                .then(response => response.json())
                .then(orders => {
                    const activeOrders = orders.filter(order => order.status === 'pending' || order.status === 'processing').length;
                    const completedOrders = orders.filter(order => order.status === 'completed').length;
                    const pendingOrders = orders.filter(order => order.status === 'pending').length;

                    document.getElementById('active-orders-count').textContent = activeOrders;
                    document.getElementById('completed-orders-count').textContent = completedOrders;
                    document.getElementById('pending-orders-count').textContent = pendingOrders;
                    
                    // If we have recent orders, populate the recent activity
                    if (orders.length > 0) {
                        loadRecentActivity(orders.slice(0, 3));
                    }
                })
                .catch(error => {
                    console.error('Error loading orders:', error);
                    showNotification('Error loading order statistics', 'error');
                });
        }
        
        // Load recent activity
        function loadRecentActivity(recentOrders) {
            if (!recentOrders || recentOrders.length === 0) {
                return;
            }
            
            const activityContainer = document.getElementById('recent-activity');
            const placeholder = document.getElementById('activity-placeholder');
            
            if (placeholder) {
                placeholder.remove();
            }
            
            recentOrders.forEach(order => {
                const activityElement = document.createElement('div');
                activityElement.className = 'flex items-start space-x-3 border-l-2 border-green-500 pl-3 py-1';
                
                let icon = '';
                let statusText = '';
                
                switch(order.status) {
                    case 'pending':
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                        statusText = 'Order Pending';
                        break;
                    case 'processing':
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>';
                        statusText = 'Order Processing';
                        break;
                    case 'completed':
                        icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                        statusText = 'Order Completed';
                        break;
                }
                
                activityElement.innerHTML = `
                    <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                        ${icon}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">${statusText}</p>
                        <p class="text-sm text-gray-500">Your order for ${order.service.name} is now ${order.status}</p>
                        <p class="text-xs text-gray-400 mt-1">${new Date(order.updated_at).toLocaleString()}</p>
                    </div>
                `;
                
                activityContainer.appendChild(activityElement);
            });
        }

        // Load reservations
        function loadReservations() {
            fetch('/api/reservations')
                .then(response => response.json())
                .then(reservations => {
                    const reservationsTable = document.querySelector('#reservations-table-body');
                    if (reservations.length === 0) {
                        reservationsTable.innerHTML = `
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <p class="font-medium">No reservations yet</p>
                                        <p class="text-gray-400">Schedule time on our fabrication equipment</p>
                                        <button onclick="showReservationForm()" class="mt-2 text-primary hover:text-primary/80 text-sm font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Create your first reservation
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    } else {
                        reservationsTable.innerHTML = reservations.map(reservation => `
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#${reservation.id}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    ${getEquipmentName(reservation.equipment_type)}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    ${formatDateTime(reservation.reservation_date, reservation.start_time)}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${reservation.duration} hours</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        ${getStatusClasses(reservation.status)}">
                                        ${capitalizeFirstLetter(reservation.status)}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${reservation.status === 'pending' ? `
                                        <button onclick="cancelReservation(${reservation.id})" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Cancel
                                        </button>
                                    ` : '-'}
                                </td>
                            </tr>
                        `).join('');
                    }
                })
                .catch(error => {
                    console.error('Error loading reservations:', error);
                    document.querySelector('#reservations-table-body').innerHTML = `
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-red-500 text-center">
                                Error loading reservations. Please try again later.
                            </td>
                        </tr>
                    `;
                });
        }

        // Helper function to format equipment name
        function getEquipmentName(type) {
            const equipmentTypes = {
                '3d_printer': '3D Printer',
                'laser_cutter': 'Laser Cutter',
                'cnc_router': 'CNC Router',
                'embroidery_machine': 'Embroidery Machine'
            };
            return equipmentTypes[type] || type;
        }
        
        // Helper function to format date and time
        function formatDateTime(date, time) {
            const formattedDate = new Date(date).toLocaleDateString();
            return `${formattedDate} at ${time}`;
        }
        
        // Helper function to get status classes
        function getStatusClasses(status) {
            switch(status) {
                case 'pending':
                    return 'bg-yellow-100 text-yellow-800';
                case 'approved':
                    return 'bg-green-100 text-green-800';
                case 'rejected':
                    return 'bg-red-100 text-red-800';
                case 'cancelled':
                    return 'bg-gray-100 text-gray-800';
                default:
                    return 'bg-blue-100 text-blue-800';
            }
        }
        
        // Helper function to capitalize first letter
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Load notifications
        function loadNotifications() {
            fetch('/api/notifications')
                .then(response => response.json())
                .then(notifications => {
                    const notificationsContainer = document.querySelector('#notifications-container');
                    if (notifications.length === 0) {
                        // Keep the welcome notification
                    } else {
                        // Clear the container first but keep the welcome notification
                        const welcomeNotification = notificationsContainer.querySelector(':first-child');
                        notificationsContainer.innerHTML = '';
                        notificationsContainer.appendChild(welcomeNotification);
                        
                        // Add the notifications
                        notifications.forEach(notification => {
                            const notificationElement = document.createElement('div');
                            notificationElement.className = 'flex items-start p-4 bg-blue-50 rounded-lg border border-blue-100';
                            
                            let icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                            
                            if (notification.type === 'order_update') {
                                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>';
                            } else if (notification.type === 'reservation_update') {
                                icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>';
                            }
                            
                            notificationElement.innerHTML = `
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex-shrink-0 flex items-center justify-center text-blue-600 mr-4">
                                    ${icon}
                                </div>
                                <div>
                                    <p class="font-medium text-blue-900">${notification.title}</p>
                                    <p class="text-blue-800 mt-1">${notification.message}</p>
                                    <div class="flex justify-between items-center mt-2">
                                        <p class="text-xs text-blue-600">${new Date(notification.created_at).toLocaleString()}</p>
                                        <button onclick="markNotificationAsRead(${notification.id})" class="text-xs text-blue-700 hover:text-blue-900">Mark as read</button>
                                    </div>
                                </div>
                            `;
                            
                            notificationsContainer.appendChild(notificationElement);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    document.querySelector('#notifications-container').innerHTML = `
                        <div class="bg-red-50 p-4 rounded-lg">
                            <p class="text-red-800">Error loading notifications. Please try again later.</p>
                        </div>
                    `;
                });
        }

        // Show/hide reservation form
        function showReservationForm() {
            document.getElementById('reservation-form').classList.remove('d-none');
        }
        
        function hideReservationForm() {
            document.getElementById('reservation-form').classList.add('d-none');
        }
        
        // Submit reservation
        function submitReservation() {
            const form = document.getElementById('create-reservation-form');
            const formData = new FormData(form);
            
            // Validate form
            const equipment = formData.get('equipment');
            const reservationDate = formData.get('reservation_date');
            const startTime = formData.get('start_time');
            
            if (!equipment || !reservationDate || !startTime) {
                showNotification('Please fill in all required fields', 'error');
                return;
            }
            
            // Submit form
            fetch('/api/reservations', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    equipment_type: formData.get('equipment'),
                    reservation_date: formData.get('reservation_date'),
                    start_time: formData.get('start_time'),
                    duration: formData.get('duration'),
                    purpose: formData.get('purpose')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Reservation submitted successfully!');
                    hideReservationForm();
                    form.reset();
                    loadReservations();
                } else {
                    showNotification(data.message || 'Error submitting reservation', 'error');
                }
            })
            .catch(error => {
                console.error('Error submitting reservation:', error);
                showNotification('Error submitting reservation. Please try again.', 'error');
            });
        }

        // Cancel reservation
        function cancelReservation(reservationId) {
            if (confirm('Are you sure you want to cancel this reservation?')) {
                fetch(`/api/reservations/${reservationId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadReservations();
                    showNotification('Reservation cancelled successfully!');
                })
                .catch(error => {
                    console.error('Error cancelling reservation:', error);
                    showNotification('Error cancelling reservation. Please try again.', 'error');
                });
            }
        }
        
        // Mark notification as read
        function markNotificationAsRead(notificationId) {
            fetch(`/api/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                loadNotifications();
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${type === 'success' 
                            ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                            : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                        }
                    </svg>
                    <span>${message}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="absolute top-1 right-1 text-white hover:text-gray-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;
            
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }

        // Load initial data
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Pusher
            const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true
            });
            
            // Subscribe to the user's channel
            const channel = pusher.subscribe('user-{{ Auth::id() }}');
            
            // Check URL parameters for active tab
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            
            if (tabParam && ['dashboard', 'reservations', 'notifications'].includes(tabParam)) {
                showTab(tabParam);
            } else if (window.location.pathname === '/dashboard') {
                loadTabData('dashboard');
            }
            
            // Show success message if exists
            @if (session('success'))
                const successMessage = "{{ session('success') }}";
                showNotification(successMessage);
            @endif
            
            // Listen for order status updates
            channel.bind('order-status-updated', function(data) {
                showNotification(`Your order for ${data.order.service.name} has been ${data.order.status}.`);
                loadDashboardStats();
            });
        });
    </script>
</x-app-layout>