@extends('layouts.app')

@section('content')
<!-- Keuangan Page -->
<div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 fade-in">
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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

        <!-- Keuangan Manager (Livewire Component) -->
        <div class="bg-white rounded-2xl shadow-lg p-6 fade-in">
            <livewire:keuangan-manager />
        </div>
    </div>
</div>
@endsection