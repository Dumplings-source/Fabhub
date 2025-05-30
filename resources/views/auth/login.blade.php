<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CTU FabLab</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css">

    <style>
        /* CTU FABLAB Customer Dashboard Font Styling */
        body {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', sans-serif !important;
        }
        
        .font-sans {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', sans-serif !important;
        }
        
        /* Enhanced Customer Dashboard Styling */
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

        /* Enhanced Background */
        .login-bg {
            background: linear-gradient(135deg, #0F2A71 0%, #1e3a8a 100%);
            min-height: 100vh;
        }

        /* Enhanced Card Styling */
        .login-card {
            background: #0F2A71;
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            border: 3px solid #F4D462;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        /* Enhanced Form Section */
        .form-section {
            background: white;
            padding: 3rem;
            position: relative;
        }

        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.02) 0%, rgba(59, 130, 246, 0.01) 100%);
            pointer-events: none;
        }

        /* Enhanced Input Styling */
        .enhanced-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--light-bg);
            color: var(--primary-blue);
            font-weight: 500;
        }

        .enhanced-input:focus {
            outline: none;
            border-color: var(--secondary-blue);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .enhanced-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        /* Enhanced Button Styling */
        .btn-enhanced {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        .btn-enhanced:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(30, 58, 138, 0.4);
        }

        .btn-enhanced:hover::before {
            left: 100%;
        }

        .btn-enhanced:active {
            transform: translateY(-1px);
        }

        /* Enhanced Logo Section */
        .logo-section {
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .logo-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(244, 212, 98, 0.05) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .logo-container {
            background: transparent;
            padding: 2rem;
            border-radius: 20px;
            backdrop-filter: none;
            border: none;
            transition: all 0.3s ease;
        }

        .logo-container:hover {
            transform: scale(1.05);
            background: rgba(244, 212, 98, 0.05);
        }

        /* Enhanced Labels */
        .enhanced-label {
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Enhanced Links */
        .enhanced-link {
            color: var(--secondary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .enhanced-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }

        .enhanced-link:hover {
            color: var(--primary-blue);
        }

        .enhanced-link:hover::after {
            width: 100%;
        }

        /* Enhanced Checkbox */
        .enhanced-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid var(--secondary-blue);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .enhanced-checkbox:checked {
            background: var(--gradient-primary);
            border-color: var(--primary-blue);
        }

        /* Enhanced Error Messages */
        .error-message {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            padding: 0.75rem;
            margin-top: 0.5rem;
            color: var(--danger-red);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Enhanced Success Messages */
        .success-message {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            color: var(--success-green);
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        /* Title Enhancement */
        .login-title {
            color: var(--primary-blue);
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-align: center;
            position: relative;
        }

        .login-subtitle {
            color: var(--secondary-blue);
            font-size: 1rem;
            font-weight: 400;
            text-align: center;
            margin-bottom: 2rem;
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }
            
            .form-section {
                padding: 2rem;
            }
            
            .login-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased login-bg">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="login-card w-full max-w-5xl flex">
            <!-- Left Section (Form) -->
            <div class="w-full md:w-1/2 form-section">
                <div class="w-full max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <h1 class="login-title">Welcome Back</h1>
                        <p class="login-subtitle">Sign in to your CTU FabLab account</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="success-message">
                            <i class="bi bi-check-circle-fill mr-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="enhanced-label">
                                <i class="bi bi-envelope mr-2"></i>Email Address
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Enter your email address"
                                class="enhanced-input"
                            >
                            @error('email')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle mr-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="enhanced-label">
                                <i class="bi bi-lock mr-2"></i>Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="enhanced-input"
                            >
                            @error('password')
                                <div class="error-message">
                                    <i class="bi bi-exclamation-circle mr-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me and Forgot Password -->
                        <div class="flex items-center justify-between mt-6">
                            <label class="inline-flex items-center">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="enhanced-checkbox"
                                >
                                <span class="ml-3 text-sm font-medium" style="color: var(--primary-blue);">Remember me</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="enhanced-link text-sm">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-enhanced">
                            <i class="bi bi-box-arrow-in-right mr-2"></i>
                            Sign In
                        </button>
                    </form>

                    <!-- Register Link -->
                    @if (Route::has('register'))
                        <div class="mt-8 text-center">
                            <p class="text-sm" style="color: var(--primary-blue); opacity: 0.8;">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="enhanced-link font-semibold">
                                    Create Account
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Section (Logo) -->
            <div class="hidden md:flex md:w-1/2 logo-section">
                <div class="logo-container">
                    <img src="{{ asset('images/Fablab logo.jpg') }}" alt="CTU FabLab Logo" class="max-w-full h-auto rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>
</body>
</html>