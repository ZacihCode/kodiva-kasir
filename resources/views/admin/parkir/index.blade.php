<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <!-- Parkir Page -->
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
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

            <!-- Parking Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Kapasitas Total</p>
                            <p class="text-2xl font-bold text-gray-800">120</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 text-xl">🏢</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Terisi</p>
                            <p class="text-2xl font-bold text-blue-600">87</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-xl">🚗</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Kosong</p>
                            <p class="text-2xl font-bold text-green-600">33</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 text-xl">✅</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Pendapatan Hari Ini</p>
                            <p class="text-2xl font-bold text-purple-600">Rp 435.000</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 text-xl">💰</span>
                        </div>
                    </div>
                </div>
            </div>

            <livewire:parkir-manager />
        </div>
    </div>
    @endsection
</body>

</html>