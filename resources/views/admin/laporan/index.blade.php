<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <title>Laporan & Analisis - AquaTix</title>
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

        .slide-up {
            animation: slideUp 0.4s ease-out;
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

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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

        .gradient-border {
            background: linear-gradient(white, white) padding-box,
                linear-gradient(135deg, #667eea, #764ba2) border-box;
            border: 2px solid transparent;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 1px solid rgba(148, 163, 184, 0.2);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ef4444, #f59e0b);
        }

        .chart-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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

        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
            appearance: none;
        }

        .progress-bar {
            background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 50%, #ef4444 100%);
            height: 4px;
            border-radius: 2px;
        }

        .metric-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .export-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
        }

        .export-button:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }

        .filter-button {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }

        .filter-button:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .trend-up {
            color: #10b981;
        }

        .trend-down {
            color: #ef4444;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    @extends('layouts.app')
    @section('content')
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Header -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 fade-in">
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center floating">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 bg-clip-text text-transparent">
                            Laporan & Analisis
                        </h2>
                    </div>
                    <p class="text-gray-600 text-lg">Dashboard analitik komprehensif untuk insight bisnis</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <div class="relative">
                        <input type="date"
                            class="w-full sm:w-auto border-0 rounded-2xl px-4 py-3 bg-white/80 backdrop-blur-sm shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:bg-white transition-all duration-300">
                    </div>
                    <button class="filter-button text-white px-6 py-3 rounded-2xl font-medium shadow-lg">
                        <i class="fas fa-filter mr-2"></i>
                        Filter Data
                    </button>
                </div>
            </div>

            <!-- Enhanced Control Panel -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 mb-8 scale-in border border-white/20">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <select class="custom-select border-0 rounded-2xl px-4 py-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all duration-300 font-medium">
                            <option>📅 Hari Ini</option>
                            <option>📅 Minggu Ini</option>
                            <option>📅 Bulan Ini</option>
                            <option>📅 Tahun Ini</option>
                            <option>📅 Custom Range</option>
                        </select>
                        <button class="filter-button text-white px-6 py-3 rounded-2xl font-medium shadow-lg">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Generate Laporan
                        </button>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <button class="export-button text-white px-6 py-3 rounded-2xl font-medium shadow-lg">
                            <i class="fas fa-file-pdf mr-2"></i>
                            Export PDF
                        </button>
                        <button class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-2xl font-medium shadow-lg transition-all duration-300 hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-file-excel mr-2"></i>
                            Export Excel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 xl:gap-6 mb-8">
                <div class="stat-card bg-white w-full rounded-3xl shadow-lg p-6 xl:p-8 flex flex-col justify-between transition hover:shadow-xl duration-300 card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-500 text-xs uppercase font-semibold">Total Pengunjung</p>
                            <p class="text-2xl xl:text-3xl font-bold text-blue-600 mt-2">1,245</p>
                        </div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full"><i class="fas fa-arrow-up mr-1"></i>+15%</span>
                        <span class="text-xs text-gray-500">vs periode lalu</span>
                    </div>
                </div>

                <div class="stat-card bg-white w-full rounded-3xl shadow-lg p-6 xl:p-8 flex flex-col justify-between transition hover:shadow-xl duration-300 card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-500 text-xs uppercase font-semibold">Omset Total</p>
                            <p class="text-2xl xl:text-3xl font-bold text-emerald-600 mt-2">18.675.000</p>
                            <p class="text-sm text-gray-400">Rupiah</p>
                        </div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full"><i class="fas fa-arrow-up mr-1"></i>+22%</span>
                        <span class="text-xs text-gray-500">vs periode lalu</span>
                    </div>
                </div>

                <div class="stat-card bg-white w-full rounded-3xl shadow-lg p-6 xl:p-8 flex flex-col justify-between transition hover:shadow-xl duration-300 card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-500 text-xs uppercase font-semibold">Rata-rata per Hari</p>
                            <p class="text-2xl xl:text-3xl font-bold text-purple-600 mt-2">2.669.000</p>
                            <p class="text-sm text-gray-400">Rupiah</p>
                        </div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center">
                            <i class="fas fa-chart-line text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full"><i class="fas fa-arrow-up mr-1"></i>+8%</span>
                        <span class="text-xs text-gray-500">vs periode lalu</span>
                    </div>
                </div>

                <div class="stat-card bg-white w-full rounded-3xl shadow-lg p-6 xl:p-8 flex flex-col justify-between transition hover:shadow-xl duration-300 card-hover">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-gray-500 text-xs uppercase font-semibold">Laba Bersih</p>
                            <p class="text-2xl xl:text-3xl font-bold text-orange-600 mt-2">14.140.000</p>
                            <p class="text-sm text-gray-400">Rupiah (75.7%)</p>
                        </div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-chart-line text-white text-lg"></i>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-full"><i class="fas fa-arrow-up mr-1"></i>+18%</span>
                        <span class="text-xs text-gray-500">vs periode lalu</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Charts Section -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">
                <!-- Ticket Sales Chart -->
                <div class="chart-container rounded-3xl shadow-xl p-6 lg:p-8 slide-up border border-white/20">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 lg:mb-0">
                            <i class="fas fa-ticket-alt text-orange-500 mr-3"></i>
                            Penjualan per Jenis Tiket
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <button id="btn-tiket-harian"
                                class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl text-sm font-medium hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                                Harian
                            </button>
                            <button id="btn-tiket-mingguan"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all duration-300">
                                Mingguan
                            </button>
                            <button id="btn-tiket-bulanan"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all duration-300">
                                Bulanan
                            </button>
                        </div>
                    </div>
                    <div class="relative h-80 lg:h-96">
                        <canvas id="ticketChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Visitor Trend Chart -->
                <div class="chart-container rounded-3xl shadow-xl p-6 lg:p-8 slide-up border border-white/20">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 lg:mb-0">
                            <i class="fas fa-chart-area text-green-500 mr-3"></i>
                            Trend Pengunjung
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <button id="btn-visitor-harian"
                                class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl text-sm font-medium hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                                Harian
                            </button>
                            <button id="btn-visitor-mingguan"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all duration-300">
                                Mingguan
                            </button>
                            <button id="btn-visitor-bulanan"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all duration-300">
                                Bulanan
                            </button>
                        </div>
                    </div>
                    <div class="relative h-80 lg:h-96">
                        <canvas id="visitorChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>

            <!-- Enhanced Detailed Reports -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 border border-white/20">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-file-alt text-indigo-500 mr-3"></i>
                        Laporan Detail Komprehensif
                    </h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-400 rounded-full pulse-ring"></div>
                        <span class="text-sm text-gray-500">Live Data</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Financial Report -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-2xl border border-green-100 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-chart-pie text-green-500 mr-2"></i>
                                Laporan Keuangan
                            </h4>
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-green-600"></i>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <span class="text-gray-700 font-medium">💰 Pemasukan</span>
                                <span class="font-bold text-green-600">Rp 18.675.000</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <span class="text-gray-700 font-medium">💸 Pengeluaran</span>
                                <span class="font-bold text-red-600">Rp 4.535.000</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-green-100 rounded-xl">
                                <span class="text-gray-700 font-medium">🎯 Laba Kotor</span>
                                <span class="font-bold text-green-700">Rp 14.140.000</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-green-100 rounded-xl">
                                <span class="text-gray-700 font-medium">📊 Margin</span>
                                <span class="font-bold text-green-700">75.7%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Report -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-2xl border border-blue-100 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-ticket-alt text-blue-500 mr-2"></i>
                                Laporan Tiket
                            </h4>
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-bar text-blue-600"></i>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                    <span class="text-gray-700 font-medium">Tiket Dewasa</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-blue-600">845</span>
                                    <span class="text-sm text-gray-500 ml-1">(68%)</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-gray-700 font-medium">Tiket Anak</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-green-600">285</span>
                                    <span class="text-sm text-gray-500 ml-1">(23%)</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                                    <span class="text-gray-700 font-medium">Tiket VIP</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-purple-600">85</span>
                                    <span class="text-sm text-gray-500 ml-1">(7%)</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                    <span class="text-gray-700 font-medium">Tiket Lansia</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-orange-600">30</span>
                                    <span class="text-sm text-gray-500 ml-1">(2%)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Report -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 p-6 rounded-2xl border border-purple-100 card-hover">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-xl font-bold text-gray-800">
                                <i class="fas fa-users text-purple-500 mr-2"></i>
                                Laporan Karyawan
                            </h4>
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-purple-600"></i>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <span class="text-gray-700 font-medium">📊 Rata-rata Kehadiran</span>
                                <span class="font-bold text-purple-600">87%</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <span class="text-gray-700 font-medium">⏰ Total Jam Kerja</span>
                                <span class="font-bold text-purple-600">1,260 jam</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <span class="text-gray-700 font-medium">⏱️ Lembur</span>
                                <span class="font-bold text-orange-600">45 jam</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/50 rounded-xl">
                                <span class="text-gray-700 font-medium">❌ Absen</span>
                                <span class="font-bold text-red-600">3 karyawan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateButtonStyle(prefix, filter) {
            // Reset all buttons for this prefix
            document.querySelectorAll(`[id^="btn-${prefix}-"]`).forEach(btn => {
                btn.className = 'px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-200 transition-all duration-300';
            });

            // Set active button style
            const activeBtn = document.getElementById(`btn-${prefix}-${filter}`);
            if (activeBtn) {
                const color = prefix === 'tiket' ? 'orange' : 'green';
                activeBtn.className = `px-4 py-2 bg-gradient-to-r from-${color}-500 to-${color}-600 text-white rounded-xl text-sm font-medium hover:from-${color}-600 hover:to-${color}-700 transition-all duration-300 shadow-lg transform hover:scale-105`;
            }
        }

        // Enhanced Ticket Chart
        const ticketCtx = document.getElementById('ticketChart').getContext('2d');

        const ticketGradient = ticketCtx.createLinearGradient(0, 0, 0, 400);
        ticketGradient.addColorStop(0, 'rgba(255, 159, 64, 0.8)');
        ticketGradient.addColorStop(1, 'rgba(255, 159, 64, 0.3)');

        let ticketChart = new Chart(ticketCtx, {
            type: 'bar',
            data: {
                labels: ['Dewasa', 'Anak', 'VIP', 'Lansia'],
                datasets: [{
                    label: 'Tiket Terjual',
                    data: [845, 285, 85, 30],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(249, 115, 22, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(168, 85, 247)',
                        'rgb(249, 115, 22)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
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
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed.y / total) * 100).toFixed(1);
                                return `Tiket: ${context.parsed.y} (${percentage}%)`;
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
                                return value + ' tiket';
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

        function loadTicketChart(filter) {
            updateButtonStyle('tiket', filter);

            fetch(`/api/tiket?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    ticketChart.data.labels = data.labels;
                    ticketChart.data.datasets[0].data = data.data;
                    ticketChart.update('active');
                })
                .catch(error => {
                    console.error('Error loading ticket chart:', error);
                });
        }

        // Enhanced Visitor Chart
        const visitorCtx = document.getElementById('visitorChart').getContext('2d');

        const visitorGradient = visitorCtx.createLinearGradient(0, 0, 0, 400);
        visitorGradient.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
        visitorGradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

        let visitorChart = new Chart(visitorCtx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: [120, 190, 300, 500, 200, 300, 450],
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: visitorGradient,
                    fill: true,
                    borderWidth: 3,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(34, 197, 94)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: 'rgb(34, 197, 94)',
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
                                return `Pengunjung: ${context.parsed.y} orang`;
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
                                return value + ' org';
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

        function loadVisitorChart(filter) {
            updateButtonStyle('visitor', filter);

            fetch(`/api/pengunjung?filter=${filter}`)
                .then(res => res.json())
                .then(data => {
                    visitorChart.data.labels = data.labels;
                    visitorChart.data.datasets[0].data = data.data;
                    visitorChart.update('active');
                })
                .catch(error => {
                    console.error('Error loading visitor chart:', error);
                });
        }

        // Initialize charts with default data
        loadTicketChart('harian');
        loadVisitorChart('harian');

        // Ticket chart event listeners
        document.getElementById('btn-tiket-harian').addEventListener('click', () => loadTicketChart('harian'));
        document.getElementById('btn-tiket-mingguan').addEventListener('click', () => loadTicketChart('mingguan'));
        document.getElementById('btn-tiket-bulanan').addEventListener('click', () => loadTicketChart('bulanan'));

        // Visitor chart event listeners
        document.getElementById('btn-visitor-harian').addEventListener('click', () => loadVisitorChart('harian'));
        document.getElementById('btn-visitor-mingguan').addEventListener('click', () => loadVisitorChart('mingguan'));
        document.getElementById('btn-visitor-bulanan').addEventListener('click', () => loadVisitorChart('bulanan'));

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Add loading states for buttons
        function addLoadingState(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
            button.disabled = true;

            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 1000);
        }

        // Enhanced interactivity
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', function() {
                if (this.textContent.includes('Generate') || this.textContent.includes('Export')) {
                    addLoadingState(this);
                }
            });
        });
    </script>
    @endsection
</body>

</html>