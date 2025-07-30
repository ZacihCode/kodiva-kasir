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
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 p-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4 fade-in">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Laporan & Analisis</h2>
                    <p class="text-gray-600 mt-2">Laporan komprehensif sistem kasir tiket</p>
                </div>
                <div class="flex items-center space-x-4">
                    <input type="date"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Filter
                    </button>
                </div>
            </div>
            <!-- Laporan Page -->
            <div id="laporan-page" class="grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="flex items-center justify-between mb-8 fade-in">
                    <div class="flex items-center space-x-4">
                        <select class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Hari Ini</option>
                            <option>Minggu Ini</option>
                            <option>Bulan Ini</option>
                            <option>Tahun Ini</option>
                        </select>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            📊 Generate Laporan
                        </button>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                            📄 Export PDF
                        </button>
                    </div>
                </div>

                <!-- Report Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Total Pengunjung</p>
                                <p class="text-2xl font-bold text-blue-600">1,245</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 text-xl">👥</span>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            <span>↗ +15% dari periode sebelumnya</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Omset Total</p>
                                <p class="text-2xl font-bold text-green-600">Rp 18.675.000</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 text-xl">💰</span>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            <span>↗ +22% dari periode sebelumnya</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Rata-rata per Hari</p>
                                <p class="text-2xl font-bold text-purple-600">Rp 2.669.000</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                <span class="text-purple-600 text-xl">📈</span>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            <span>↗ +8% dari periode sebelumnya</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm">Laba Bersih</p>
                                <p class="text-2xl font-bold text-orange-600">Rp 14.140.000</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-orange-600 text-xl">🎯</span>
                            </div>
                        </div>
                        <div class="mt-4 text-sm text-gray-600">
                            <span>↗ +18% dari periode sebelumnya</span>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Penjualan per Jenis Tiket</h3>
                        <canvas id="ticketChart" width="400" height="300"></canvas>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-6">Trend Pengunjung</h3>
                        <canvas id="visitorChart" width="400" height="300"></canvas>
                    </div>
                </div>

                <!-- Detailed Reports -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Laporan Detail</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-4 border rounded-lg">
                            <h4 class="font-bold text-gray-800 mb-3">📊 Laporan Keuangan</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li>• Pemasukan: Rp 18.675.000</li>
                                <li>• Pengeluaran: Rp 4.535.000</li>
                                <li>• Laba Kotor: Rp 14.140.000</li>
                                <li>• Margin: 75.7%</li>
                            </ul>
                        </div>
                        <div class="p-4 border rounded-lg">
                            <h4 class="font-bold text-gray-800 mb-3">🎫 Laporan Tiket</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li>• Tiket Dewasa: 845 (68%)</li>
                                <li>• Tiket Anak: 285 (23%)</li>
                                <li>• Tiket VIP: 85 (7%)</li>
                                <li>• Tiket Lansia: 30 (2%)</li>
                            </ul>
                        </div>
                        <div class="p-4 border rounded-lg">
                            <h4 class="font-bold text-gray-800 mb-3">👥 Laporan Karyawan</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li>• Rata-rata Kehadiran: 87%</li>
                                <li>• Total Jam Kerja: 1,260 jam</li>
                                <li>• Lembur: 45 jam</li>
                                <li>• Absen: 3 karyawan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>