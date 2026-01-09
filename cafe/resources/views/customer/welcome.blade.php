<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café X - Selamat Datang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-green-800 via-green-700 to-green-900 min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            <!-- Logo/Brand -->
            <div class="text-center mb-8">
                <h1 class="text-5xl font-bold text-cream-100 mb-2">Café X</h1>
                <p class="text-cream-200 text-lg">Nikmati kopi terbaik dengan suasana yang nyaman</p>
            </div>

            <!-- Main Card -->
            <div class="bg-cream-50 rounded-2xl shadow-2xl p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold text-green-800 mb-2">Mulai Pesanan</h2>
                    <p class="text-green-600">Masukkan nama dan nomor meja Anda</p>
                </div>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Order Form -->
                <form method="POST" action="{{ route('customer.start-order') }}">
                    @csrf
                    
                    <!-- Customer Name -->
                    <div class="mb-4">
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Anda</label>
                        <input type="text" 
                               id="customer_name" 
                               name="customer_name" 
                               value="{{ old('customer_name') }}"
                               placeholder="Masukkan nama Anda"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent @error('customer_name') border-red-500 @enderror"
                               required>
                        @error('customer_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Table Number -->
                    <div class="mb-6">
                        <label for="table_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Meja</label>
                        <select id="table_number" 
                                name="table_number" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent @error('table_number') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Nomor Meja</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('table_number') == $i ? 'selected' : '' }}>
                                    Meja {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('table_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Order Button -->
                    <button type="submit" 
                            class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold py-4 px-6 rounded-xl transition duration-300 ease-in-out transform hover:scale-105 shadow-lg">
                        <div class="flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Mulai Pesan
                        </div>
                    </button>
                </form>

                <!-- Info -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">
                        Pastikan Anda sudah duduk di meja yang dipilih
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-cream-200 text-sm">© 2026 Café X. Semua hak dilindungi.</p>
                <a href="{{ route('admin.login') }}" class="text-cream-200 text-xs hover:text-white transition duration-300 mt-2 inline-block">
                    Admin Login
                </a>
            </div>
        </div>
    </div>

    <style>
        .text-cream-50 { color: #fefdf9; }
        .text-cream-100 { color: #fdf8f0; }
        .text-cream-200 { color: #f9f1e6; }
        .bg-cream-50 { background-color: #fefdf9; }
        .bg-cream-200 { background-color: #f9f1e6; }
        .bg-cream-300 { background-color: #f3e8d3; }
        .hover\:bg-cream-300:hover { background-color: #f3e8d3; }
        .border-green-200 { border-color: #bbf7d0; }
    </style>
</body>
</html>