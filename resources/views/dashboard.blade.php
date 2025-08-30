<x-app-layout>
    <!-- Pusher for real-time updates -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    
    <!-- Import Tailwind directly -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* CTU FABLAB Font Styling - Matching Admin Dashboard */
        body {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', sans-serif !important;
        }
        
        .font-sans {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', sans-serif !important;
        }
        
        /* Enhanced Dashboard Styling with CTU FABLAB Typography */
        :root {
            --primary-blue: #1e3a8a;
            --secondary-blue: #3b82f6;
            --accent-yellow: #fbbf24;
            --success-green: #10b981;
            --warning-orange: #f59e0b;
            --danger-red: #ef4444;
            --light-bg: #f8fafc;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
            --gradient-primary: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            --gradient-secondary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        /* Enhanced Card Styling */
        .enhanced-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .enhanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .enhanced-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-shadow-hover);
        }

        .enhanced-card:hover::before {
            opacity: 1;
        }

        /* Enhanced Order Count Cards */
        .order-count-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .order-count-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .order-count-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .order-count-card.active-orders {
            background: var(--gradient-primary);
            color: white;
        }

        .order-count-card.completed-orders {
            background: var(--gradient-secondary);
            color: white;
        }

        .order-count-card.pending-orders {
            background: var(--gradient-warning);
            color: #1f2937;
        }

        /* Enhanced Icons */
        .order-icon {
            width: 60px;
            height: 60px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .order-count-card:hover .order-icon {
            transform: scale(1.1) rotate(5deg);
            background: rgba(255, 255, 255, 0.3);
        }

        /* Enhanced Numbers */
        .order-number {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1;
            margin: 1rem 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .order-count-card:hover .order-number {
            transform: scale(1.05);
        }

        /* Enhanced Navigation Sidebar */
        .nav-sidebar {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .nav-sidebar .list-group-item {
            border: none;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            background: transparent;
        }

        .nav-sidebar .list-group-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--gradient-primary);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .nav-sidebar .list-group-item:hover,
        .nav-sidebar .list-group-item.active {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            color: var(--primary-blue);
            transform: translateX(8px);
        }

        .nav-sidebar .list-group-item:hover::before,
        .nav-sidebar .list-group-item.active::before {
            transform: scaleY(1);
        }

        /* Enhanced Service Cards */
        .service-card-enhanced {
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            background: white;
            position: relative;
        }

        .service-card-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.05) 0%, rgba(59, 130, 246, 0.02) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .service-card-enhanced:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .service-card-enhanced:hover::before {
            opacity: 1;
        }

        .service-image {
            height: 180px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .service-card-enhanced:hover .service-image {
            transform: scale(1.1);
        }

        /* Enhanced Buttons */
        .btn-enhanced {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-enhanced:hover::before {
            left: 100%;
        }

        .btn-enhanced:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-primary-enhanced {
            background: var(--gradient-primary);
            color: white;
        }

        .btn-warning-enhanced {
            background: var(--gradient-warning);
            color: #1f2937;
        }

        /* Enhanced Activity Section */
        .activity-section {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .activity-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1.5rem;
            position: relative;
        }

        .activity-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        /* Recent Activity Styling */
        .activity-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .activity-icon::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .activity-item:hover .activity-icon::before {
            opacity: 1;
        }
        
        .activity-item {
            border-left: 3px solid transparent;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            margin-bottom: 0.5rem;
            border-radius: 0 12px 12px 0;
        }
        
        .activity-item:hover {
            border-left-color: var(--accent-yellow);
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.05) 0%, rgba(251, 191, 36, 0.02) 100%);
            transform: translateX(8px);
        }

        .activity-item:hover .activity-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        #recent-activity {
            max-height: 500px;
            overflow-y: auto;
            padding: 1rem;
        }

        /* Custom Scrollbar */
        #recent-activity::-webkit-scrollbar {
            width: 6px;
        }

        #recent-activity::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #recent-activity::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: 3px;
        }

        #recent-activity::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-blue);
        }

        /* Enhanced Welcome Section */
        .welcome-section {
            background: var(--gradient-primary);
            border-radius: 24px;
            padding: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-right: 1.5rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .welcome-section:hover .welcome-icon {
            transform: scale(1.1) rotate(10deg);
            background: rgba(255, 255, 255, 0.3);
        }

        /* Enhanced Test Button */
        .test-api-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .test-api-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white;
        }

        /* Enhanced Badges */
        .badge-enhanced {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        /* Responsive Enhancements */
        @media (max-width: 768px) {
            .order-count-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .order-number {
                font-size: 2.5rem;
            }
            
            .welcome-section {
                padding: 1.5rem;
            }
            
            .welcome-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                margin-right: 1rem;
            }
        }

        /* Loading Animation */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Enhanced Section Headers */
        .section-header {
            background: var(--gradient-primary);
            color: white;
            padding: 1.5rem;
            border-radius: 16px 16px 0 0;
            position: relative;
            overflow: hidden;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        /* Pulse Animation for Live Updates */
        .live-indicator {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
    
    <div class="container py-4 font-sans">
        <!-- Dashboard Overview -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card welcome-section border-0 shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="welcome-icon">
                                <i class="bi bi-stars"></i>
                            </div>
                            <div>
                                <h2 class="m-0 fs-3 font-sans" style="font-weight: 700; letter-spacing: 0.5px;">Welcome, {{ Auth::user()->name }}!</h2>
                                <small class="text-light opacity-75 font-sans">User ID: {{ Auth::user()->id }} | Email: {{ Auth::user()->email }}</small>
                            </div>
                            <div class="ms-auto">
                               
                            </div>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="order-count-card active-orders h-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="order-icon">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-0 fs-6 fw-semibold font-sans">Active Orders</h5>
                                    <p class="order-number font-sans" id="active-orders-count">0</p>
                                    <p class="small mb-0 opacity-75 font-sans">Orders being processed</p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="order-count-card completed-orders h-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="order-icon">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-0 fs-6 fw-semibold font-sans">Completed Orders</h5>
                                    <p class="order-number font-sans" id="completed-orders-count">0</p>
                                    <p class="small mb-0 opacity-75 font-sans">Successfully completed projects</p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="order-count-card pending-orders h-100">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="order-icon">
                                            <i class="bi bi-hourglass-split"></i>
                                        </div>
                                    </div>
                                    <h5 class="mb-0 fs-6 fw-semibold font-sans">Pending Orders</h5>
                                    <p class="order-number font-sans" id="pending-orders-count">0</p>
                                    <p class="small mb-0 opacity-75 font-sans">Awaiting approval</p>
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
                <div class="nav-sidebar enhanced-card mb-4">
                    <div class="card-header section-header border-0">
                        <h5 class="mb-0 font-sans" style="font-weight: 600;">Navigation</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush rounded-0">
                            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active d-flex align-items-center font-sans">
                                <i class="bi bi-speedometer2 me-3"></i> Dashboard
                            </a>
                            <a href="{{ route('service-catalog') }}" class="list-group-item list-group-item-action d-flex align-items-center font-sans">
                                <i class="bi bi-grid-3x3-gap me-3"></i> Service Catalog
                            </a>
                            <a href="{{ route('recent-orders') }}" class="list-group-item list-group-item-action d-flex align-items-center font-sans">
                                <i class="bi bi-file-earmark-text me-3"></i> Recent Orders
                            </a>
                            <a href="{{ route('customer.reservations') }}" class="list-group-item list-group-item-action d-flex align-items-center font-sans">
                                <i class="bi bi-calendar-check me-3"></i> Reservations
                            </a>
                         
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="enhanced-card mb-4">
                    <div class="card-header section-header border-0">
                        <h5 class="mb-0 font-sans" style="font-weight: 600;">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('service-catalog') }}" class="btn btn-enhanced btn-primary-enhanced d-flex align-items-center justify-content-center font-sans">
                                <i class="bi bi-plus-circle me-2"></i> New Service Request
                            </a>
                            <a href="{{ route('customer.reservations') }}" class="btn btn-enhanced btn-warning-enhanced d-flex align-items-center justify-content-center font-sans">
                                <i class="bi bi-calendar-check me-2"></i> Make Reservation
                            </a>
                            <a href="{{ route('recent-orders') }}" class="btn btn-enhanced btn-warning-enhanced d-flex align-items-center justify-content-center font-sans">
                                <i class="bi bi-clock-history me-2"></i> View Order History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Column -->
            <div class="col-lg-9">
                <!-- Featured Services -->
                <div class="enhanced-card mb-4">
                    <div class="card-header section-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-sans" style="font-weight: 600;">Featured Services</h5>
                        <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-enhanced btn-warning-enhanced font-sans">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- 3D Printing -->
                            <div class="col-md-6 col-lg-3">
                                <div class="service-card-enhanced h-100">
                                    <div class="position-relative">
                                    <img src="https://readdy.ai/api/search-image?query=modern%25203D%2520printer%2520in%2520action%2520creating%2520a%2520detailed%2520prototype%2520with%2520vibrant%2520filament.%2520The%2520machine%2520is%2520shown%2520in%2520a%2520clean%2520workspace%2520with%2520soft%2520lighting%2520highlighting%2520the%2520printing%2520process.%2520The%2520image%2520has%2520a%2520professional%2520technical%2520feel%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=2&orientation=landscape" 
                                        alt="3D Printing Service" 
                                        class="card-img-top service-image">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge badge-enhanced bg-warning text-primary">Popular</span>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2 font-sans">3D Printing</h5>
                                        <p class="card-text small text-muted mb-2 font-sans">
                                            Create physical objects from digital designs
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge badge-enhanced bg-light text-primary border border-primary font-sans">₱150/hour</span>
                                            <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-enhanced btn-primary-enhanced font-sans">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Laser Cutting -->
                            <div class="col-md-6 col-lg-3">
                                <div class="service-card-enhanced h-100">
                                    <img src="https://readdy.ai/api/search-image?query=professional%2520laser%2520cutting%2520machine%2520precisely%2520cutting%2520a%2520pattern%2520into%2520a%2520sheet%2520of%2520material.%2520The%2520laser%2520beam%2520is%2520visible%2520with%2520a%2520slight%2520glow%2520as%2520it%2520works.%2520The%2520machine%2520is%2520in%2520a%2520clean%2520workspace%2520with%2520soft%2520lighting%2520and%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=3&orientation=landscape" 
                                        alt="Laser Cutting Service" 
                                        class="card-img-top service-image">
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2">Laser Cutting</h5>
                                        <p class="card-text small text-muted mb-2">
                                            Precision cutting for various materials
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge badge-enhanced bg-light text-primary border border-primary">₱200/hour</span>
                                            <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-enhanced btn-primary-enhanced">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Woodwork -->
                            <div class="col-md-6 col-lg-3">
                                <div class="service-card-enhanced h-100">
                                    <img src="https://readdy.ai/api/search-image?query=professional%2520woodworking%2520station%2520with%2520CNC%2520router%2520machine%2520carving%2520a%2520detailed%2520pattern%2520into%2520a%2520wooden%2520panel.%2520The%2520workspace%2520is%2520clean%2520with%2520wood%2520shavings%2520visible%2520around%2520the%2520project.%2520The%2520image%2520has%2520warm%2520tones%2520highlighting%2520the%2520natural%2520wood%2520material%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=4&orientation=landscape" 
                                        alt="Woodwork Service" 
                                        class="card-img-top service-image">
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2">Woodwork</h5>
                                        <p class="card-text small text-muted mb-2">
                                            Custom woodworking and CNC routing
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge badge-enhanced bg-light text-primary border border-primary">₱250/hour</span>
                                            <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-enhanced btn-primary-enhanced">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Embroidery -->
                            <div class="col-md-6 col-lg-3">
                                <div class="service-card-enhanced h-100">
                                <img src="https://readdy.ai/api/search-image?query=modern%2520digital%2520embroidery%2520machine%2520stitching%2520a%2520colorful%2520design%2520onto%2520fabric.%2520The%2520machine%2520is%2520shown%2520mid-process%2520with%2520thread%2520spools%2520visible%2520and%2520a%2520partially%2520completed%2520design.%2520The%2520workspace%2520is%2520clean%2520and%2520well-lit%2520with%2520a%2520simple%2520light%2520background.&width=600&height=400&seq=5&orientation=landscape
                                alt="Embroidery"
                                        class="card-img-top service-image">
                                    <div class="card-body p-3">
                                        <h5 class="card-title fs-6 fw-semibold mb-2">Embroidery</h5>
                                        <p class="card-text small text-muted mb-2">
                                            Custom embroidery for clothing and textiles
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge badge-enhanced bg-light text-primary border border-primary">₱180/hour</span>
                                            <a href="{{ route('service-catalog') }}" class="btn btn-sm btn-enhanced btn-primary-enhanced">Request</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="activity-section">
                    <div class="activity-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-sans" style="font-weight: 600;">Recent Activity</h5>
                        <span class="badge badge-enhanced bg-warning text-primary live-indicator font-sans">Live Updates</span>
                    </div>
                    <div class="card-body">
                        <div id="recent-activity">
                            <div class="border-start border-warning border-3 ps-3 py-2 mb-3">
                                <div class="d-flex">
                                    <div class="rounded-circle bg-warning p-2 me-3 flex-shrink-0 text-primary">
                                        <i class="bi bi-info-circle"></i>
                                    </div>
                                    <div>
                                        <p class="fw-medium mb-1 font-sans" style="color: var(--primary-blue);">Welcome to FabHub!</p>
                                        <p class="small mb-1 font-sans" style="color: var(--primary-blue);">Explore our fabrication services and place your first order.</p>
                                        <small class="text-muted font-sans">Just now</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="activity-placeholder" class="activity-item mb-3">
                                <div class="d-flex">
                                    <div class="activity-icon bg-warning me-3">
                                        <i class="bi bi-info-circle text-white"></i>
                                    </div>
                                    <div class="activity-content flex-grow-1">
                                        <p class="mb-1 font-sans" style="color: var(--primary-blue);">Welcome to FabHub!</p>
                                        <p class="small mb-0 font-sans" style="color: var(--primary-blue);">Explore our fabrication services and place your first order.</p>
                                        <p class="text-muted small mb-0 font-sans">Just now</p>
                                    </div>
                                </div>
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
            // Get order counts with enhanced error handling
            fetch('/api/orders/counts', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                credentials: 'same-origin'
            })
                .then(response => {
                    console.log('Order counts response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Order counts data:', data);
                    document.getElementById('active-orders-count').textContent = data.active || 0;
                    document.getElementById('completed-orders-count').textContent = data.completed || 0;
                    document.getElementById('pending-orders-count').textContent = data.pending || 0;
                })
                .catch(error => {
                    console.error('Error fetching order counts:', error);
                    // Fallback: try to get counts from server-side if API fails
                    console.log('Attempting fallback method...');
                    fetchOrderCountsFallback();
                });
                
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
                        details = `<p class="small mb-0" style="color: var(--primary-blue);">${activity.data.details}</p>`;
                    } else if (activity.data.service) {
                        details = `<p class="small mb-0" style="color: var(--primary-blue);">Service: ${activity.data.service}</p>`;
                    } else if (activity.data.order_id) {
                        details = `<p class="small mb-0" style="color: var(--primary-blue);">Order #${activity.data.order_id}</p>`;
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
                                <p class="mb-1" style="color: var(--primary-blue);">${activity.message}</p>
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

            // Test function to debug order counts API
            function testOrderCountsAPI() {
                console.log('Testing order counts API...');
                fetch('/api/test-order-counts', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    console.log('Test API response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Test API data:', data);
                    alert('API Test Results:\n' + JSON.stringify(data, null, 2));
                })
                .catch(error => {
                    console.error('Test API error:', error);
                    alert('API Test Failed: ' + error.message);
                });
            }
            
            // Fallback function to get order counts via a different method
            function fetchOrderCountsFallback() {
                // Try alternative endpoint or use server-side data
                const serverSideCounts = {
                    active: {{ Auth::user()->orders()->where('status', 'processing')->count() }},
                    completed: {{ Auth::user()->orders()->where('status', 'completed')->count() }},
                    pending: {{ Auth::user()->orders()->where('status', 'pending')->count() }}
                };
                
                console.log('Using server-side fallback counts:', serverSideCounts);
                document.getElementById('active-orders-count').textContent = serverSideCounts.active;
                document.getElementById('completed-orders-count').textContent = serverSideCounts.completed;
                document.getElementById('pending-orders-count').textContent = serverSideCounts.pending;
            }
        });
    </script>
</x-app-layout>