<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sendang Plesungan - Parkir</title>
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <!-- Parkir Page -->
    <div class="min-h-screen ml-6 mr-2 p-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8 fade-in">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Parkir</h2>
                <p class="text-gray-600 mt-2">Sistem pembayaran dan monitoring parkir</p>
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <input type="date"
                    class="w-full sm:w-auto border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button
                    class="w-full sm:w-auto bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Filter
                </button>
            </div>
        </div>
        <livewire:parkir-manager />
    </div>
    @endsection
</body>

</html>