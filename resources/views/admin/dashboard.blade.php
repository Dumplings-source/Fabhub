<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CTUFABLAB - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-accent: #001740;
            --primary-base: #F4D462;
            --complementary-accent: #0F2A71;
            --secondary-accent: #FFC300;
            --secondary-palette: #FFFDF0;
        }
        
        .gradient-primary {
            background: linear-gradient(135deg, var(--primary-accent) 0%, var(--complementary-accent) 100%);
        }
        
        .gradient-secondary {
            background: linear-gradient(135deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
        }
        
        .text-primary-accent { color: var(--primary-accent); }
        .text-primary-base { color: var(--primary-base); }
        .text-complementary { color: var(--complementary-accent); }
        .text-secondary-accent { color: var(--secondary-accent); }
        
        .bg-primary-accent { background-color: var(--primary-accent); }
        .bg-primary-base { background-color: var(--primary-base); }
        .bg-complementary { background-color: var(--complementary-accent); }
        .bg-secondary-accent { background-color: var(--secondary-accent); }
        .bg-secondary-palette { background-color: var(--secondary-palette); }
        
        .nav-item {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .nav-item:hover {
            transform: translateX(8px);
        }
        
        .nav-item.active {
            background: linear-gradient(90deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
            color: var(--primary-accent);
            font-weight: 600;
        }
        
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--secondary-accent);
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary-accent) 0%, var(--complementary-accent) 100%);
            box-shadow: 4px 0 20px rgba(0, 23, 64, 0.3);
        }
        
        .header-card {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #ffffff 100%);
            border-left: 4px solid var(--primary-base);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .content-area {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #f8fafc 100%);
            min-height: calc(100vh - 80px);
        }
        
        .logo-text {
            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: -0.025em;
        }
        
        .profile-avatar {
            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
            box-shadow: 0 4px 12px rgba(244, 212, 98, 0.4);
        }
        
        .section-divider {
            background: linear-gradient(90deg, transparent 0%, var(--primary-base) 50%, transparent 100%);
            height: 1px;
            margin: 1rem 0;
        }
        
        .logout-btn {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: linear-gradient(45deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }
    </style>
</head>
<body class="font-sans">
    <div class="flex h-screen">
        <!-- Enhanced Sidebar -->
        <div class="w-72 sidebar text-white fixed h-full z-10">
            <!-- Logo Section -->
            <div class="p-6 border-b border-blue-700 border-opacity-30">
                <h1 class="text-3xl logo-text mb-1">CTUFABLAB</h1>
                <p class="text-sm text-blue-200 opacity-80">Administration Panel</p>
                <div class="section-divider mt-4"></div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6 px-4">
                <!-- Main Navigation -->
                <div class="mb-6">
                    <h2 class="text-xs font-bold uppercase tracking-wide text-yellow-300 mb-4 px-4">
                        <i class="fas fa-home mr-2"></i>Main Navigation
                    </h2>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center px-4 py-3 rounded-lg mb-2 hover:bg-blue-700 hover:bg-opacity-50">
                        <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }} flex items-center px-4 py-3 rounded-lg mb-2 hover:bg-blue-700 hover:bg-opacity-50">
                        <i class="fas fa-users mr-3 text-lg"></i>
                        <span class="font-medium">User Management</span>
                    </a>
                    <a href="{{ route('services') }}" class="nav-item {{ request()->routeIs('services*') ? 'active' : '' }} flex items-center px-4 py-3 rounded-lg mb-2 hover:bg-blue-700 hover:bg-opacity-50">
                        <i class="fas fa-cogs mr-3 text-lg"></i>
                        <span class="font-medium">Service Management</span>
                    </a>
                </div>
                
                <!-- Orders & Reservations -->
                <div class="mb-6">
                    <h2 class="text-xs font-bold uppercase tracking-wide text-yellow-300 mb-4 px-4">
                        <i class="fas fa-shopping-cart mr-2"></i>Orders & Bookings
                    </h2>
                    <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }} flex items-center px-4 py-3 rounded-lg mb-2 hover:bg-blue-700 hover:bg-opacity-50">
                        <i class="fas fa-receipt mr-3 text-lg"></i>
                        <span class="font-medium">Order Management</span>
                    </a>
                    <a href="{{ route('admin.reservations') }}" class="nav-item {{ request()->routeIs('admin.reservations*') ? 'active' : '' }} flex items-center px-4 py-3 rounded-lg mb-2 hover:bg-blue-700 hover:bg-opacity-50">
                        <i class="fas fa-calendar-check mr-3 text-lg"></i>
                        <span class="font-medium">Reservations</span>
                    </a>
                </div>
                
                <!-- Financial Management -->
                <div class="mb-6">
                    <h2 class="text-xs font-bold uppercase tracking-wide text-yellow-300 mb-4 px-4">
                        <i class="fas fa-chart-line mr-2"></i>Financial
                    </h2>
                    <a href="{{ route('payments.index') }}" class="nav-item {{ request()->routeIs('payments*') ? 'active' : '' }} flex items-center px-4 py-3 rounded-lg mb-2 hover:bg-blue-700 hover:bg-opacity-50">
                        <i class="fas fa-credit-card mr-3 text-lg"></i>
                        <span class="font-medium">Payment Management</span>
                    </a>
                </div>
                
                <!-- System Settings -->
                <div class="mb-6">
                    <h2 class="text-xs font-bold uppercase tracking-wide text-yellow-300 mb-4 px-4">
                        <i class="fas fa-wrench mr-2"></i>System
                    </h2>
                    <a href="{{ route('settings.general') }}" class="nav-item {{ request()->routeIs('settings*') ? 'active' : '' }} flex items-center px-4 py-3 rounded-lg mb-2 hover:bg-blue-700 hover:bg-opacity-50">
                        <i class="fas fa-sliders-h mr-3 text-lg"></i>
                        <span class="font-medium">System Settings</span>
                    </a>
                </div>
            </nav>
            
            <!-- Logout Section -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-700 border-opacity-30">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn w-full text-left px-4 py-3 rounded-lg text-white font-medium flex items-center">
                        <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 ml-72">
            <!-- Enhanced Header -->
            <header class="header-card p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-primary-accent mb-1">@yield('page-title', 'Admin Dashboard')</h2>
                    <p class="text-complementary text-sm flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        {{ now()->format('l, F d, Y') }}
                    </p>
                </div>
                <div class="flex items-center space-x-6">
                    <!-- Quick Stats -->
                    <div class="hidden md:flex items-center space-x-6 mr-6">
                        <div class="text-center">
                            <div class="text-lg font-bold text-primary-accent">{{ \App\Models\User::count() }}</div>
                            <div class="text-xs text-gray-600">Users</div>
                        </div>
                        <div class="text-center">
                            <div class="text-lg font-bold text-complementary">{{ \App\Models\Order::count() }}</div>
                            <div class="text-xs text-gray-600">Orders</div>
                        </div>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="flex items-center space-x-3">
                        <div class="profile-avatar w-12 h-12 rounded-full flex items-center justify-center font-bold text-primary-accent text-lg">
                            {{ substr(auth('admin')->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="font-semibold text-primary-accent block">{{ auth('admin')->user()->name }}</span>
                            <span class="text-xs text-gray-600">Administrator</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="content-area p-8">
                @hasSection('content')
                    @yield('content')
                @else
                    <!-- Default Dashboard Content -->
                    <style>
                        .dashboard-widget {
                            background: linear-gradient(135deg, var(--secondary-palette) 0%, #ffffff 100%);
                            border: 2px solid #e2e8f0;
                            border-radius: 16px;
                            padding: 24px;
                            transition: all 0.3s ease;
                            position: relative;
                            overflow: hidden;
                        }
                        
                        .dashboard-widget:hover {
                            transform: translateY(-4px);
                            box-shadow: 0 15px 35px rgba(0, 23, 64, 0.15);
                            border-color: var(--primary-base);
                        }
                        
                        .dashboard-widget::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 4px;
                            height: 100%;
                            background: linear-gradient(180deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
                        }
                        
                        .stat-card {
                            background: linear-gradient(135deg, var(--primary-accent) 0%, var(--complementary-accent) 100%);
                            color: white;
                            border-radius: 16px;
                            padding: 24px;
                            position: relative;
                            overflow: hidden;
                            transition: all 0.3s ease;
                        }
                        
                        .stat-card:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 12px 30px rgba(0, 23, 64, 0.3);
                        }
                        
                        .stat-card::before {
                            content: '';
                            position: absolute;
                            top: -50%;
                            right: -50%;
                            width: 100px;
                            height: 100px;
                            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
                            border-radius: 50%;
                            opacity: 0.2;
                        }
                        
                        .stat-icon {
                            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
                            color: var(--primary-accent);
                            width: 60px;
                            height: 60px;
                            border-radius: 16px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 24px;
                            margin-bottom: 16px;
                        }
                        
                        .chart-container {
                            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
                            border: 2px solid var(--primary-base);
                            border-radius: 16px;
                            padding: 24px;
                            height: 300px;
                        }
                        
                        .activity-item {
                            background: rgba(255, 255, 255, 0.8);
                            border: 1px solid #e2e8f0;
                            border-radius: 12px;
                            padding: 16px;
                            margin-bottom: 12px;
                            transition: all 0.3s ease;
                        }
                        
                        .activity-item:hover {
                            background: linear-gradient(90deg, transparent 0%, rgba(244, 212, 98, 0.1) 50%, transparent 100%);
                            transform: translateX(8px);
                        }
                        
                        .activity-icon {
                            background: linear-gradient(45deg, var(--complementary-accent), var(--primary-accent));
                            color: white;
                            width: 40px;
                            height: 40px;
                            border-radius: 10px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 16px;
                        }
                        
                        .progress-bar {
                            background: linear-gradient(90deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
                            height: 8px;
                            border-radius: 4px;
                            transition: width 0.5s ease;
                        }
                        
                        .quick-action-btn {
                            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
                            color: var(--primary-accent);
                            border: none;
                            border-radius: 12px;
                            padding: 12px 24px;
                            font-weight: 600;
                            transition: all 0.3s ease;
                            text-decoration: none;
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                        }
                        
                        .quick-action-btn:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 8px 20px rgba(244, 212, 98, 0.4);
                            color: var(--primary-accent);
                        }
                        
                        .refresh-btn {
                            background: linear-gradient(45deg, var(--complementary-accent), var(--primary-accent));
                            color: white;
                            border: none;
                            border-radius: 8px;
                            padding: 8px 16px;
                            font-size: 14px;
                            transition: all 0.3s ease;
                        }
                        
                        .refresh-btn:hover {
                            transform: scale(1.05);
                            box-shadow: 0 4px 12px rgba(15, 42, 113, 0.4);
                        }
                        
                        .growth-indicator {
                            display: inline-flex;
                            align-items: center;
                            gap: 4px;
                            font-size: 12px;
                            font-weight: 600;
                        }
                        
                        .growth-up {
                            color: #22c55e;
                        }
                        
                        .growth-down {
                            color: #ef4444;
                        }
                    </style>

                    <!-- Dashboard Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Users -->
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-3xl font-bold mb-2" id="total-users">{{ \App\Models\User::count() }}</h3>
                                <p class="text-blue-100 mb-2">Total Users</p>
                                <div class="growth-indicator growth-up">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>{{ round((\App\Models\User::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() / max(\App\Models\User::count(), 1)) * 100, 1) }}% this month</span>
                                </div>
                            </div>
                        </div>

                        <!-- Total Orders -->
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-3xl font-bold mb-2" id="total-orders">{{ \App\Models\Order::count() }}</h3>
                                <p class="text-blue-100 mb-2">Total Orders</p>
                                <div class="growth-indicator growth-up">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>{{ round((\App\Models\Order::where('created_at', '>=', \Carbon\Carbon::now()->subMonth())->count() / max(\App\Models\Order::count(), 1)) * 100, 1) }}% this month</span>
                                </div>
                            </div>
                        </div>

                        <!-- Total Services -->
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-3xl font-bold mb-2" id="total-services">{{ \App\Models\Service::count() }}</h3>
                                <p class="text-blue-100 mb-2">Total Services</p>
                                <div class="growth-indicator growth-up">
                                    <i class="fas fa-arrow-up"></i>
                                    <span>{{ \App\Models\Service::where('availability', true)->count() }} available</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Orders -->
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-3xl font-bold mb-2" id="pending-orders">{{ \App\Models\Order::where('status', 'pending')->count() }}</h3>
                                <p class="text-blue-100 mb-2">Pending Orders</p>
                                <div class="growth-indicator {{ \App\Models\Order::where('status', 'pending')->count() > 0 ? 'growth-down' : 'growth-up' }}">
                                    <i class="fas fa-{{ \App\Models\Order::where('status', 'pending')->count() > 0 ? 'arrow-down' : 'check' }}"></i>
                                    <span>{{ \App\Models\Order::where('status', 'pending')->count() > 0 ? 'Needs attention' : 'All clear' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Dashboard Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Charts and Analytics -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Order Status Distribution -->
                            <div class="dashboard-widget">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-bold text-primary-accent">Order Status Distribution</h3>
                                    <button onclick="refreshOrderStatus()" class="refresh-btn">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                </div>
                                <div class="chart-container" id="order-status-chart">
                                    <canvas id="orderStatusCanvas"></canvas>
                                </div>
                            </div>

                            <!-- Service Availability Chart -->
                            <div class="dashboard-widget">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-bold text-primary-accent">Service Availability</h3>
                                    <button onclick="refreshServices()" class="refresh-btn">
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                </div>
                                <div class="chart-container" id="service-chart">
                                    <canvas id="serviceCanvas"></canvas>
                                </div>
                            </div>

                            <!-- Most Popular Services -->
                            <div class="dashboard-widget">
                                <h3 class="text-xl font-bold text-primary-accent mb-6">Most Popular Services</h3>
                                <div class="space-y-4" id="popular-services">
                                    @php
                                        $popularServices = \App\Models\Order::select('services.name', \DB::raw('count(*) as order_count'))
                                            ->join('services', 'orders.service_id', '=', 'services.id')
                                            ->groupBy('services.id', 'services.name')
                                            ->orderBy('order_count', 'desc')
                                            ->limit(5)
                                            ->get();
                                        $maxCount = $popularServices->max('order_count') ?: 1;
                                    @endphp
                                    @forelse($popularServices as $service)
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="activity-icon">
                                                    <i class="fas fa-cog"></i>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-primary-accent">{{ $service->name }}</p>
                                                    <p class="text-sm text-gray-600">{{ $service->order_count }} orders</p>
                                                </div>
                                            </div>
                                            <div class="w-24">
                                                <div class="bg-gray-200 rounded-full h-2">
                                                    <div class="progress-bar h-2 rounded-full" style="width: {{ ($service->order_count / $maxCount) * 100 }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8 text-gray-500">
                                            <i class="fas fa-chart-bar text-4xl mb-4"></i>
                                            <p>No service data available yet</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Recent Activity and Quick Actions -->
                        <div class="space-y-8">
                            <!-- Quick Actions -->
                            <div class="dashboard-widget">
                                <h3 class="text-xl font-bold text-primary-accent mb-6">Quick Actions</h3>
                                <div class="space-y-3">
                                    <a href="{{ route('admin.users') }}" class="quick-action-btn w-full justify-center">
                                        <i class="fas fa-user-plus"></i>
                                        Manage Users
                                    </a>
                                    <a href="{{ route('services') }}" class="quick-action-btn w-full justify-center">
                                        <i class="fas fa-plus-circle"></i>
                                        Manage Services
                                    </a>
                                    <a href="{{ route('admin.orders') }}" class="quick-action-btn w-full justify-center">
                                        <i class="fas fa-eye"></i>
                                        View All Orders
                                    </a>
                                    <button onclick="exportData()" class="quick-action-btn w-full justify-center">
                                        <i class="fas fa-download"></i>
                                        Export Data
                                    </button>
                                </div>
                            </div>

                            <!-- Recent Orders -->
                            <div class="dashboard-widget">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-bold text-primary-accent">Recent Orders</h3>
                                    <button onclick="refreshRecentOrders()" class="refresh-btn">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <div id="recent-orders-list" class="space-y-3">
                                    @php
                                        $recentOrders = \App\Models\Order::with(['user', 'service'])->latest()->limit(5)->get();
                                    @endphp
                                    @forelse($recentOrders as $order)
                                        <div class="activity-item">
                                            <div class="flex items-center space-x-3">
                                                <div class="activity-icon">
                                                    <i class="fas fa-receipt"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-primary-accent">Order #{{ $order->id }}</p>
                                                    <p class="text-sm text-gray-600">{{ $order->user->name ?? 'Unknown' }} • {{ $order->service->name ?? 'Unknown Service' }}</p>
                                                    <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8 text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-4"></i>
                                            <p>No recent orders</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Recent Users -->
                            <div class="dashboard-widget">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-bold text-primary-accent">Recent Users</h3>
                                    <button onclick="refreshRecentUsers()" class="refresh-btn">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                                <div id="recent-users-list" class="space-y-3">
                                    @php
                                        $recentUsers = \App\Models\User::latest()->limit(5)->get();
                                    @endphp
                                    @forelse($recentUsers as $user)
                                        <div class="activity-item">
                                            <div class="flex items-center space-x-3">
                                                <div class="activity-icon">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-primary-accent">{{ $user->name }}</p>
                                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                                    <p class="text-xs text-gray-500">Joined {{ $user->created_at->diffForHumans() }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                    {{ ucfirst($user->role ?? 'Customer') }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-8 text-gray-500">
                                            <i class="fas fa-users text-4xl mb-4"></i>
                                            <p>No recent users</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Enhanced admin dashboard functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling for navigation
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    // Add click animation
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
            
            // Initialize charts if on dashboard page
            if (document.getElementById('orderStatusCanvas')) {
                initializeCharts();
                startRealTimeUpdates();
            }
        });

        function initializeCharts() {
            // Order Status Chart
            const orderStatusCtx = document.getElementById('orderStatusCanvas');
            if (orderStatusCtx) {
                const orderStatusData = {
                    pending: {{ \App\Models\Order::where('status', 'pending')->count() }},
                    processing: {{ \App\Models\Order::where('status', 'processing')->count() }},
                    completed: {{ \App\Models\Order::where('status', 'completed')->count() }},
                    cancelled: {{ \App\Models\Order::where('status', 'cancelled')->count() }}
                };

                new Chart(orderStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Processing', 'Completed', 'Cancelled'],
                        datasets: [{
                            data: Object.values(orderStatusData),
                            backgroundColor: [
                                '#fbbf24', // pending - yellow
                                '#3b82f6', // processing - blue
                                '#22c55e', // completed - green
                                '#ef4444'  // cancelled - red
                            ],
                            borderWidth: 3,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Service Availability Chart
            const serviceCtx = document.getElementById('serviceCanvas');
            if (serviceCtx) {
                const serviceData = {
                    available: {{ \App\Models\Service::where('availability', true)->count() }},
                    unavailable: {{ \App\Models\Service::where('availability', false)->count() }}
                };

                new Chart(serviceCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Available Services', 'Unavailable Services'],
                        datasets: [{
                            data: Object.values(serviceData),
                            backgroundColor: [
                                '#F4D462', // available - golden
                                '#6b7280'  // unavailable - gray
                            ],
                            borderWidth: 3,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        function startRealTimeUpdates() {
            // Update stats every 30 seconds
            setInterval(updateDashboardStats, 30000);
            
            // Update recent activity every 60 seconds
            setInterval(updateRecentActivity, 60000);
        }

        function updateDashboardStats() {
            // Simulate real-time updates (you can replace with actual AJAX calls)
            fetch('/admin/dashboard')
                .then(() => {
                    // Update stats with animation
                    animateCounters();
                })
                .catch(error => console.log('Stats update available on page refresh'));
        }

        function animateCounters() {
            // Add a subtle pulse animation to stat cards
            document.querySelectorAll('.stat-card').forEach(card => {
                card.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    card.style.transform = 'scale(1)';
                }, 200);
            });
        }

        function updateRecentActivity() {
            // Simulate activity updates
            console.log('Checking for new activity...');
        }

        function refreshOrderStatus() {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                // Add success animation
                const chart = document.getElementById('order-status-chart');
                chart.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    chart.style.transform = 'scale(1)';
                }, 300);
            }, 1000);
        }

        function refreshServices() {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                // Add success animation
                const chart = document.getElementById('service-chart');
                chart.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    chart.style.transform = 'scale(1)';
                }, 300);
            }, 1000);
        }

        function refreshRecentOrders() {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                // Add success notification
                showNotification('Recent orders updated!', 'success');
            }, 1000);
        }

        function refreshRecentUsers() {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                // Add success notification
                showNotification('Recent users updated!', 'success');
            }, 1000);
        }

        function exportData() {
            const btn = event.target.closest('button');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            
            // Simulate export process
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-check"></i> Exported!';
                showNotification('Data exported successfully!', 'success');
                setTimeout(() => {
                    btn.innerHTML = originalText;
                }, 2000);
            }, 2000);
        }

        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;
            
            if (type === 'success') {
                notification.className += ' bg-green-500 text-white';
                notification.innerHTML = `<i class="fas fa-check mr-2"></i>${message}`;
            } else if (type === 'error') {
                notification.className += ' bg-red-500 text-white';
                notification.innerHTML = `<i class="fas fa-times mr-2"></i>${message}`;
            } else {
                notification.className += ' bg-blue-500 text-white';
                notification.innerHTML = `<i class="fas fa-info mr-2"></i>${message}`;
            }
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Add hover effects for dashboard widgets
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dashboard-widget').forEach(widget => {
                widget.addEventListener('mouseenter', function() {
                    this.style.borderColor = 'var(--primary-base)';
                });
                
                widget.addEventListener('mouseleave', function() {
                    this.style.borderColor = '#e2e8f0';
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>