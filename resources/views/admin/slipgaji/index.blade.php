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
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4 fade-in">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Slip Gaji Karyawan</h2>
                    <p class="text-gray-600 mt-2">Manajemen penggajian dan pengiriman slip gaji otomatis</p>
                </div>
                <div class="flex items-center space-x-4">
                    <input type="date"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Filter
                    </button>
                </div>
            </div>
            <!-- Slip Gaji Page -->
            <div class="grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="flex items-center justify-between mb-8 fade-in">
                    <div class="flex items-center space-x-4">
                        <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Januari 2025</option>
                            <option>Februari 2025</option>
                            <option>Maret 2025</option>
                        </select>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            📤 Kirim Semua Slip
                        </button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                            ➕ Tambah Karyawan
                        </button>
                    </div>
                </div>

                <!-- Payroll Summary -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Gaji</p>
                                <p class="text-2xl font-bold text-blue-600">Rp 45.500.000</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 text-xl">💰</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Karyawan Aktif</p>
                                <p class="text-2xl font-bold text-green-600">15</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 text-xl">👥</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Slip Terkirim</p>
                                <p class="text-2xl font-bold text-purple-600">12</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-purple-600 text-xl">📤</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Pending</p>
                                <p class="text-2xl font-bold text-orange-600">3</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-orange-600 text-xl">⏳</span>
                            </div>
                        </div>
                    </div>
                </div>
                <livewire:slipgaji-manager />
            </div>
        </div>
        @endsection
</body>

</html>