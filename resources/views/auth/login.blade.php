<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CTU FabLab</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: "#0056b3", secondary: "#ff6b00" },
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

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #1f2937;
        }
        input:focus {
            outline: none;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="border-2 border-gray-800 rounded-lg w-full max-w-4xl flex overflow-hidden">
                <!-- Left Section (Form) -->
                <div class="w-1/2 p-6 flex flex-col justify-center">
                    <div class="w-full max-w-sm">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Login</h2>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 text-sm text-green-600 bg-green-100 border border-green-200 rounded-lg px-4 py-2">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-900"
                                >
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary text-gray-900"
                                >
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember Me and Forgot Password -->
                            <div class="flex items-center justify-between mt-4">
                                <label class="inline-flex items-center">
                                    <input
                                        type="checkbox"
                                        name="remember"
                                        class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary"
                                    >
                                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                </label>
                                @if (Route::has('password.request'))
                                    <a
                                        href="{{ route('password.request') }}"
                                        class="text-sm text-primary hover:text-primary/80 underline focus:outline-none"
                                    >
                                        Forgot your password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                class="bg-primary text-white py-2 px-4 rounded-button font-medium hover:bg-primary/90 transition w-full"
                            >
                                Log in
                            </button>
                        </form>

                        <!-- Register Link -->
                        @if (Route::has('register'))
                            <p class="mt-6 text-center text-sm text-gray-600">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="text-primary hover:text-primary/80 font-medium">
                                    Register
                                </a>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Right Section (Image Placeholder) -->
                <div class="w-1/2 bg-gray-50 flex items-center justify-center">
                    <img src="{{ asset('images/Fablab logo.jpg') }}" alt="CTU FabLab Logo" class="max-w-full h-auto">
                </div>
            </div>
        </div>
    </div>
</body>
</html>