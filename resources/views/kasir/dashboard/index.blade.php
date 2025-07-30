<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    @extends('layouts.app')
    <div id="toast-root"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-info="{{ session('info') ?: ($infoMessage ?? '') }}">
    </div>
    @vite(['resources/js/ToastApp.jsx'])
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 p-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8 fade-in">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Dashboard Utama</h2>
                    <p class="text-gray-600 mt-2">Selamat datang di sistem kasir tiket renang</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari..."
                            class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover scale-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Omset Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-800" id="omset-today">Rp 2.450.000</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-green-600 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-600 font-medium">↗ +12%</span>
                        <span class="text-gray-600 ml-2">dari kemarin</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover scale-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Tiket Terjual</p>
                            <p class="text-2xl font-bold text-gray-800" id="tickets-sold">245</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-ticket-alt text-blue-600 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-blue-600 font-medium">↗ +8%</span>
                        <span class="text-gray-600 ml-2">dari kemarin</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover scale-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Karyawan Hadir</p>
                            <p class="text-2xl font-bold text-gray-800">12/15</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-purple-600 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-purple-600 font-medium">80%</span>
                        <span class="text-gray-600 ml-2">kehadiran</span>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover scale-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Parkir Aktif</p>
                            <p class="text-2xl font-bold text-gray-800">87</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-car text-orange-600 text-lg"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-orange-600 font-medium">72%</span>
                        <span class="text-gray-600 ml-2">terisi</span>
                    </div>
                </div>
            </div>
            <!-- Main Dashboard Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Chart Section -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 md:p-10 fade-in h-[400px] overflow-x-auto">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-gray-800">Grafik Omset</h3>
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition-colors">Harian</button>
                            <button
                                class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition-colors">Mingguan</button>
                            <button
                                class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300 transition-colors">Bulanan</button>
                        </div>
                    </div>
                    <canvas id="omsetChart" class="w-full h-full"></canvas>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 fade-in">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Shift Hari Ini</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center justify-between bg-gray-100 p-3 rounded-lg">
                            <div>
                                <div class="font-semibold text-gray-800">Rina Suryani</div>
                                <div class="text-sm text-gray-600">Shift Pagi (08.00 - 14.00)</div>
                            </div>
                            <span class="text-green-500 text-sm font-medium">🟢 Masuk</span>
                        </li>
                        <li class="flex items-center justify-between bg-gray-100 p-3 rounded-lg">
                            <div>
                                <div class="font-semibold text-gray-800">Arif Wijaya</div>
                                <div class="text-sm text-gray-600">Shift Siang (14.00 - 20.00)</div>
                            </div>
                            <span class="text-yellow-500 text-sm font-medium">⏳ Belum Masuk</span>
                        </li>
                        <li class="flex items-center justify-between bg-gray-100 p-3 rounded-lg">
                            <div>
                                <div class="font-semibold text-gray-800">Maya Putri</div>
                                <div class="text-sm text-gray-600">Shift Malam (20.00 - 02.00)</div>
                            </div>
                            <span class="text-gray-400 text-sm font-medium">⏸️ Belum Mulai</span>
                        </li>
                    </ul>
                </div>
            </div>
            <livewire:transaksi-manager />
        </div>
    </div>
    <script>
        const ctx = document.getElementById('omsetChart').getContext('2d');
        const omsetChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Omset (Rp)',
                    data: [1200000, 1900000, 3000000, 2500000, 2200000, 3200000, 2800000],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + Number(value).toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>