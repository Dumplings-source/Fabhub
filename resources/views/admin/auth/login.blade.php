<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="border-2 border-gray-800 rounded-lg w-full max-w-4xl flex overflow-hidden">
            <!-- Left Section (Form) -->
            <div class="w-1/2 p-6 flex flex-col justify-center">
                <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-gray-800 font-medium mb-1">Email:</label>
                        <input id="email" 
                               class="w-full border border-gray-300 rounded p-2" 
                               type="email" 
                               name="email" 
                               value="" 
                               required 
                               autofocus 
                               autocomplete="username">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-gray-800 font-medium mb-1">Password:</label>
                        <input id="password" 
                               class="w-full border border-gray-300 rounded p-2" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password">
                    </div>

                    <!-- Remember Me and Forgot Password -->
                    <div class="flex items-center justify-between mt-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   class="rounded border-gray-300 text-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Remember me</span>
                        </label>
                        <a href="/forgot-password" class="text-sm text-blue-500 hover:underline">Forgot your password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded mt-4 w-full">Log in</button>
                </form>
            </div>
            
            <!-- Right Section (Image Placeholder) -->
           <div class="w-1/2 bg-white flex items-center justify-center">
    <img src="{{ asset('images/Fablab logo.jpg') }}" class="max-w-full h-auto">
</div>
        </div>
    </div>
</body>
</html>