<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased">
    <!-- Main container with black-to-white gradient background -->
    <div class="min-h-screen bg-gradient-to-b from-black to-white flex items-center justify-center p-4">
        <!-- Form container with updated modal-like styling -->
        <div class="bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 w-full max-w-md transform transition-all duration-300 hover:scale-105">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Register</h2>

            <form method="POST" action="{{ route('admin.register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                    <input id="name" 
                           class="block mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-600 focus:border-indigo-600 transition duration-200 ease-in-out" 
                           type="text" 
                           name="name" 
                           value="" 
                           required 
                           autofocus 
                           autocomplete="name">
                    <div class="mt-1 text-sm text-red-600 hidden" id="name-error">Error message here</div>
                </div>

                <!-- Email Address -->
                <div class="mt-5">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input id="email" 
                           class="block mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-600 focus:border-indigo-600 transition duration-200 ease-in-out" 
                           type="email" 
                           name="email" 
                           value="" 
                           required 
                           autocomplete="username">
                    <div class="mt-1 text-sm text-red-600 hidden" id="email-error">Error message here</div>
                </div>

                <!-- Password -->
                <div class="mt-5">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input id="password" 
                           class="block mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-600 focus:border-indigo-600 transition duration-200 ease-in-out" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password">
                    <div class="mt-1 text-sm text-red-600 hidden" id="password-error">Error message here</div>
                </div>

                <!-- Confirm Password -->
                <div class="mt-5">
                    <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                    <input id="password_confirmation" 
                           class="block mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-600 focus:border-indigo-600 transition duration-200 ease-in-out" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password">
                    <div class="mt-1 text-sm text-red-600 hidden" id="password-confirmation-error">Error message here</div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="/login" class="underline text-sm text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                        Already registered?
                    </a>

                    <button type="submit" class="ml-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-5 rounded-md transition-colors duration-200">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>