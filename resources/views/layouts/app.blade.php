<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Kasir Tiket' }}</title>
    <meta name="description" content="Sistem Kasir Tiket - Layanan Kasir terpercaya dengan kualitas terbaik">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    @include('partials.sidebar')
    <!-- Toast Root -->
    <div id="toast-root"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-info="{{ session('info') ?: ($infoMessage ?? '') }}">
    </div>

    <main class="main-content bg-gray-100 pt-16 transition-all duration-300">
        @yield('content')
    </main>
    <!-- Footer -->
    <div class="bg-white border-t border-gray-200 py-4 text-center text-sm text-gray-500">
        <p class="text-black font-semibold text-sm flex items-center justify-center gap-2">
            <img src="https://cdn.aceimg.com/b127a1e12.png" alt="heart" class="w-4 h-4">
            © {{ date('Y') }} <span class="text-black font-semibold">KODIVA.ID</span>
            <i class="fas fa-sparkles text-yellow-400"></i>
        </p>
    </div>

    @livewireScripts
    @vite(['resources/js/app.jsx'])
    @stack('scripts')

    <!-- Jalankan showToast jika ada session -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('toast', ({
                type,
                message
            }) => {
                // showToast sudah diexpose global oleh app.jsx
                if (window.showToast) window.showToast(type, message);
            });
        });
    </script>
</body>

</html>