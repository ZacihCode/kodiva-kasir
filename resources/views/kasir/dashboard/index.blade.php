<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sendang Plesungan - Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .scale-in {
            animation: scaleIn 0.5s ease-out;
        }

        .slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .pulse-ring {
            animation: pulse-ring 1.25s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(.33);
            }

            80%,
            100% {
                opacity: 0;
            }
        }

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    @extends('layouts.app')
    @section('content')
    <div class="min-h-screen ml-6 mr-2 p-6">
        <!-- Enhanced Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 fade-in">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                    Dashboard Utama
                </h2>
                <p class="text-gray-600 mt-2 text-lg">Selamat datang di sistem kasir tiket renang</p>
                <div class="flex items-center mt-2 text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span id="current-date"></span>
                    <span class="mx-2">•</span>
                    <i class="fas fa-clock mr-2"></i>
                    <span id="current-time"></span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Cari transaksi, karyawan..."
                        class="w-full sm:w-72 pl-12 pr-4 py-3 border-0 rounded-2xl bg-white/80 backdrop-blur-sm shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
                <a href="{{ route('admin.kasir') }}">
                    <button class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl font-medium hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        Transaksi Baru
                    </button>
                </a>
            </div>
        </div>

        <!-- Enhanced Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 card-hover scale-in border border-white/20">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Omset Hari Ini</p>
                        <p class="text-3xl lg:text-4xl font-bold text-emerald-600 mt-2">
                            Rp {{ number_format($omsetHariIni, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center floating">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                </div>
                @php
                $naik = $persentaseOmset >= 0;
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm">
                        <span class="{{ $naik ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }} px-3 py-1 rounded-full font-bold">
                            {{ $naik ? '↗ +' : '↘ ' }}{{ abs($persentaseOmset) }}%
                        </span>
                    </div>
                    <span class="text-gray-500 text-sm">dari kemarin</span>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 card-hover scale-in border border-white/20">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Tiket Terjual</p>
                        <p class="text-3xl lg:text-4xl font-bold text-blue-600 mt-2">{{ $tiketTerjual }}</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center floating" style="animation-delay: 0.5s;">
                        <i class="fas fa-ticket-alt text-white text-2xl"></i>
                    </div>
                </div>
                @php
                $naikTiket = $persentaseTiket >= 0;
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm">
                        <span class="{{ $naikTiket ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }} px-3 py-1 rounded-full font-bold">
                            {{ $naikTiket ? '↗ +' : '↘ ' }}{{ abs($persentaseTiket) }}%
                        </span>
                    </div>
                    <span class="text-gray-500 text-sm">tiket dibanding kemarin</span>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 card-hover scale-in border border-white/20 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Karyawan Hadir</p>
                        <p class="text-3xl lg:text-4xl font-bold text-purple-600 mt-2">{{ $hadirHariIni }}/{{ $totalKaryawan }}</p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center floating" style="animation-delay: 1s;">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center text-sm">
                        <span class="text-purple-600 bg-purple-50 px-3 py-1 rounded-full font-bold">{{ $persentaseKehadiran }}%</span>
                    </div>
                    <span class="text-gray-500 text-sm">kehadiran</span>
                </div>
            </div>
        </div>

        <!-- Enhanced Main Dashboard Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Enhanced Chart Section -->
            <div class="xl:col-span-2 bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 fade-in border border-white/20">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">
                        <i class="fas fa-chart-area text-blue-500 mr-3"></i>
                        Grafik Omset
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <button id="btn-harian"
                            class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl text-sm font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                            Harian
                        </button>
                        <button id="btn-mingguan"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all duration-300">
                            Mingguan
                        </button>
                        <button id="btn-bulanan"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all duration-300">
                            Bulanan
                        </button>
                    </div>
                </div>
                <div class="relative h-80 lg:h-96">
                    <canvas id="omsetChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Enhanced Shift Section -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 slide-in-right border border-white/20">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-clock text-purple-500 mr-3"></i>
                        Shift Hari Ini
                    </h3>
                    <div class="w-3 h-3 bg-green-400 rounded-full pulse-ring"></div>
                </div>
                <div class="space-y-4 custom-scrollbar max-h-96 overflow-y-auto">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-2xl border border-green-100 card-hover">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">Rina Suryani</div>
                                    <div class="text-sm text-gray-600">Shift Pagi (08.00 - 14.00)</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                <span class="text-green-600 text-sm font-bold">Masuk</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-yellow-50 to-amber-50 p-4 rounded-2xl border border-yellow-100 card-hover">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">Arif Wijaya</div>
                                    <div class="text-sm text-gray-600">Shift Siang (14.00 - 20.00)</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                                <span class="text-yellow-600 text-sm font-bold">Belum Masuk</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 p-4 rounded-2xl border border-gray-100 card-hover">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-slate-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-800">Maya Putri</div>
                                    <div class="text-sm text-gray-600">Shift Malam (20.00 - 02.00)</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                <span class="text-gray-500 text-sm font-bold">Belum Mulai</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Aksi Cepat</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="flex items-center justify-center p-3 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors duration-200">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span class="text-sm font-medium">Tambah Shift</span>
                        </button>
                        <button class="flex items-center justify-center p-3 bg-purple-50 text-purple-600 rounded-xl hover:bg-purple-100 transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>
                            <span class="text-sm font-medium">Lihat Semua</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <livewire:transaksi-manager />
    </div>
    <script>
        // Update current date and time
        function updateDateTime() {
            const now = new Date();
            const dateOptions = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const timeOptions = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };

            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
            document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Enhanced Chart
        const ctx = document.getElementById('omsetChart').getContext('2d');

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        let omsetChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Omset (Rp)',
                    data: [],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: 'rgb(59, 130, 246)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Omset: Rp ' + Number(context.parsed.y).toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#6B7280',
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#6B7280',
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            callback: function(value) {
                                return 'Rp ' + Number(value).toLocaleString('id-ID');
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        function loadChartData(filter) {
            // Update button states
            document.querySelectorAll('[id^="btn-"]').forEach(btn => {
                btn.className = btn.className.replace(/bg-gradient-to-r from-blue-500 to-blue-600 text-white/, 'bg-gray-100 text-gray-700');
            });

            document.getElementById(`btn-${filter}`).className = 'px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl text-sm font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg transform hover:scale-105';

            fetch(`/api/omset?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    omsetChart.data.labels = data.labels;
                    omsetChart.data.datasets[0].data = data.data;
                    omsetChart.update('active');
                })
                .catch(error => {
                    console.error('Error loading chart data:', error);
                });
        }

        // Default: harian
        loadChartData('harian');

        document.getElementById('btn-harian').addEventListener('click', () => loadChartData('harian'));
        document.getElementById('btn-mingguan').addEventListener('click', () => loadChartData('mingguan'));
        document.getElementById('btn-bulanan').addEventListener('click', () => loadChartData('bulanan'));

        // Add smooth scroll behavior for mobile
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
    @endsection
</body>

</html>