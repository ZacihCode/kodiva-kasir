<!DOCTYPE html>
<html lang="en" x-data="cashierSystem()" x-init="init()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Sendang Plesungan - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        <!-- Enhanced Header dengan struktur asli yang diperbaiki -->
        <style>
            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                50% {
                    transform: translateY(-6px) rotate(1deg);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes shimmer {
                0% {
                    background-position: -200% 0;
                }

                100% {
                    background-position: 200% 0;
                }
            }

            @keyframes statusPulse {

                0%,
                100% {
                    transform: scale(1);
                    opacity: 1;
                }

                50% {
                    transform: scale(1.05);
                    opacity: 0.8;
                }
            }

            .floating-icon {
                animation: float 3s ease-in-out infinite;
                box-shadow: 0 8px 32px rgba(99, 102, 241, 0.3);
            }

            .fade-in {
                animation: fadeInUp 0.6s ease-out;
            }

            .gradient-text {
                background: linear-gradient(135deg, #1e40af, #7c3aed, #4338ca);
                background-size: 300% 300%;
                animation: shimmer 4s ease-in-out infinite;
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .status-connected {
                animation: statusPulse 2s infinite;
            }

            .btn-modern:hover {
                background: linear-gradient(135deg, #374151, #4b5563);
                transform: translateY(-1px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }
        </style>

        <!-- Enhanced Header (Compact for Mobile) -->
        <div
            class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 fade-in 
            bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 
            rounded-2xl p-4 sm:p-6 shadow-lg border border-white/20 backdrop-blur-sm">
            <!-- Title Section -->
            <div class="mb-4 lg:mb-0 text-center lg:text-left">
                <div class="flex flex-col sm:flex-row items-center sm:items-start sm:space-x-3 mb-2">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500 via-purple-600 to-indigo-600 
                        rounded-2xl flex items-center justify-center floating-icon shadow-xl mb-2 sm:mb-0">
                        <i class="fas fa-cash-register text-white text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl sm:text-3xl lg:text-5xl font-bold gradient-text leading-snug">
                            Menu Kasir
                        </h2>
                        <div class="flex justify-center sm:justify-start items-center mt-1">
                            <div class="w-8 h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full"></div>
                            <div class="w-4 h-1 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full ml-1"></div>
                            <div class="w-2 h-1 bg-indigo-600 rounded-full ml-1"></div>
                        </div>
                    </div>
                </div>
                <p
                    class="text-gray-600 text-sm sm:text-base lg:text-lg font-medium 
                    mt-1 sm:ml-16 bg-gradient-to-r from-gray-600 to-gray-700 bg-clip-text text-transparent">
                    Sistem kasir tiket renang modern dan efisien
                </p>
            </div>
            <!-- Control Section -->
            <div
                class="flex flex-col sm:flex-row flex-wrap items-stretch gap-3 w-full lg:w-auto">
                <!-- Width Selection -->
                <div
                    class="flex items-center gap-2 bg-white/80 backdrop-blur-sm rounded-xl 
                    p-3 shadow-md border border-white/30 w-full sm:w-auto">
                    <div
                        class="flex items-center justify-center w-8 h-8 
                        bg-gradient-to-br from-emerald-400 to-blue-500 rounded-lg">
                        <i class="fas fa-print text-white text-xs"></i>
                    </div>
                    <div class="w-full">
                        <label for="colsSelect"
                            class="block text-xs font-semibold text-gray-700 mb-0.5">Lebar Struk</label>
                        <select id="colsSelect"
                            class="block w-full sm:w-40 rounded-lg border-gray-200 shadow-sm 
                            focus:border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-opacity-50 
                            bg-white/90 text-xs sm:text-sm font-medium transition-all duration-200">
                            <option value="32">32 Kolom (58mm, Font A)</option>
                            <option value="42">42 Kolom (58mm, Font B) [Default]</option>
                            <option value="48">48 Kolom (80mm)</option>
                        </select>
                    </div>
                </div>

                <!-- Connection Status -->
                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 
                    bg-white/80 backdrop-blur-sm rounded-xl p-3 shadow-md border border-white/30 
                    w-full sm:w-auto">
                    <div
                        class="flex items-center justify-center w-8 h-8 
                        bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg">
                        <i class="fas fa-bluetooth text-white text-xs"></i>
                    </div>
                    <div class="flex items-center justify-between w-full sm:w-auto gap-2">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1.5">
                                <span x-text="btStatus"
                                    class="text-xs sm:text-sm font-bold px-2 py-1 rounded-lg shadow-sm transition-all duration-300"
                                    :class="btStatus==='Connected' ? 'bg-emerald-100 text-emerald-700 status-connected' : 'bg-amber-100 text-amber-700'">
                                </span>
                                <div
                                    :class="btStatus==='Connected' ? 'w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse' : 'w-1.5 h-1.5 bg-amber-500 rounded-full'">
                                </div>
                            </div>
                            <span class="text-[11px] text-slate-600 font-medium mt-0.5"
                                x-text="btName ? ('(' + btName + ')') : ''"></span>
                        </div>
                        <button @click="quickReconnect()"
                            class="text-xs sm:text-sm font-semibold px-3 py-1.5 rounded-lg 
                            bg-gradient-to-r from-slate-700 to-slate-800 text-white 
                            hover:from-slate-600 hover:to-slate-700 shadow-md transition-all duration-200 btn-modern">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Reconnect
                        </button>
                    </div>
                </div>
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

                    <!-- Customer Identity -->
                    <div class="bg-gradient-to-r from-sky-50 to-cyan-50 p-6 rounded-2xl border border-sky-100">
                        <label class="flex items-center text-lg font-semibold text-gray-800 mb-3">
                            <i class="fas fa-user text-sky-500 mr-2"></i>
                            Identitas Pengunjung
                        </label>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-700 mb-1">Nama</label>
                                <input type="text"
                                    x-model.trim="customerName"
                                    class="w-full p-3 border-0 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-200"
                                    placeholder="Nama lengkap">
                            </div>

                            <div>
                                <label class="block text-sm text-gray-700 mb-1">No. HP</label>
                                <input type="tel"
                                    x-model.trim="customerPhone"
                                    inputmode="tel" pattern="[0-9+ ]*"
                                    class="w-full p-3 border-0 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500 transition-all duration-200"
                                    placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <p class="mt-2 text-xs text-gray-500">Opsional. Membantu identifikasi pengunjung saat diperlukan.</p>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-2xl border border-green-100">
                        <label class="flex items-center text-lg font-semibold text-gray-800 mb-3">
                            <i class="fas fa-credit-card text-green-500 mr-2"></i>
                            Metode Pembayaran
                        </label>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
                            <label
                                class="group w-full rounded-xl border-2 bg-white cursor-pointer transition-all duration-200 p-3 sm:p-4 flex flex-col sm:flex-row items-start sm:items-center gap-3 min-h-[64px]"
                                :class="paymentMethod === 'cash' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                                <input type="radio" x-model="paymentMethod" value="cash" class="sr-only" />
                                <i class="fas fa-money-bill-wave text-green-500 text-xl sm:text-2xl"></i>
                                <div class="font-semibold text-gray-800 text-sm sm:text-base">Tunai</div>
                                <div class="leading-tight">
                                    <div class="text-xs sm:text-sm text-gray-600">Bayar dengan uang cash</div>
                                </div>
                            </label>

                            <label
                                class="group w-full rounded-xl border-2 bg-white cursor-pointer transition-all duration-200 p-3 sm:p-4 flex flex-col sm:flex-row items-start sm:items-center gap-3 min-h-[64px]"
                                :class="paymentMethod === 'qris' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'">
                                <input type="radio" x-model="paymentMethod" value="qris" class="sr-only" />
                                <i class="fas fa-qrcode text-green-500 text-xl sm:text-2xl"></i>
                                <div class="font-semibold text-gray-800 text-sm sm:text-base">QRIS</div>
                                <div class="leading-tight">
                                    <div class="text-xs sm:text-sm text-gray-600">Scan QR Code</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Cash Amount -->
                    <div class="mt-4 rounded-2xl bg-white/70 p-4 border border-green-100"
                        x-show="paymentMethod === 'cash'"
                        x-transition>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Bayar</label>

                        <div class="flex items-center gap-3">
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number"
                                    min="0" step="1000" inputmode="numeric"
                                    x-model.number="cashGiven"
                                    class="w-full pl-10 p-3 border-0 rounded-xl bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200"
                                    placeholder="0" />
                            </div>
                            <!-- Tombol cepat: set ke total -->
                            <button type="button"
                                class="px-3 py-2 rounded-lg text-sm bg-green-100 text-green-700 hover:bg-green-200"
                                @click="cashGiven = totalAll">
                                Pas
                            </button>
                        </div>

                        <div class="mt-3 text-sm space-y-1">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total</span>
                                <span class="font-semibold" x-text="'Rp ' + totalAll.toLocaleString('id-ID')"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nominal Bayar</span>
                                <span class="font-semibold" x-text="'Rp ' + (cashGiven || 0).toLocaleString('id-ID')"></span>
                            </div>
                            <div class="flex justify-between"
                                :class="(cashGiven - totalAll) >= 0 ? 'text-emerald-600' : 'text-red-600'">
                                <span x-text="(cashGiven - totalAll) >= 0 ? 'Kembalian' : 'Kurang'"></span>
                                <span class="font-bold"
                                    x-text="'Rp ' + Math.abs((cashGiven - totalAll) || 0).toLocaleString('id-ID')"></span>
                            </div>
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
                        @click="paymentMethod === 'qris' ? (showQrisModal = true) : (showReceipt = true)">
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
                <button
                    class="flex-1 bg-white text-purple-600 py-3 rounded-xl font-bold hover:bg-gray-100 transition-all duration-200"
                    @click="showQrisModal = false; showReceipt = true">
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
        let COLS = parseInt(localStorage.getItem("printer_cols") || "42", 10);

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
                cashGiven: 0,
                userPhone: '',
                userAddress: '',
                lastTrxId: null,
                customerName: '',
                customerPhone: '',
                logoBytes: null,

                btDevice: null,
                btChar: null,
                btStatus: 'Disconnected',
                btName: '',
                BT_SERVICE_HINTS: [
                    '000018f0-0000-1000-8000-00805f9b34fb'
                ],

                wait(ms) {
                    return new Promise(r => setTimeout(r, ms));
                },
                updateBtStatus() {
                    const connected = !!(this.btChar && this.btDevice?.gatt?.connected);
                    this.btStatus = connected ? 'Connected' : 'Disconnected';
                    this.btName = this.btDevice?.name || (localStorage.getItem('printer_name') || '');
                },

                async tryConnect(dev, tries = 3, baseDelay = 500) {
                    for (let i = 0; i < tries; i++) {
                        try {
                            if (dev.gatt.connected) return;
                            // kadang perlu disconnect dulu biar bersih
                            try {
                                dev.gatt.disconnect();
                            } catch (_) {}
                            await this.wait(50);
                            await dev.gatt.connect();
                            return; // sukses
                        } catch (e) {
                            if (e.name !== 'NetworkError' && e.name !== 'NotFoundError') throw e;
                            // backoff
                            await this.wait(baseDelay * (i + 1));
                        }
                    }
                    throw new Error('Gagal connect setelah beberapa percobaan (NetworkError).');
                },

                async ensureAdvertising(dev, timeout = 2000) {
                    if (!dev.watchAdvertisements) return; // nggak semua platform support
                    try {
                        await dev.watchAdvertisements();
                    } catch (_) {}
                    await Promise.race([
                        new Promise(res => dev.addEventListener('advertisementreceived', () => res(), {
                            once: true
                        })),
                        this.wait(timeout)
                    ]);
                },

                // === helpers kolom 3 ===
                padLeft(s, w) {
                    s = String(s);
                    return s.length >= w ? s.slice(-w) : ' '.repeat(w - s.length) + s;
                },

                padRight(s, w) {
                    s = String(s);
                    return s.length >= w ? s.slice(0, w) : s + ' '.repeat(w - s.length);
                },

                wrapN(str, width) {
                    const words = String(str).split(/\s+/);
                    const lines = [];
                    let line = '';
                    for (const w of words) {
                        if ((line + (line ? ' ' : '') + w).length <= width) line += (line ? ' ' : '') + w;
                        else {
                            if (line) lines.push(line);
                            if (w.length > width) {
                                let s = w;
                                while (s.length > width) {
                                    lines.push(s.slice(0, width));
                                    s = s.slice(width);
                                }
                                line = s;
                            } else line = w;
                        }
                    }
                    if (line) lines.push(line);
                    return lines;
                },

                rowItem(name, qty, priceStr) {
                    // Sesuaikan lebar otomatis
                    const qtyW = 4; // lebar Qty
                    const priceW = 10; // lebar Harga minimal
                    const nameW = COLS - qtyW - priceW - 1;

                    const nameLines = this.wrapN(name, nameW);
                    let out = '';
                    nameLines.forEach((ln, i) => {
                        if (i === 0) {
                            out += this.padRight(ln, nameW) +
                                ' ' +
                                this.padLeft(qty, qtyW) +
                                this.padLeft(priceStr, priceW) + '\r\n';
                        } else {
                            out += this.padRight(ln, nameW) + '\r\n';
                        }
                    });
                    return out;
                },

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
                        showToast('error', 'Gagal memuat data. Silakan refresh halaman.');
                    }

                    try {
                        const userRes = await fetch('/api/user', {
                            credentials: 'include'
                        });
                        if (userRes.ok) {
                            const me = await userRes.json();
                            this.userPhone = me.phone || me.telepon || me.no_hp || '';
                            this.userAddress = me.address || me.alamat || '';
                        }
                    } catch (_) {}

                    // auto-reconnect (tanpa dialog) saat halaman dibuka
                    if ('bluetooth' in navigator) {
                        requestAnimationFrame(async () => {
                            await this.ensurePrinter(false).catch(() => {});
                            this.updateBtStatus(); // <— TAMBAHKAN
                            this.initHooks();
                        });
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
                                customer_name: this.customerName,
                                customer_phone: this.customerPhone,
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
                            const newId = result?.id || result?.data?.id;
                            this.lastTrxId = newId ?? null;
                            showToast('success', 'Transaksi berhasil disimpan!');
                            return newId; // <- penting, kembalikan id
                        } else {
                            throw new Error(result.message || 'Gagal menyimpan transaksi');
                        }
                    } catch (error) {
                        console.error("Gagal simpan transaksi:", error);
                        throw error;
                    }
                },

                addToCart(ticket) {
                    const index = this.cart.findIndex(i => i.ticket.id === ticket.id);
                    if (index !== -1) this.cart[index].quantity++;
                    else this.cart.push({
                        ticket,
                        quantity: 1
                    });
                    showToast('success', `${ticket.name} ditambahkan ke keranjang`);
                },

                decreaseFromCart(ticket) {
                    const index = this.cart.findIndex(i => i.ticket.id === ticket.id);
                    if (index !== -1) {
                        if (this.cart[index].quantity > 1) this.cart[index].quantity--;
                        else {
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
                    return this.cart.reduce((s, it) => s + (it.ticket.price * it.quantity), 0);
                },

                get discountAmount() {
                    return Math.round(this.subtotal * (this.selectedDiscount / 100));
                },

                get totalAll() {
                    return Math.max(0, this.subtotal - this.discountAmount + this.selectedParking);
                },

                formatRupiah(v) {
                    return v.toLocaleString('id-ID');
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

                lineLR(left, right) {
                    const l = left.length,
                        r = right.length;
                    if (l + r >= COLS) {
                        return left.slice(0, Math.max(0, COLS - r - 1)) + ' ' + right;
                    }
                    return left + ' '.repeat(COLS - l - r) + right;
                },

                concatUint8(arrays) {
                    let total = arrays.reduce((s, a) => s + (a ? a.length : 0), 0);
                    let out = new Uint8Array(total);
                    let offset = 0;
                    for (const a of arrays) {
                        if (!a) continue;
                        out.set(a, offset);
                        offset += a.length;
                    }
                    return out;
                },

                // === raster logo: kecil + latar putih + handle alpha ===
                async makeLogoRaster(url, maxWidth = 100) {
                    const img = new Image();
                    img.crossOrigin = 'anonymous';
                    img.src = url;
                    await img.decode();

                    // --- canvas asal untuk baca pixel ---
                    const src = document.createElement('canvas');
                    src.width = img.width;
                    src.height = img.height;
                    const sctx = src.getContext('2d', {
                        willReadFrequently: true
                    });
                    // latar putih supaya PNG transparan tidak jadi hitam
                    sctx.fillStyle = '#FFFFFF';
                    sctx.fillRect(0, 0, src.width, src.height);
                    sctx.drawImage(img, 0, 0);

                    // --- trim pinggiran putih/transparan ---
                    const {
                        x,
                        y,
                        w,
                        h
                    } = this._trimBounds(sctx, src.width, src.height);
                    const scale = Math.min(1, maxWidth / w);
                    const W = Math.max(1, Math.round(w * scale));
                    const H = Math.max(1, Math.round(h * scale));

                    // canvas final setelah trim + resize
                    const canvas = document.createElement('canvas');
                    canvas.width = W;
                    canvas.height = H;
                    const ctx = canvas.getContext('2d', {
                        willReadFrequently: true
                    });
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(0, 0, W, H);
                    ctx.drawImage(src, x, y, w, h, 0, 0, W, H);

                    const data = ctx.getImageData(0, 0, W, H).data;

                    // 1-bit packing
                    const bytesPerRow = Math.ceil(W / 8);
                    const bitmap = new Uint8Array(bytesPerRow * H);
                    const threshold = 195; // naikkan utk garis lebih tipis

                    for (let yy = 0; yy < H; yy++) {
                        for (let xx = 0; xx < W; xx++) {
                            const i = (yy * W + xx) * 4;
                            let r = data[i],
                                g = data[i + 1],
                                b = data[i + 2],
                                a = data[i + 3];
                            let gray = 0.299 * r + 0.587 * g + 0.114 * b;
                            if (a < 255) { // komposit di atas putih
                                const alp = a / 255;
                                gray = gray * alp + 255 * (1 - alp);
                            }
                            const bit = gray < threshold ? 1 : 0;
                            const byteIndex = yy * bytesPerRow + (xx >> 3);
                            bitmap[byteIndex] |= bit << (7 - (xx & 7));
                        }
                    }

                    // GS v 0 (raster bit image)
                    const header = new Uint8Array([
                        0x1D, 0x76, 0x30, 0x00,
                        bytesPerRow & 0xFF, (bytesPerRow >> 8) & 0xFF,
                        H & 0xFF, (H >> 8) & 0xFF
                    ]);

                    return this.concatUint8([header, bitmap, new TextEncoder().encode('\r\n')]);
                },

                _trimBounds(ctx, w, h) {
                    const img = ctx.getImageData(0, 0, w, h).data;
                    const white = 250; // >250 dianggap putih
                    const alphaMin = 10; // <10 dianggap transparan
                    let top = h,
                        left = w,
                        right = -1,
                        bottom = -1;

                    for (let y = 0; y < h; y++) {
                        for (let x = 0; x < w; x++) {
                            const i = (y * w + x) * 4;
                            const r = img[i],
                                g = img[i + 1],
                                b = img[i + 2],
                                a = img[i + 3];
                            if (a > alphaMin && !(r > white && g > white && b > white)) {
                                if (x < left) left = x;
                                if (x > right) right = x;
                                if (y < top) top = y;
                                if (y > bottom) bottom = y;
                            }
                        }
                    }
                    if (right < 0) return {
                        x: 0,
                        y: 0,
                        w: 1,
                        h: 1
                    }; // semua putih
                    return {
                        x: left,
                        y: top,
                        w: right - left + 1,
                        h: bottom - top + 1
                    };
                },

                async quickReconnect() {
                    try {
                        await this.ensurePrinter(true);
                        this.updateBtStatus(); // <— TAMBAHKAN
                        showToast('success', `Terhubung ke ${this.btDevice?.name || 'printer'}.`);
                    } catch (e) {
                        showToast('error', e.message || 'Gagal reconnect.');
                    }
                },

                initHooks() {
                    // Saat tab kembali aktif, coba cek koneksi tanpa dialog
                    document.addEventListener('visibilitychange', async () => {
                        if (document.visibilityState === 'visible') {
                            try {
                                await this.ensurePrinter(false);
                            } catch (_) {}
                            this.updateBtStatus();
                        }
                    });

                    // Jika Bluetooth adapter on/off, refresh status
                    try {
                        navigator.bluetooth.addEventListener?.('availabilitychanged', () => this.updateBtStatus());
                    } catch (_) {}
                },

                async printReceipt() {
                    // simpan transaksi dulu supaya dapat ID
                    let trxId = null;
                    try {
                        trxId = await this.saveTransaction();
                    } catch (e) {
                        showToast('error', 'Gagal menyimpan transaksi: ' + (e?.message || ''));
                        return;
                    }

                    // pairing / connect (di gesture klik yang sama)
                    try {
                        await this.ensurePrinter(true);
                    } catch (e) {
                        showToast('error', 'Tidak bisa mengakses Bluetooth: ' + e.message);
                        return;
                    }

                    const now = new Date().toLocaleString('id-ID');
                    const metode = (this.paymentMethod === 'qris') ? 'Cashless' : 'Cash';

                    // ===== ESC/POS =====
                    let esc = '';
                    esc += '\x1B\x40'; // reset
                    esc += '\x1B\x74\x00'; // CP437
                    esc += '\x1B\x4D\x01'; // Font B (42 col)
                    esc += '\x1B\x32'; // line spacing

                    // Header tengah
                    esc += '\x1B\x61\x01';
                    esc += '\x1B\x45\x01';
                    this.wrapText('WISATA SENDANG PLESUNGAN').forEach(l => esc += l + '\r\n');
                    esc += '\x1B\x45\x00';

                    // Alamat & Telp dari user login
                    if (this.userAddress) this.wrapText(this.userAddress).forEach(l => esc += l + '\r\n');

                    esc += '-'.repeat(COLS) + '\r\n';

                    // Info transaksi
                    esc += '\x1B\x61\x00';
                    esc += this.lineLR('Kode Transaksi: ' + (trxId ? ('TRX' + trxId) : '-'), 'Pembayaran: ' + metode) + '\r\n';
                    esc += 'Tanggal: ' + now + '\r\n';

                    // CETAK PLAT (jika ada)
                    if (this.platNomor && this.platNomor.trim()) {
                        esc += `Plat: ${this.platNomor.trim().toUpperCase()}\r\n`;
                    }

                    if (this.customerName) esc += `Nama: ${this.customerName}\r\n`;
                    if (this.customerPhone) esc += `Telp: ${this.customerPhone}\r\n`;
                    esc += '\r\n';

                    // Header tabel 3 kolom
                    const hNama = this.padRight('Nama Barang', 26);
                    const hQty = this.padLeft('Qty', 4);
                    const hHarga = this.padLeft('Harga', COLS - 26 - 4 - 1);
                    esc += hNama + ' ' + hQty + hHarga + '\r\n';
                    esc += '-'.repeat(COLS) + '\r\n';

                    // Baris item (harga per item)
                    for (const it of this.cart) {
                        esc += this.rowItem(it.ticket.name, it.quantity, 'Rp' + this.formatRupiah(it.ticket.price));
                    }

                    esc += '-'.repeat(COLS) + '\r\n';

                    // Diskon & Parkir (jika ada)
                    if (this.discountAmount > 0) {
                        esc += this.lineLR(`Diskon (${this.selectedDiscount}%)`, `-Rp${this.formatRupiah(this.discountAmount)}`) + '\r\n';
                    }
                    if (this.selectedParking > 0) {
                        esc += this.lineLR('Parkir', `Rp${this.formatRupiah(this.selectedParking)}`) + '\r\n';
                    }

                    // Total, Nominal Bayar, Kembalian
                    const nominalBayar = (this.paymentMethod === 'cash' && this.cashGiven > 0) ? this.cashGiven : this.totalAll;
                    const kembalian = Math.max(0, nominalBayar - this.totalAll);

                    esc += this.lineLR('Total', `Rp${this.formatRupiah(this.totalAll)}`) + '\r\n';
                    esc += this.lineLR('Nominal Bayar', `Rp${this.formatRupiah(nominalBayar)}`) + '\r\n';
                    esc += this.lineLR('Kembalian', `Rp${this.formatRupiah(kembalian)}`) + '\r\n';

                    esc += '='.repeat(COLS) + '\r\n';
                    esc += '\x1B\x61\x01';
                    esc += 'Terima Kasih!\r\n';
                    if (this.userPhone) esc += 'Saran & Kritik:' + this.userPhone + '\r\n';
                    esc += '='.repeat(COLS) + '\r\n';
                    esc += '\r\n\r\n';
                    esc += '\x1B\x61\x00';
                    esc += '\x1D\x56\x00'; // cut

                    const encoder = new TextEncoder();
                    const payload = encoder.encode(esc);

                    await this.connectAndPrintViaBluetooth(payload, /*skipEnsure=*/ true);
                },

                async ensurePrinter(interactive = false) {
                    if (!('bluetooth' in navigator)) throw new Error('Browser tidak mendukung Web Bluetooth.');
                    if (!window.isSecureContext) throw new Error('Akses Bluetooth butuh HTTPS atau localhost.');
                    if (this.btChar && this.btDevice?.gatt?.connected) return;

                    const prefixRe = /^(RPP|MPT|POS|QR|PT-)/i; // umum printer thermal
                    const savedId = localStorage.getItem('printer_id') || null;
                    const savedName = localStorage.getItem('printer_name') || null;
                    const savedSvc = localStorage.getItem('printer_svc') || null;
                    const savedChr = localStorage.getItem('printer_chr') || null;

                    try {
                        const available = await navigator.bluetooth.getAvailability?.();
                        if (available === false) throw new Error('Bluetooth adapter tidak tersedia / dimatikan di OS.');

                        const allowed = (await navigator.bluetooth.getDevices?.()) || [];
                        let dev = null;

                        if (savedId) dev = allowed.find(d => d.id === savedId) || null;
                        if (!dev && savedName) dev = allowed.find(d => (d.name || '') === savedName) || null;
                        if (!dev) dev = allowed.find(d => prefixRe.test(d.name || '')) || null;
                        if (!dev && allowed.length) dev = allowed[0];

                        if (!dev) {
                            if (!interactive) throw new Error('Belum ada printer yang diizinkan untuk origin ini.');
                            try {
                                // coba pakai filter dulu
                                dev = await navigator.bluetooth.requestDevice({
                                    filters: [{
                                            namePrefix: 'RPP'
                                        },
                                        {
                                            namePrefix: 'MPT'
                                        },
                                        {
                                            namePrefix: 'POS'
                                        },
                                        {
                                            namePrefix: 'QR'
                                        },
                                        {
                                            namePrefix: 'PT-'
                                        }
                                    ],
                                    optionalServices: this.BT_SERVICE_HINTS
                                });
                            } catch (err) {
                                console.warn("Filter gagal, fallback ke acceptAllDevices:", err);
                                // fallback: tampilkan semua device biar user bisa pilih manual
                                dev = await navigator.bluetooth.requestDevice({
                                    acceptAllDevices: true,
                                    optionalServices: this.BT_SERVICE_HINTS
                                });
                            }
                        }

                        this.btDevice = dev;
                        this.btDevice.addEventListener('gattserverdisconnected', () => {
                            this.btChar = null;
                            this.updateBtStatus();
                        });

                        // Tunggu device advertising supaya connect() nggak lempar NetworkError
                        await this.ensureAdvertising(dev, 1500);

                        // Coba connect dengan retry (bersihin koneksi stale)
                        await this.tryConnect(dev, 3, 500);

                        // === Cari characteristic tulis ===
                        let svc = null,
                            chr = null;
                        try {
                            if (savedSvc) {
                                svc = await dev.gatt.getPrimaryService(savedSvc);
                                if (savedChr) {
                                    chr = await svc.getCharacteristic(savedChr);
                                    if (!(chr.properties.write || chr.properties.writeWithoutResponse)) chr = null;
                                }
                            }
                        } catch (_) {
                            /* fallback ke scan semua */
                        }

                        if (!chr) {
                            const services = await dev.gatt.getPrimaryServices();
                            outer: for (const s of services) {
                                const chars = await s.getCharacteristics();
                                for (const c of chars) {
                                    if (c.properties.write || c.properties.writeWithoutResponse) {
                                        svc = s;
                                        chr = c;
                                        break outer;
                                    }
                                }
                            }
                        }

                        if (!chr) throw new Error('Characteristic tulis tidak ditemukan pada printer.');

                        this.btChar = chr;

                        // Simpan hint untuk sesi berikutnya (id sering berubah, nama & uuid lebih stabil)
                        try {
                            localStorage.setItem('printer_id', dev.id || '');
                            if (dev.name) localStorage.setItem('printer_name', dev.name);
                            if (svc?.uuid) localStorage.setItem('printer_svc', svc.uuid);
                            if (chr?.uuid) localStorage.setItem('printer_chr', chr.uuid);
                        } catch (_) {}
                        this.updateBtStatus();

                    } catch (e) {
                        const name = e?.name || '';
                        if (name === 'NotAllowedError') throw new Error('Akses ditolak. Pilih perangkat pada dialog atau izinkan Bluetooth.');
                        if (name === 'NotFoundError') throw new Error('Printer tidak ditemukan. Nyalakan printer & dekatkan perangkat.');
                        if (name === 'SecurityError') throw new Error('Harus diakses via HTTPS atau localhost.');
                        if (name === 'NetworkError') throw new Error('Gagal connect. Coba aktifkan/printer-advertising lalu ulangi.');
                        throw e;
                    }
                },

                async connectAndPrintViaBluetooth(payload, skipEnsure = false) {
                    if (typeof payload === 'string') payload = new TextEncoder().encode(payload);
                    if (!skipEnsure) await this.ensurePrinter(true);

                    const CHUNK = 20; // BLE ATT default
                    const NEEDS_DELAY = this.btChar.properties.writeWithoutResponse ? 8 : 0; // 8–10ms aman
                    for (let i = 0; i < payload.length; i += CHUNK) {
                        const slice = payload.slice(i, i + CHUNK);
                        if (this.btChar.properties.write) {
                            await this.btChar.writeValue(slice);
                        } else {
                            await this.btChar.writeValueWithoutResponse(slice);
                        }
                        if (NEEDS_DELAY) await this.wait(NEEDS_DELAY);
                    }
                    showToast('success', 'Struk terkirim.');
                    this.updateBtStatus();
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
        document.addEventListener("DOMContentLoaded", function() {
            const select = document.getElementById("colsSelect");

            // Ambil setting sebelumnya dari localStorage
            let savedCols = localStorage.getItem("printer_cols") || "42";
            select.value = savedCols;
            COLS = parseInt(savedCols, 10);

            // Kalau user ubah dropdown, update localStorage + variable global
            select.addEventListener("change", function() {
                localStorage.setItem("printer_cols", this.value);
                COLS = parseInt(this.value, 10);
                showToast('success', 'Lebar struk diubah ke ' + COLS + ' kolom. Cetak struk berikutnya akan mengikuti.');
            });
        });
    </script>
</body>

</html>