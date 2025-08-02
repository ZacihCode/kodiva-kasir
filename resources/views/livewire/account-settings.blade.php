<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-4 sm:py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8 animate-fade-in">
            <h1 class="text-3xl sm:text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                Pengaturan Akun
            </h1>
            <p class="text-gray-600 text-sm sm:text-base">Kelola informasi profil dan keamanan akun Anda</p>
        </div>

        <!-- Main Container -->
        <div class="bg-white/80 backdrop-blur-sm border border-white/20 rounded-2xl shadow-xl overflow-hidden animate-slide-up">
            <!-- Profile Section -->
            <div class="p-6 sm:p-8">
                <!-- Success Message for Profile -->
                @if (session('success_profile'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 mb-6 animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-700 font-medium">{{ session('success_profile') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Profile Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Informasi Profil</h2>
                            <p class="text-gray-500 text-sm">Update data pribadi Anda</p>
                        </div>
                    </div>

                    <button wire:click="enableEdit" class="group relative inline-flex items-center px-6 py-3 {{ $editMode ? 'bg-gradient-to-r from-gray-500 to-gray-600' : 'bg-gradient-to-r from-amber-500 to-orange-500' }} text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-amber-200">
                        <svg class="w-4 h-4 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>{{ $editMode ? 'Batal Edit' : 'Edit Profil' }}</span>
                    </button>
                </div>

                <!-- Profile Form -->
                <form wire:submit.prevent="updateProfile" class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Nama Lengkap
                            </label>
                            <input type="text" wire:model.defer="name"
                                class="w-full px-4 py-3 {{ $editMode ? 'bg-white' : 'bg-gray-50' }} border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 group-hover:border-gray-300"
                                {{ $editMode ? '' : 'readonly' }} />
                            @error('name')
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Phone Field -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Nomor Telepon
                            </label>
                            <input type="text" wire:model.defer="phone"
                                class="w-full px-4 py-3 {{ $editMode ? 'bg-white' : 'bg-gray-50' }} border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 group-hover:border-gray-300"
                                {{ $editMode ? '' : 'readonly' }} />
                            @error('phone')
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Field (readonly) -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            Email (tidak dapat diubah)
                        </label>
                        <input type="email" value="{{ $email }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl cursor-not-allowed"
                            readonly />
                    </div>

                    <!-- Address Field -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Alamat Lengkap
                        </label>
                        <textarea wire:model.defer="address" rows="4"
                            class="w-full px-4 py-3 {{ $editMode ? 'bg-white' : 'bg-gray-50' }} border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200 group-hover:border-gray-300 resize-none"
                            {{ $editMode ? '' : 'readonly' }}
                            placeholder="Masukkan alamat lengkap Anda..."></textarea>
                        @error('address')
                        <span class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <!-- Save Button -->
                    @if ($editMode)
                    <div class="pt-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Divider -->
            <div class="border-t border-gradient-to-r from-transparent via-gray-200 to-transparent"></div>

            <!-- Password Section -->
            <div class="p-6 sm:p-8 bg-gradient-to-br from-gray-50/50 to-white/50">
                <!-- Success Message for Password -->
                @if (session('success_password'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 mb-6 animate-fade-in">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-700 font-medium">{{ session('success_password') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Password Header -->
                <div class="flex items-center mb-8">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Keamanan Akun</h3>
                        <p class="text-gray-500 text-sm">Ubah password untuk menjaga keamanan akun</p>
                    </div>
                </div>

                <!-- Password Form -->
                <form wire:submit.prevent="updatePassword" class="space-y-6">
                    <!-- Current Password -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Password Saat Ini
                        </label>
                        <input type="password" wire:model.defer="current_password"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-200 group-hover:border-gray-300"
                            placeholder="Masukkan password saat ini" />
                        @error('current_password')
                        <span class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Password Baru
                            </label>
                            <input type="password" wire:model.defer="new_password"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-200 group-hover:border-gray-300"
                                placeholder="Password baru" />
                            @error('new_password')
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" wire:model.defer="confirm_password"
                                class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-200 group-hover:border-gray-300"
                                placeholder="Konfirmasi password baru" />
                            @error('confirm_password')
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Change Password Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-red-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-8 bg-white/60 backdrop-blur-sm border border-white/20 rounded-2xl p-6 animate-fade-in">
            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Tips Keamanan
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Gunakan password yang kuat dengan kombinasi huruf, angka, dan simbol
                </div>
                <div class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Pastikan informasi profil selalu up-to-date
                </div>
                <div class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Jangan bagikan password Anda kepada siapapun
                </div>
                <div class="flex items-start">
                    <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Ubah password secara berkala untuk keamanan optimal
                </div>
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

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .animate-slide-up {
            animation: slideUp 0.3s ease-out;
        }
    </style>
</div>