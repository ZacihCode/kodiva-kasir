<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-blue-50 to-indigo-100 py-4 sm:py-8 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-lg mb-4 animate-bounce-soft">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent mb-2">
                Pengaturan Gaji
            </h1>
            <p class="text-gray-600 text-sm sm:text-base">Kelola komponen gaji dan tunjangan karyawan</p>
        </div>

        <!-- Main Container -->
        <div class="bg-white/90 backdrop-blur-sm border border-white/20 rounded-3xl shadow-2xl overflow-hidden animate-slide-up">
            <!-- Success Message -->
            @if (session('message'))
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-6 animate-fade-in">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-green-800 font-semibold">{{ session('message') }}</p>
                        <p class="text-green-600 text-sm mt-1">Perubahan akan berlaku untuk perhitungan gaji selanjutnya.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Content -->
            <div class="p-6 sm:p-8">
                <form wire:submit.prevent="save" class="space-y-8">

                    <!-- Gaji per Hadir -->
                    <div class="group">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <label class="block text-lg font-bold text-gray-800">Gaji per Hadir</label>
                                <p class="text-sm text-gray-500">Nominal gaji yang diterima per hari kehadiran</p>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-semibold">Rp</span>
                            </div>
                            <input
                                type="number"
                                wire:model.defer="gaji_per_hadir"
                                @disabled(!$editable)
                                class="w-full pl-12 pr-4 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-2 border-gray-200 rounded-2xl focus:from-white focus:to-blue-50 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-lg font-semibold group-hover:border-blue-300"
                                placeholder="0"
                                min="0"
                                step="1000" />
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">per hari</span>
                            </div>
                        </div>
                        @error('gaji_per_hadir')
                        <span class="text-red-500 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <!-- Tunjangan Default -->
                    <div class="group">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <label class="block text-lg font-bold text-gray-800">Tunjangan Default</label>
                                <p class="text-sm text-gray-500">Tunjangan tambahan yang diberikan secara default</p>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-semibold">Rp</span>
                            </div>
                            <input
                                type="number"
                                wire:model.defer="tunjangan_default"
                                @disabled(!$editable)
                                class="w-full pl-12 pr-4 py-4 bg-gradient-to-r from-gray-50 to-emerald-50 border-2 border-gray-200 rounded-2xl focus:from-white focus:to-emerald-50 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition-all duration-300 text-lg font-semibold group-hover:border-emerald-300"
                                placeholder="0"
                                min="0"
                                step="1000" />
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">bonus</span>
                            </div>
                        </div>
                        @error('tunjangan_default')
                        <span class="text-red-500 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <!-- Potongan Default -->
                    <div class="group">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </div>
                            <div>
                                <label class="block text-lg font-bold text-gray-800">Potongan Default</label>
                                <p class="text-sm text-gray-500">Potongan standar yang diterapkan pada gaji</p>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-semibold">Rp</span>
                            </div>
                            <input
                                type="number"
                                wire:model.defer="potongan_default"
                                @disabled(!$editable)
                                class="w-full pl-12 pr-4 py-4 bg-gradient-to-r from-gray-50 to-red-50 border-2 border-gray-200 rounded-2xl focus:from-white focus:to-red-50 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-300 text-lg font-semibold group-hover:border-red-300"
                                placeholder="0"
                                min="0"
                                step="1000" />
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">potongan</span>
                            </div>
                        </div>
                        @error('potongan_default')
                        <span class="text-red-500 text-sm mt-2 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
                            <!-- Summary Info -->
                            <div class="text-sm text-gray-600">
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pengaturan akan berlaku untuk semua karyawan
                                </p>
                            </div>

                            <!-- Save Button -->
                            @if (!$editable)
                            <!-- Tombol Edit -->
                            <button
                                type="button"
                                wire:click="enableEdit"
                                class="px-6 py-3 bg-yellow-500 text-white font-bold rounded-2xl shadow hover:bg-yellow-600 hover:scale-105 transition-all duration-300">
                                ✏️ Edit Pengaturan
                            </button>
                            @else
                            <button
                                type="submit"
                                class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-200 overflow-hidden">
                                <!-- Shimmer effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>

                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Pengaturan</span>
                            </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8 animate-fade-in">
            <!-- Card 1 -->
            <div class="bg-white/70 backdrop-blur-sm border border-white/30 rounded-2xl p-4 hover:bg-white/90 transition-all duration-300 hover:scale-105">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Otomatis</h4>
                </div>
                <p class="text-sm text-gray-600">Sistem akan menghitung gaji berdasarkan kehadiran secara otomatis</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white/70 backdrop-blur-sm border border-white/30 rounded-2xl p-4 hover:bg-white/90 transition-all duration-300 hover:scale-105">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 bg-emerald-100 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Fleksibel</h4>
                </div>
                <p class="text-sm text-gray-600">Dapat disesuaikan kapan saja sesuai kebijakan perusahaan</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white/70 backdrop-blur-sm border border-white/30 rounded-2xl p-4 hover:bg-white/90 transition-all duration-300 hover:scale-105">
                <div class="flex items-center mb-2">
                    <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Transparan</h4>
                </div>
                <p class="text-sm text-gray-600">Perhitungan gaji yang jelas dan mudah dipahami</p>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce-soft {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .animate-slide-up {
            animation: slideUp 0.3s ease-out;
        }

        .animate-bounce-soft {
            animation: bounce-soft 2s infinite;
        }

        .group:hover {
            transform: scale(1.02);
        }
    </style>
</div>