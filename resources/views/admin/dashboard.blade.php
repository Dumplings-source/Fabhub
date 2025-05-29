<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTUFABLAB - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white fixed h-full">
            <div class="p-4">
                <h1 class="text-2xl font-bold">CTUFABLAB</h1>
            </div>
            <nav class="mt-4">
                <div class="px-4 py-2">
                    <h2 class="text-sm font-semibold uppercase text-gray-400">Main</h2>
                    <a href="{{ route('admin.dashboard') }}" class="block mt-2 px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="block mt-2 px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users') ? 'bg-gray-700' : '' }}">User Management</a>
                    <a href="{{ route('services') }}" class="block mt-2 px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('services') ? 'bg-gray-700' : '' }}">Service Management</a>
                    <a href="{{ route('bookings.index') }}" class="block mt-2 px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('bookings.index') ? 'bg-gray-700' : '' }}">Bookings</a>
                    <a href="{{ route('payments.index') }}" class="block mt-2 px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('payments.index') ? 'bg-gray-700' : '' }}">Payments</a>
                </div>
                <div class="px-4 py-2 mt-4">
                    <h2 class="text-sm font-semibold uppercase text-gray-400">Settings</h2>
                    <a href="{{ route('settings.general') }}" class="block mt-2 px-4 py-2 rounded hover:bg-gray-700 {{ request()->routeIs('settings.general') ? 'bg-gray-700' : '' }}">General Settings</a>
                </div>
                <div class="px-4 py-2 mt-4">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-gray-700">Logout</button>
                    </form>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold">Dashboard</h2>
                    <p class="text-gray-600">{{ now()->format('F d, Y') }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- User Profile -->
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            {{ substr(auth('admin')->user()->name, 0, 1) }}
                        </div>
                        <span>{{ auth('admin')->user()->name }}</span>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-800">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>