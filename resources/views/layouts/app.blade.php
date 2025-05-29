<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
        <!-- Custom Colors CSS -->
        <link href="{{ asset('css/custom-colors.css') }}" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: { 
                            primary: "#001740", 
                            "primary-light": "#F4D462",
                            secondary: "#0F2A71",
                            "secondary-yellow": "#F5C400",
                            "secondary-light": "#FFFDF0"
                        },
                        borderRadius: {
                            none: "0px",
                            sm: "4px",
                            DEFAULT: "8px",
                            md: "12px",
                            lg: "16px",
                            xl: "20px",
                            "2xl": "24px",
                            "3xl": "32px",
                            full: "9999px",
                            button: "8px",
                        },
                    },
                },
            };
        </script>
        
        <style>
            :root {
                --primary-dark: #001740;
                --primary-light: #F4D462;
                --secondary-accent: #0F2A71;
                --secondary-yellow: #F5C400;
                --secondary-light: #FFFDF0;
                
                --bs-primary: #001740;
                --bs-primary-rgb: 0, 23, 64;
                --bs-secondary: #0F2A71;
                --bs-secondary-rgb: 15, 42, 113;
                --bs-warning: #F4D462;
                --bs-warning-rgb: 244, 212, 98;
                --bs-yellow: #F5C400;
                --bs-yellow-rgb: 245, 196, 0;
                --bs-light: #FFFDF0;
                --bs-light-rgb: 255, 253, 240;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                color: var(--secondary-light);
                background-color: var(--primary-dark);
                background-image: 
                    radial-gradient(circle at 25% 25%, rgba(15, 42, 113, 0.2) 0%, transparent 50%),
                    radial-gradient(circle at 75% 75%, rgba(15, 42, 113, 0.15) 0%, transparent 50%),
                    linear-gradient(135deg, rgba(0, 23, 64, 0.9) 0%, rgba(0, 23, 64, 1) 100%);
                background-attachment: fixed;
            }
            
            .bg-primary {
                background-color: var(--primary-dark) !important;
            }
            
            .bg-secondary {
                background-color: var(--secondary-accent) !important;
            }
            
            .bg-warning {
                background-color: var(--primary-light) !important;
            }
            
            .bg-yellow {
                background-color: var(--secondary-yellow) !important;
            }
            
            .bg-light {
                background-color: var(--secondary-light) !important;
            }
            
            .text-primary {
                color: var(--primary-dark) !important;
            }
            
            .text-secondary {
                color: var(--secondary-accent) !important;
            }
            
            .text-warning {
                color: var(--primary-light) !important;
            }
            
            .text-yellow {
                color: var(--secondary-yellow) !important;
            }
            
            .text-light {
                color: var(--secondary-light) !important;
            }
            
            .border-primary {
                border-color: var(--primary-dark) !important;
            }
            
            .border-warning {
                border-color: var(--primary-light) !important;
            }
            
            .tech-pattern {
                position: absolute;
                background-image: 
                    linear-gradient(to right, rgba(244, 212, 98, 0.1) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(244, 212, 98, 0.1) 1px, transparent 1px);
                background-size: 20px 20px;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                z-index: 0;
                opacity: 0.3;
            }
            
            .section-divider {
                height: 5px;
                background: linear-gradient(90deg, var(--primary-light), var(--secondary-yellow), var(--primary-light));
            }
            
            .btn-primary {
                background-color: var(--primary-dark);
                border-color: var(--primary-dark);
                color: var(--secondary-light);
            }
            
            .btn-primary:hover {
                background-color: rgba(0, 23, 64, 0.8);
                border-color: var(--primary-dark);
            }
            
            .btn-warning {
                background-color: var(--primary-light);
                border-color: var(--primary-light);
                color: var(--primary-dark);
            }
            
            .btn-warning:hover {
                background-color: var(--secondary-yellow);
                border-color: var(--secondary-yellow);
                color: var(--primary-dark);
            }
            
            .btn-secondary {
                background-color: var(--secondary-accent);
                border-color: var(--secondary-accent);
                color: var(--secondary-light);
            }
            
            .btn-secondary:hover {
                background-color: rgba(15, 42, 113, 0.8);
                border-color: var(--secondary-accent);
            }
            
            .card {
                border: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }
            
            .service-card {
                transition: all 0.3s ease;
                border-bottom: 4px solid transparent;
                position: relative;
                overflow: hidden;
            }
            
            .service-card::after {
                content: "";
                position: absolute;
                top: 0;
                right: 0;
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 0 50px 50px 0;
                border-color: transparent var(--primary-light) transparent transparent;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            
            .service-card:hover::after {
                opacity: 1;
            }
            
            .service-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
                border-bottom: 4px solid var(--primary-light);
            }
            
            .card-hover-effect {
                transition: all 0.3s ease;
            }
            
            .card-hover-effect:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            }
            
            .tech-btn {
                position: relative;
                overflow: hidden;
                z-index: 1;
            }
            
            .tech-btn::before {
                content: "";
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.7s ease;
                z-index: -1;
            }
            
            .tech-btn:hover::before {
                left: 100%;
            }
            
            .section-title {
                position: relative;
                display: inline-block;
                margin-bottom: 1.5rem;
            }
            
            .section-title::after {
                content: "";
                position: absolute;
                bottom: -10px;
                left: 0;
                width: 50px;
                height: 3px;
                background: var(--primary-light);
            }
            
            .nav-pills .nav-link.active {
                background-color: var(--primary-light);
                color: var(--primary-dark);
            }
            
            .nav-pills .nav-link {
                color: var(--secondary-light);
            }
            
            .nav-pills .nav-link:hover:not(.active) {
                color: var(--primary-light);
            }
            
            .form-control:focus {
                border-color: var(--primary-light);
                box-shadow: 0 0 0 0.25rem rgba(244, 212, 98, 0.25);
            }
            
            .sidebar {
                background-color: var(--secondary-accent);
                min-height: calc(100vh - 56px);
            }
            
            .sidebar .nav-link {
                color: var(--secondary-light);
                border-radius: 0;
                padding: 0.75rem 1rem;
            }
            
            .sidebar .nav-link:hover {
                background-color: rgba(244, 212, 98, 0.1);
            }
            
            .sidebar .nav-link.active {
                background-color: var(--primary-dark);
                color: var(--primary-light);
                border-left: 4px solid var(--primary-light);
            }
            
            .sidebar .nav-link i {
                margin-right: 0.5rem;
            }
            
            .badge-warning {
                background-color: var(--primary-light);
                color: var(--primary-dark);
            }
            
            .breadcrumb-item a {
                color: var(--primary-light);
                text-decoration: none;
            }
            
            .breadcrumb-item.active {
                color: var(--secondary-light);
            }
            
            .table {
                color: var(--secondary-light);
            }
            
            .table-dark {
                --bs-table-bg: var(--secondary-accent);
                --bs-table-striped-bg: rgba(15, 42, 113, 0.8);
                --bs-table-striped-color: var(--secondary-light);
                --bs-table-active-bg: rgba(15, 42, 113, 0.9);
                --bs-table-active-color: var(--secondary-light);
                --bs-table-hover-bg: rgba(15, 42, 113, 0.7);
                --bs-table-hover-color: var(--secondary-light);
                color: var(--secondary-light);
                border-color: var(--primary-dark);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-vh-100 bg-primary">
            @include('layouts.navigation')
            
            <!-- Breadcrumbs -->
            <div class="container-fluid py-2 bg-secondary bg-opacity-75">
                <div class="container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            @if(request()->routeIs('dashboard'))
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            @elseif(request()->routeIs('service-catalog'))
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Service Catalog</li>
                            @elseif(request()->routeIs('recent-orders'))
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Recent Orders</li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Page Content -->
            <main class="py-4">
                {{ $slot }}
            </main>
            
            <!-- Footer -->
            <footer class="bg-secondary py-4 mt-auto">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0 text-light">&copy; {{ date('Y') }} FabHub. All rights reserved.</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-0 text-light">Digital Fabrication Lab</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        
        <!-- Bootstrap JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
