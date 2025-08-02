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

    <main>
        @yield('content')
    </main>

    @include('components.loading-overlay')

    <!-- Toast Root -->
    <div id="toast-root"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-info="{{ session('info') }}"></div>

    @livewireScripts
    @stack('scripts')

    <!-- React App Bundle -->
    @vite('resources/js/app.jsx')

    <!-- Jalankan showToast jika ada session -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const toastRoot = document.getElementById('toast-root');
            if (toastRoot?.dataset.success) showToast('success', toastRoot.dataset.success);
            if (toastRoot?.dataset.error) showToast('error', toastRoot.dataset.error);
            if (toastRoot?.dataset.info) showToast('info', toastRoot.dataset.info);
        });
    </script>
</body>

</html>