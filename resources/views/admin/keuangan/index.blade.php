@extends('layouts.app')

@section('content')
<!-- Keuangan Page -->
<div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4 fade-in">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Keuangan</h2>
                <p class="text-gray-600 mt-2">Pencatatan pemasukan dan pengeluaran</p>
            </div>
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
                <input type="date"
                    class="w-full sm:w-auto border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button
                    class="w-full sm:w-auto bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Filter
                </button>
            </div>
        </div>

        <!-- Financial Summary Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Pemasukan Hari Ini</p>
                        <p class="text-2xl font-bold text-green-600">Rp 2.450.000</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-green-600 text-xl">📈</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Pengeluaran Hari Ini</p>
                        <p class="text-2xl font-bold text-red-600">Rp 450.000</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <span class="text-red-600 text-xl">📉</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Laba Bersih</p>
                        <p class="text-2xl font-bold text-blue-600">Rp 2.000.000</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 text-xl">💰</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Saldo Kas</p>
                        <p class="text-2xl font-bold text-purple-600">Rp 15.500.000</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-purple-600 text-xl">🏦</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Forms Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Tambah Pemasukan</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Penjualan Tiket</option>
                            <option>Parkir</option>
                            <option>Kantin</option>
                            <option>Lain-lain</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                        <input type="number"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan jumlah">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3"></textarea>
                    </div>
                    <button
                        class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition-colors">
                        Simpan Pemasukan
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Tambah Pengeluaran</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Listrik</option>
                            <option>Gaji Karyawan</option>
                            <option>Pemeliharaan</option>
                            <option>Bahan Kimia</option>
                            <option>Lain-lain</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                        <input type="number"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan jumlah">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="3"></textarea>
                    </div>
                    <button
                        class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition-colors">
                        Simpan Pengeluaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection