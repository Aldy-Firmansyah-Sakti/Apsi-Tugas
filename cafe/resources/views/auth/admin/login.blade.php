<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Café X</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-green-800 via-green-700 to-green-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Main Card -->
            <div class="bg-cream-50 rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-green-700 px-8 py-6 text-center">
                    <h1 class="text-2xl font-bold text-white mb-1">Login</h1>
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full mx-auto flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Form -->
                <div class="px-8 py-6">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       placeholder="Masukkan Email atau Nomor Telepon"
                                       class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Masukkan Password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                   required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <!-- Error Message -->
                            @if($errors->has('email') && !$errors->has('password'))
                                <p class="mt-2 text-sm text-red-600">Incorrect email or password</p>
                            @endif
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="text-right mb-6">
                            <a href="#" class="text-sm text-gray-500 hover:text-green-600">Forgot Password?</a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" 
                                class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                            Login
                        </button>
                    </form>

                    <!-- Note: Admin registration is disabled -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-500">
                            Don't have any account? 
                            <span class="text-gray-400 cursor-not-allowed">Sign Up</span>
                            <span class="text-xs text-gray-400 block mt-1">(Admin registration is restricted)</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-cream-200 text-sm hover:text-white transition duration-300">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <style>
        .text-cream-200 { color: #f9f1e6; }
        .bg-cream-50 { background-color: #fefdf9; }
    </style>
</body>
</html>