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
        <livewire:keuangan-manager />
    </div>
</div>
@endsection