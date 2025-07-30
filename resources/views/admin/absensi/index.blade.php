<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan - Sistem Kasir Tiket</title>
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4 fade-in">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Absensi Karyawan</h2>
                    <p class="text-gray-600 mt-2">Sistem absensi menggunakan barcode scanner</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        📷 Scan Barcode
                    </button>
                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                        ➕ Absen Manual
                    </button>
                </div>
            </div>
            <!-- Absensi Page -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Karyawan</p>
                            <p class="text-2xl font-bold text-gray-800">15</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="text-gray-600 text-xl">👥</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Hadir Hari Ini</p>
                            <p class="text-2xl font-bold text-green-600">12</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 text-xl">✅</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Tidak Hadir</p>
                            <p class="text-2xl font-bold text-red-600">2</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <span class="text-red-600 text-xl">❌</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Terlambat</p>
                            <p class="text-2xl font-bold text-orange-600">1</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                            <span class="text-orange-600 text-xl">⏰</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance List -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Daftar Absensi Hari Ini</h3>
                    <div class="flex space-x-2">
                        <input type="date"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            Filter
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-gray-600 border-b">
                                <th class="pb-3 font-medium">Nama Karyawan</th>
                                <th class="pb-3 font-medium">Jam Masuk</th>
                                <th class="pb-3 font-medium">Jam Keluar</th>
                                <th class="pb-3 font-medium">Status</th>
                                <th class="pb-3 font-medium">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="py-3 text-gray-800">Budi Santoso</td>
                                <td class="py-3 text-gray-800">08:00</td>
                                <td class="py-3 text-gray-800">-</td>
                                <td class="py-3"><span
                                        class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Hadir</span></td>
                                <td class="py-3 text-gray-800">Tepat waktu</td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="py-3 text-gray-800">Siti Nurhaliza</td>
                                <td class="py-3 text-gray-800">08:15</td>
                                <td class="py-3 text-gray-800">-</td>
                                <td class="py-3"><span
                                        class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-sm">Terlambat</span>
                                </td>
                                <td class="py-3 text-gray-800">Terlambat 15 menit</td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="py-3 text-gray-800">Ahmad Fauzi</td>
                                <td class="py-3 text-gray-800">-</td>
                                <td class="py-3 text-gray-800">-</td>
                                <td class="py-3"><span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm">Tidak
                                        Hadir</span></td>
                                <td class="py-3 text-gray-800">Sakit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection
</body>

</html>