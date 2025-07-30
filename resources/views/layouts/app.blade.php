<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Kasir Tiket' }}</title>
    <meta name="description" content="Sistem Kasir Tiket - Layanan Kasir terpercaya dengan kualitas terbaik">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <!-- Tambahkan ini -->
    <main>
        @yield('content')
        
    </main>
    @include('components.loading-overlay')
    @livewireScripts
</body>

</html>