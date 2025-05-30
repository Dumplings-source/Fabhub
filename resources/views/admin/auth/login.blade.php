<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - CTUFABLAB</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Admin Dashboard Color Scheme */
        :root {
            --primary-accent: #001740;
            --primary-base: #F4D462;
            --complementary-accent: #0F2A71;
            --secondary-accent: #FFC300;
            --secondary-palette: #FFFDF0;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', sans-serif !important;
        }
        
        /* Enhanced Background */
        .admin-login-bg {
            background: linear-gradient(135deg, #0F2A71 0%, #001740 100%);
            min-height: 100vh;
        }
        
        /* Enhanced Card Styling */
        .admin-login-card {
            background: #0F2A71;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 23, 64, 0.15);
            border: 3px solid #F4D462;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .admin-login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-base) 0%, var(--secondary-accent) 100%);
        }

        /* Enhanced Form Section */
        .admin-form-section {
            background: linear-gradient(135deg, var(--secondary-palette) 0%, #ffffff 100%);
            padding: 3rem;
            position: relative;
        }

        .admin-form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 23, 64, 0.02) 0%, rgba(15, 42, 113, 0.01) 100%);
            pointer-events: none;
        }

        /* Enhanced Input Styling */
        .admin-enhanced-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(244, 212, 98, 0.3);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--secondary-palette);
            color: var(--primary-accent);
            font-weight: 500;
        }

        .admin-enhanced-input:focus {
            outline: none;
            border-color: var(--primary-base);
            box-shadow: 0 0 0 4px rgba(244, 212, 98, 0.2);
            background: white;
            transform: translateY(-2px);
        }

        .admin-enhanced-input::placeholder {
            color: rgba(0, 23, 64, 0.5);
            font-weight: 400;
        }

        /* Enhanced Button Styling */
        .admin-btn-enhanced {
            background: linear-gradient(135deg, var(--primary-accent) 0%, var(--complementary-accent) 100%);
            color: var(--primary-base);
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .admin-btn-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(244, 212, 98, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .admin-btn-enhanced:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 23, 64, 0.4);
        }

        .admin-btn-enhanced:hover::before {
            left: 100%;
        }

        .admin-btn-enhanced:active {
            transform: translateY(-1px);
        }

        /* Enhanced Logo Section */
        .admin-logo-section {
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .admin-logo-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(244, 212, 98, 0.05) 0%, transparent 70%);
            animation: adminFloat 6s ease-in-out infinite;
        }

        @keyframes adminFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .admin-logo-container {
            background: transparent;
            padding: 2.5rem;
            border-radius: 24px;
            backdrop-filter: none;
            border: none;
            transition: all 0.3s ease;
        }

        .admin-logo-container:hover {
            transform: scale(1.05);
            background: rgba(244, 212, 98, 0.05);
        }

        /* Enhanced Labels */
        .admin-enhanced-label {
            color: var(--primary-accent);
            font-weight: 700;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: block;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Enhanced Links */
        .admin-enhanced-link {
            color: var(--complementary-accent);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .admin-enhanced-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-base), var(--secondary-accent));
            transition: width 0.3s ease;
        }

        .admin-enhanced-link:hover {
            color: var(--primary-accent);
        }

        .admin-enhanced-link:hover::after {
            width: 100%;
        }

        /* Enhanced Checkbox */
        .admin-enhanced-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid var(--primary-base);
            border-radius: 6px;
            transition: all 0.3s ease;
            accent-color: var(--primary-accent);
        }

        .admin-enhanced-checkbox:checked {
            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
            border-color: var(--primary-accent);
        }

        /* Enhanced Error Messages */
        .admin-error-message {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-top: 0.5rem;
            color: #dc2626;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        /* Title Enhancement */
        .admin-login-title {
            background: linear-gradient(45deg, var(--primary-accent), var(--complementary-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-align: center;
            position: relative;
            letter-spacing: -0.025em;
        }

        .admin-login-subtitle {
            color: var(--complementary-accent);
            font-size: 1rem;
            font-weight: 500;
            text-align: center;
            margin-bottom: 2.5rem;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }

        /* Admin Badge */
        .admin-badge {
            background: linear-gradient(45deg, var(--primary-base), var(--secondary-accent));
            color: var(--primary-accent);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(244, 212, 98, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-login-card {
                flex-direction: column;
            }
            
            .admin-form-section {
                padding: 2rem;
            }
            
            .admin-login-title {
                font-size: 2.25rem;
            }
        }

        /* Loading Animation */
        .loading-shimmer {
            background: linear-gradient(90deg, rgba(244, 212, 98, 0.1) 25%, rgba(244, 212, 98, 0.3) 50%, rgba(244, 212, 98, 0.1) 75%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>
<body class="admin-login-bg">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="admin-login-card w-full max-w-5xl flex">
            <!-- Left Section (Form) -->
            <div class="w-full md:w-1/2 admin-form-section">
                <div class="w-full max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <div class="admin-badge">
                            <i class="fas fa-shield-alt mr-2"></i>Administrator
                        </div>
                        <h1 class="admin-login-title">CTUFABLAB</h1>
                        <p class="admin-login-subtitle">Administrative Access Portal</p>
                    </div>

                    <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="admin-enhanced-label">
                                <i class="fas fa-user-shield mr-2"></i>Administrator Email
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Enter administrator email"
                                class="admin-enhanced-input"
                            >
                            @error('email')
                                <div class="admin-error-message">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="admin-enhanced-label">
                                <i class="fas fa-lock mr-2"></i>Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter secure password"
                                class="admin-enhanced-input"
                            >
                            @error('password')
                                <div class="admin-error-message">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me and Forgot Password -->
                        <div class="flex items-center justify-between mt-6">
                            <label class="inline-flex items-center">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="admin-enhanced-checkbox"
                                >
                                <span class="ml-3 text-sm font-semibold" style="color: var(--primary-accent);">Keep me signed in</span>
                            </label>
                            <a href="/forgot-password" class="admin-enhanced-link text-sm">
                                <i class="fas fa-key mr-1"></i>Reset Password
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="admin-btn-enhanced">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Access Dashboard
                        </button>
                    </form>

                    <!-- Security Notice -->
                    <div class="mt-8 p-4 rounded-lg" style="background: rgba(244, 212, 98, 0.1); border: 1px solid rgba(244, 212, 98, 0.3);">
                        <div class="flex items-center text-sm" style="color: var(--primary-accent);">
                            <i class="fas fa-shield-alt mr-2" style="color: var(--primary-base);"></i>
                            <span class="font-medium">Secure administrative access. All activities are logged and monitored.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section (Logo) -->
            <div class="hidden md:flex md:w-1/2 admin-logo-section">
                <div class="admin-logo-container">
                    <img src="{{ asset('images/Fablab logo.jpg') }}" alt="CTU FabLab Logo" class="max-w-full h-auto rounded-lg shadow-2xl">
                </div>
            </div>
        </div>
    </div>
</body>
</html>