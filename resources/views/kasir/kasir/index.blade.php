<!DOCTYPE html>
<html lang="en" x-data="cashierSystem()" x-init="init()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sendang Plesungan - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            transform: translateY(-2px);
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

        .ticket-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border: 2px solid transparent;
            background-clip: padding-box;
            transition: all 0.3s ease;
        }

        .ticket-card:hover {
            border-color: #3b82f6;
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.1);
        }

        .ticket-card.selected {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }

        .quantity-button {
            transition: all 0.2s ease;
        }

        .quantity-button:hover {
            transform: scale(1.1);
        }

        .quantity-button:active {
            transform: scale(0.95);
        }

        .cart-item {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-left: 4px solid #3b82f6;
        }

        .modal-backdrop {
            backdrop-filter: blur(8px);
        }

        .receipt-paper {
            background: linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%),
                linear-gradient(45deg, #ffffff 25%, transparent 25%, transparent 75%, #ffffff 75%);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }

        .pulse-border {
            animation: pulseBorder 2s infinite;
        }

        @keyframes pulseBorder {

            0%,
            100% {
                border-color: #3b82f6;
            }

            50% {
                border-color: #60a5fa;
            }
        }

        .floating-icon {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
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

        .qris-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    <div id="toast-root"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-info="{{ session('info') ?: ($infoMessage ?? '') }}">
    </div>
    @vite(['resources/js/app.jsx'])
    @section('content')
    <div class="min-h-screen ml-6 mr-2 p-6">
        <!-- Enhanced Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 fade-in">
            <div class="mb-4 lg:mb-0">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center floating-icon">
                        <i class="fas fa-cash-register text-white text-xl"></i>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        Menu Kasir
                    </h2>
                </div>
                <p class="text-gray-600 text-lg">Sistem kasir tiket renang modern dan efisien</p>
            </div>
        </div>

        <!-- Main Cashier Interface -->
        <div class="flex flex-col xl:flex-row gap-8 mb-8">
            <!-- Ticket Selection Panel -->
            <div class="w-full xl:w-2/3 bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 scale-in border border-white/20">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-ticket-alt text-blue-500 mr-3"></i>
                        Pilih Tiket
                    </h3>
                    <div class="text-sm text-gray-500">
                        <span x-text="cart.length"></span> item dipilih
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="ticket in ticketTypes" :key="ticket.id">
                        <div class="ticket-card p-6 rounded-2xl" :class="{ 'selected': getQuantity(ticket) > 0 }">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-gray-800 mb-1" x-text="ticket.name"></h4>
                                    <p class="text-sm text-gray-600 mb-3" x-text="ticket.description"></p>
                                    <div class="text-2xl font-bold text-blue-600" x-text="'Rp ' + ticket.price.toLocaleString('id-ID')"></div>
                                </div>
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-swimming-pool text-blue-600"></i>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <button class="quantity-button w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg"
                                        @click="decreaseFromCart(ticket)"
                                        :disabled="getQuantity(ticket) === 0">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="text-2xl font-bold text-gray-800 min-w-[3rem] text-center" x-text="getQuantity(ticket)">0</span>
                                    <button class="quantity-button w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg"
                                        @click="addToCart(ticket)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <div class="text-sm text-gray-500">Subtotal</div>
                                <div class="font-bold text-gray-700" x-text="'Rp ' + (ticket.price * getQuantity(ticket)).toLocaleString('id-ID')"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Enhanced Options Section -->
                <div class="mt-8 space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Discount Selection -->
                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 p-6 rounded-2xl border border-orange-100">
                            <label class="flex items-center text-lg font-semibold text-gray-800 mb-3">
                                <i class="fas fa-percentage text-orange-500 mr-2"></i>
                                Pilih Diskon
                            </label>
                            <select x-model.number="selectedDiscount" class="custom-select w-full p-3 border-0 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all duration-200">
                                <option value="0">Tanpa Diskon</option>
                                <template x-for="diskon in discountOptions" :key="diskon.id">
                                    <option :value="diskon.percentage" x-text="diskon.name + ' - ' + diskon.percentage + '%'"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Parking Selection -->
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-6 rounded-2xl border border-purple-100">
                            <label class="flex items-center text-lg font-semibold text-gray-800 mb-3">
                                <i class="fas fa-car text-purple-500 mr-2"></i>
                                Jenis Parkir
                            </label>
                            <select x-model.number="selectedParking" class="custom-select w-full p-3 border-0 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all duration-200">
                                <option value="0">Tanpa Parkir</option>
                                <template x-for="park in parkingOptions" :key="park.id">
                                    <option :value="park.fee" x-text="park.name + ' - Rp ' + park.fee.toLocaleString('id-ID')"></option>
                                </template>
                            </select>

                            <!-- License Plate Input -->
                            <div class="mt-4" x-show="selectedParking > 0" x-transition>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Plat Nomor Kendaraan</label>
                                <input type="text"
                                    x-model="platNomor"
                                    class="w-full p-3 border-0 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all duration-200 uppercase"
                                    placeholder="B 1234 ABC"
                                    maxlength="15">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-2xl border border-green-100">
                        <label class="flex items-center text-lg font-semibold text-gray-800 mb-3">
                            <i class="fas fa-credit-card text-green-500 mr-2"></i>
                            Metode Pembayaran
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-4 bg-white rounded-xl border-2 cursor-pointer transition-all duration-200"
                                :class="paymentMethod === 'cash' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                                <input type="radio" x-model="paymentMethod" value="cash" class="sr-only">
                                <i class="fas fa-money-bill-wave text-green-500 text-2xl mr-3"></i>
                                <div>
                                    <div class="font-semibold text-gray-800">Tunai</div>
                                    <div class="text-sm text-gray-600">Bayar dengan uang cash</div>
                                </div>
                            </label>
                            <label class="flex items-center p-4 bg-white rounded-xl border-2 cursor-pointer transition-all duration-200"
                                :class="paymentMethod === 'qris' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                                <input type="radio" x-model="paymentMethod" value="qris" class="sr-only">
                                <i class="fas fa-qrcode text-green-500 text-2xl mr-3"></i>
                                <div>
                                    <div class="font-semibold text-gray-800">QRIS</div>
                                    <div class="text-sm text-gray-600">Scan QR Code</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Cart & Payment Panel -->
            <div class="w-full xl:w-1/3 bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl p-6 lg:p-8 slide-up border border-white/20">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-shopping-cart text-purple-500 mr-3"></i>
                        Keranjang
                    </h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">Items:</span>
                        <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-sm font-bold" x-text="cart.reduce((sum, item) => sum + item.quantity, 0)">0</span>
                    </div>
                </div>

                <div class="space-y-3 mb-6 min-h-[300px] max-h-[400px] overflow-y-auto scrollbar-hide">
                    <template x-if="cart.length === 0">
                        <div class="text-center text-gray-500 mt-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-shopping-cart text-4xl text-gray-400"></i>
                            </div>
                            <p class="text-lg font-medium">Keranjang Kosong</p>
                            <p class="text-sm">Pilih tiket untuk memulai transaksi</p>
                        </div>
                    </template>

                    <template x-for="item in cart" :key="item.ticket.id">
                        <div class="cart-item p-4 rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-800" x-text="item.ticket.name"></h4>
                                <button @click="decreaseFromCart(item.ticket)" class="text-red-500 hover:text-red-700 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-600">Qty:</span>
                                    <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full text-sm font-bold" x-text="item.quantity"></span>
                                </div>
                                <span class="font-bold text-blue-600" x-text="'Rp ' + (item.ticket.price * item.quantity).toLocaleString('id-ID')"></span>
                            </div>
                        </div>
                    </template>

                    <template x-if="selectedParking > 0 && platNomor">
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-4 rounded-xl border border-purple-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-car text-purple-500"></i>
                                    <span class="font-medium text-gray-700">Parkir</span>
                                </div>
                                <span class="font-bold text-purple-600" x-text="platNomor"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Enhanced Price Breakdown -->
                <div class="border-t-2 border-gray-100 pt-6 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold text-gray-800" x-text="'Rp ' + subtotal.toLocaleString('id-ID')"></span>
                    </div>
                    <div class="flex justify-between items-center" x-show="selectedDiscount > 0">
                        <div class="flex items-center space-x-2">
                            <span class="text-orange-600">Diskon:</span>
                            <span class="bg-orange-100 text-orange-600 px-2 py-1 rounded-full text-xs font-bold" x-text="selectedDiscount + '%'"></span>
                        </div>
                        <span class="font-semibold text-orange-600" x-text="'- Rp ' + discountAmount.toLocaleString('id-ID')"></span>
                    </div>
                    <div class="flex justify-between items-center" x-show="selectedParking > 0">
                        <span class="text-purple-600">Biaya Parkir:</span>
                        <span class="font-semibold text-purple-600" x-text="'Rp ' + selectedParking.toLocaleString('id-ID')"></span>
                    </div>
                    <div class="border-t-2 border-gray-100 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-800">Total Bayar:</span>
                            <span class="text-2xl font-bold text-blue-600" x-text="'Rp ' + totalAll.toLocaleString('id-ID')">Rp 0</span>
                        </div>
                    </div>

                    <button
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-4 rounded-2xl font-bold text-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transform hover:scale-105"
                        :class="{ 'pulse-border': cart.length > 0 }"
                        :disabled="cart.length === 0"
                        @click="paymentMethod === 'qris' ? showQrisModal = true : (saveTransaction(), showReceipt = true)">
                        <i class="fas fa-credit-card mr-2"></i>
                        Proses Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced QRIS Modal -->
    <div x-show="showQrisModal"
        x-cloak
        class="fixed inset-0 z-50 modal-backdrop bg-black/50 flex items-center justify-center p-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="qris-container rounded-3xl shadow-2xl max-w-md w-full p-8 text-white"
            @click.outside="showQrisModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-qrcode text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold mb-2">Pembayaran QRIS</h2>
                <p class="text-white/80">Scan QR Code untuk melakukan pembayaran</p>
                <div class="bg-white/20 rounded-xl p-3 mt-4">
                    <div class="text-3xl font-bold" x-text="'Rp ' + totalAll.toLocaleString('id-ID')"></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl mb-6">
                <div class="w-48 h-48 bg-gray-100 mx-auto rounded-xl flex items-center justify-center">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-qrcode text-6xl mb-2"></i>
                        <p class="text-sm">QR Code Placeholder</p>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4">
                <button class="flex-1 bg-white/20 hover:bg-white/30 text-white py-3 rounded-xl font-medium transition-all duration-200"
                    @click="showQrisModal = false">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
                <button class="flex-1 bg-white text-purple-600 py-3 rounded-xl font-bold hover:bg-gray-100 transition-all duration-200"
                    @click="showQrisModal = false; saveTransaction(); showReceipt = true">
                    <i class="fas fa-check mr-2"></i>
                    Sudah Bayar
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Receipt Modal -->
    <div x-show="showReceipt"
        x-cloak
        class="fixed inset-0 z-50 modal-backdrop bg-black/50 flex items-center justify-center p-4"
        x-transition>
        <div class="receipt-paper bg-white rounded-3xl shadow-2xl max-w-md w-full p-8"
            @click.outside="showReceipt = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-receipt text-blue-600 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">Struk Pembayaran</h2>
                <h3 class="text-xl font-semibold text-blue-600 mb-4">Wisata Sendang Plesungan</h3>
                <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Tanggal:</span>
                        <span x-text="new Date().toLocaleDateString('id-ID')"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Waktu:</span>
                        <span x-text="new Date().toLocaleTimeString('id-ID')"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Metode:</span>
                        <span class="font-semibold" x-text="paymentMethod === 'qris' ? 'QRIS' : 'Tunai'"></span>
                    </div>
                    <template x-if="selectedParking > 0 && platNomor">
                        <div class="flex justify-between">
                            <span>Plat Nomor:</span>
                            <span class="font-semibold" x-text="platNomor"></span>
                        </div>
                    </template>
                </div>
            </div>

            <div class="border-t-2 border-dashed border-gray-300 pt-4 mb-4">
                <h4 class="font-semibold text-gray-800 mb-3">Detail Pembelian:</h4>
                <template x-for="item in cart" :key="item.ticket.id">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <div>
                            <span class="text-gray-800" x-text="item.ticket.name"></span>
                            <span class="text-gray-500 text-sm" x-text="' x' + item.quantity"></span>
                        </div>
                        <span class="font-semibold text-gray-800" x-text="'Rp ' + (item.ticket.price * item.quantity).toLocaleString('id-ID')"></span>
                    </div>
                </template>

                <template x-if="selectedDiscount > 0">
                    <div class="flex justify-between py-2 text-orange-600">
                        <span>Diskon (<span x-text="selectedDiscount"></span>%)</span>
                        <span x-text="'- Rp ' + discountAmount.toLocaleString('id-ID')"></span>
                    </div>
                </template>

                <template x-if="selectedParking > 0">
                    <div class="flex justify-between py-2 text-purple-600">
                        <span>Biaya Parkir</span>
                        <span x-text="'Rp ' + selectedParking.toLocaleString('id-ID')"></span>
                    </div>
                </template>
            </div>

            <div class="border-t-2 border-dashed border-gray-300 pt-4 mb-6">
                <div class="flex justify-between items-center text-xl">
                    <span class="font-bold text-gray-800">Total Bayar:</span>
                    <span class="font-bold text-blue-600" x-text="'Rp ' + totalAll.toLocaleString('id-ID')"></span>
                </div>
            </div>

            <div class="flex space-x-4">
                <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-medium transition-all duration-200"
                    @click="showReceipt = false">
                    <i class="fas fa-times mr-2"></i>
                    Tutup
                </button>
                <button class="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-bold hover:from-blue-600 hover:to-purple-700 transition-all duration-200"
                    @click="printReceipt()">
                    <i class="fas fa-print mr-2"></i>
                    Cetak Struk
                </button>
            </div>
        </div>
    </div>
    @endsection

    <script>
        const COLS = 32

        function cashierSystem() {
            return {
                cart: [],
                showReceipt: false,
                showQrisModal: false,
                selectedDiscount: 0,
                selectedParking: 0,
                paymentMethod: 'cash',
                discountOptions: [],
                parkingOptions: [],
                ticketTypes: [],
                platNomor: '',

                async init() {
                    try {
                        const [ticketsRes, discountsRes, parkingsRes] = await Promise.all([
                            fetch(`/api/tickets`, {
                                credentials: 'include'
                            }),
                            fetch(`/api/discounts`, {
                                credentials: 'include'
                            }),
                            fetch(`/api/parkings`, {
                                credentials: 'include'
                            }),
                        ]);

                        const rawTickets = await ticketsRes.json();
                        const rawDiscounts = await discountsRes.json();
                        const rawParkings = await parkingsRes.json();

                        this.ticketTypes = rawTickets.map(item => ({
                            id: item.id,
                            name: item.nama_produk || item.name || 'Tidak ada nama',
                            description: item.deskripsi || item.description || '',
                            price: Number(item.harga || item.price || 0),
                        }));

                        this.discountOptions = rawDiscounts.map(item => ({
                            id: item.id,
                            name: item.jenis_diskon,
                            percentage: item.persentase,
                        }));

                        this.parkingOptions = rawParkings.map(item => ({
                            id: item.id,
                            name: item.jenis_parkir,
                            fee: Number(item.harga),
                        }));
                    } catch (error) {
                        console.error("Gagal fetch data:", error);
                        // Show user-friendly error message
                        showToast('error', 'Gagal memuat data. Silakan refresh halaman.');
                    }
                },

                async saveTransaction() {
                    if (this.cart.length === 0) {
                        showToast('warning', 'Keranjang masih kosong!');
                        return;
                    }

                    try {
                        const res = await fetch(`/api/transaksi`, {
                            method: 'POST',
                            credentials: 'include',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            },
                            body: JSON.stringify({
                                metode_pembayaran: this.paymentMethod,
                                subtotal: this.subtotal,
                                diskon: this.discountAmount,
                                parkir: this.selectedParking,
                                total: this.totalAll,
                                plat_nomor: this.platNomor,
                                detail: this.cart.map(item => ({
                                    name: item.ticket.name,
                                    quantity: item.quantity,
                                    price: item.ticket.price,
                                    subtotal: item.ticket.price * item.quantity
                                })),
                            })
                        });

                        const result = await res.json();
                        if (res.ok) {
                            console.log("Transaksi berhasil:", result);
                            showToast('success', 'Transaksi berhasil disimpan!');
                        } else {
                            throw new Error(result.message || 'Gagal menyimpan transaksi');
                        }
                    } catch (error) {
                        console.error("Gagal simpan transaksi:", error);
                        showToast('error', 'Gagal menyimpan transaksi. Silakan coba lagi.');
                    }
                },

                addToCart(ticket) {
                    const index = this.cart.findIndex(i => i.ticket.id === ticket.id);
                    if (index !== -1) {
                        this.cart[index].quantity++;
                    } else {
                        this.cart.push({
                            ticket,
                            quantity: 1
                        });
                    }
                    showToast('success', `${ticket.name} ditambahkan ke keranjang`);
                },

                decreaseFromCart(ticket) {
                    const index = this.cart.findIndex(i => i.ticket.id === ticket.id);
                    if (index !== -1) {
                        if (this.cart[index].quantity > 1) {
                            this.cart[index].quantity--;
                        } else {
                            this.cart.splice(index, 1);
                            showToast('info', `${ticket.name} dihapus dari keranjang`);
                        }
                    }
                },

                getQuantity(ticket) {
                    const item = this.cart.find(i => i.ticket.id === ticket.id);
                    return item ? item.quantity : 0;
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.ticket.price * item.quantity), 0);
                },

                get discountAmount() {
                    return Math.round(this.subtotal * (this.selectedDiscount / 100));
                },

                get totalAll() {
                    return Math.max(0, this.subtotal - this.discountAmount + this.selectedParking);
                },

                formatRupiah(value) {
                    return value.toLocaleString('id-ID');
                },

                wrapText(str) {
                    const words = String(str).split(/\s+/);
                    const lines = [];
                    let line = '';
                    for (const w of words) {
                        if ((line + (line ? ' ' : '') + w).length <= COLS) {
                            line += (line ? ' ' : '') + w;
                        } else {
                            if (line) lines.push(line);
                            // kalau 1 kata > COLS, paksa pecah
                            if (w.length > COLS) {
                                let s = w;
                                while (s.length > COLS) {
                                    lines.push(s.slice(0, COLS));
                                    s = s.slice(COLS);
                                }
                                line = s;
                            } else {
                                line = w;
                            }
                        }
                    }
                    if (line) lines.push(line);
                    return lines;
                },

                // kiri-kanan (teks, nominal) agar pas 1 baris
                lineLR(left, right) {
                    const l = left.length;
                    const r = right.length;
                    if (l + r >= COLS) return left.slice(0, Math.max(0, COLS - r - 1)) + ' ' + right;
                    return left + ' '.repeat(COLS - l - r) + right;
                },

                CRLF(s) {
                    return s.replace(/\n/g, '\r\n');
                },

                printReceipt() {
                    const now = new Date().toLocaleString('id-ID');
                    const metode = this.paymentMethod === 'qris' ? 'QRIS' : 'Tunai';

                    // Bangun konten dengan wrap 32 kolom
                    const body = [];

                    // Item
                    for (const item of this.cart) {
                        const name = `${item.ticket.name} x${item.quantity}`;
                        const price = `Rp${this.formatRupiah(item.ticket.price * item.quantity)}`;
                        body.push(lineLR(name, price));
                    }
                    if (this.discountAmount > 0) {
                        body.push(lineLR(`Diskon (${this.selectedDiscount}%)`, `-Rp${this.formatRupiah(this.discountAmount)}`));
                    }
                    if (this.selectedParking > 0) {
                        body.push(lineLR(`Parkir`, `Rp${this.formatRupiah(this.selectedParking)}`));
                    }

                    const totalLine = lineLR('TOTAL', `Rp${this.formatRupiah(this.totalAll)}`);

                    // ESC/POS buffer builder
                    let esc = '';
                    esc += '\x1B\x40'; // ESC @  -> reset
                    esc += '\x1B\x74\x10'; // ESC t 16 -> codepage 1252 (aman utk Latin). Kalau buruk, coba \x00 (CP437)
                    esc += '\x1B\x32'; // ESC 2 -> default line spacing
                    esc += '\x1B\x61\x01'; // ESC a 1 -> center
                    esc += '\x1B\x45\x01'; // ESC E 1 -> bold on
                    wrapText('WISATA SENDANG PLESUNG').forEach(l => esc += l + '\r\n');
                    esc += '\x1B\x45\x00'; // bold off
                    wrapText('Struk Pembayaran').forEach(l => esc += l + '\r\n');
                    esc += now + '\r\n';
                    esc += '\x1B\x61\x00'; // left
                    esc += lineLR('Kasir: Admin', `Metode: ${metode}`) + '\r\n';
                    if (this.platNomor) esc += `Plat: ${this.platNomor}\r\n`;
                    esc += '-'.repeat(COLS) + '\r\n';

                    body.forEach(l => esc += CRLF(l) + '\r\n');
                    esc += '-'.repeat(COLS) + '\r\n';
                    esc += totalLine + '\r\n\r\n';
                    wrapText('Terima kasih atas kunjungan Anda!').forEach(l => esc += l + '\r\n');
                    wrapText('Simpan struk ini sebagai bukti pembayaran').forEach(l => esc += l + '\r\n');

                    esc += '\r\n\r\n\r\n';
                    esc += '\x1D\x56\x00'; // GS V 0 -> partial cut (kalau printer mendukung)

                    this.connectAndPrintViaBluetooth(esc);
                },

                async connectAndPrintViaBluetooth(receiptText) {
                    // ESC/POS minimal: init + teks + 3 LF (tanpa cutter)
                    const encoder = new TextEncoder();
                    const payload = encoder.encode('\x1B\x40' + receiptText + '\n\n\n');

                    // kandidat UUID yang sering dipakai printer thermal BLE
                    const CANDIDATE_SERVICES = [
                        0xff00, 0xfff0, 0xffe0, // vendor short UUIDs
                        '0000ff00-0000-1000-8000-00805f9b34fb',
                        '0000fff0-0000-1000-8000-00805f9b34fb',
                        '0000ffe0-0000-1000-8000-00805f9b34fb',
                        0x18f0, 0x180f, 0x180a // sering ada tambahan battery/info
                    ];

                    try {
                        const device = await navigator.bluetooth.requestDevice({
                            filters: [{
                                namePrefix: 'RPP'
                            }],
                            optionalServices: CANDIDATE_SERVICES
                        });

                        const server = await device.gatt.connect();

                        // cari service yang punya characteristic writeable
                        let writableChar = null;
                        const services = await server.getPrimaryServices();
                        for (const svc of services) {
                            const chars = await svc.getCharacteristics();
                            for (const ch of chars) {
                                const props = ch.properties;
                                if (props.write || props.writeWithoutResponse) {
                                    writableChar = ch;
                                    break;
                                }
                            }
                            if (writableChar) break;
                        }

                        if (!writableChar) throw new Error('Tidak menemukan characteristic yang bisa ditulis.');

                        // tulis per 20 byte (MTU umum)
                        const CHUNK = 20;
                        for (let i = 0; i < payload.length; i += CHUNK) {
                            const slice = payload.slice(i, i + CHUNK);
                            if (writableChar.properties.write) {
                                await writableChar.writeValue(slice); // with response
                            } else {
                                await writableChar.writeValueWithoutResponse(slice); // faster, no response
                            }
                            await new Promise(r => setTimeout(r, 10)); // jeda kecil
                        }

                        showToast('success', '✅ Struk terkirim via BLE.');
                        this.resetTransaction();
                    } catch (err) {
                        console.error(err);
                        showToast('error', '❌ Gagal BLE: ' + err.message);
                    }
                },

                resetTransaction() {
                    this.cart = [];
                    this.selectedDiscount = 0;
                    this.selectedParking = 0;
                    this.platNomor = '';
                    this.paymentMethod = 'cash';
                    this.showReceipt = false;
                    this.showQrisModal = false;
                },
            }
        }
    </script>
</body>

</html>