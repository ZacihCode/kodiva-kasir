<div class="p-4 sm:p-6 lg:p-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <!-- Header -->
    <div class="relative mb-8">
        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl blur opacity-20"></div>
        <div class="relative bg-white/90 backdrop-blur-sm p-6 rounded-3xl shadow-lg border border-white/50">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                            📢
                        </div>
                        Broadcast WhatsApp Pelanggan
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base mt-2">
                        Ambil kontak dari transaksi & kirim pengumuman/promo via Fonnte
                    </p>
                </div>
                <div class="flex gap-3 w-full lg:w-auto">
                    <div class="relative flex-1 lg:w-72">
                        <input wire:model.defer="search" type="text" placeholder="Cari nama/nomor"
                            class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 pr-12 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all duration-200" />
                        <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button wire:click="$refresh"
                        class="px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl border border-gray-200 hover:bg-gray-200 active:scale-95 transition-all duration-200 text-sm font-medium">
                        Cari
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if (session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent"></div>
        <div class="relative flex items-center gap-3">
            <div class="w-5 h-5 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check text-white text-xs"></i>
            </div>
            {{ session('success') }}
        </div>
    </div>
    @endif
    @if (session('error'))
    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 shadow-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-transparent"></div>
        <div class="relative flex items-center gap-3">
            <div class="w-5 h-5 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-exclamation text-white text-xs"></i>
            </div>
            {{ session('error') }}
        </div>
    </div>
    @endif
    @error('selected')
    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 shadow-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-transparent"></div>
        <div class="relative">{{ $message }}</div>
    </div>
    @enderror
    @error('message')
    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 shadow-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-red-500/10 to-transparent"></div>
        <div class="relative">{{ $message }}</div>
    </div>
    @enderror

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Composer -->
        <div class="lg:col-span-1 bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/50 p-6 flex flex-col hover:shadow-xl transition-all duration-300">
            <h3 class="font-semibold text-lg text-gray-900 mb-4 flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                    ✍️
                </div>
                Isi Pesan
            </h3>
            <div class="relative mb-4">
                <textarea wire:model.defer="message" rows="8"
                    class="w-full border-2 border-gray-200 rounded-2xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none bg-gray-50/50 focus:bg-white shadow-sm"
                    placeholder="Halo {nama}, ..."></textarea>
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-blue-500/5 to-purple-500/5 pointer-events-none"></div>
            </div>
            <div class="bg-blue-50/80 rounded-xl p-3 mb-4 border border-blue-100">
                <p class="text-xs font-medium text-blue-800 mb-1">📝 Placeholder yang didukung:</p>
                <code class="px-2 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-mono">{nama}</code>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                    <div class="w-5 h-5 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-percent text-white text-xs"></i>
                    </div>
                    Pilih Diskon
                </label>
                <select wire:model="diskonId"
                    class="w-full border-2 border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50/50 focus:bg-white shadow-sm">
                    <option value="">-- Tanpa Diskon --</option>
                    @foreach ($diskons as $d)
                    <option value="{{ $d->id }}">
                        {{ $d->jenis_diskon }} - {{ $d->persentase }}%
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Info kontak -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-4 text-white text-center">
                    <div class="text-2xl font-bold">{{ $totalContacts }}</div>
                    <div class="text-blue-100 text-xs">Total kontak</div>
                </div>
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-4 text-white text-center">
                    <div class="text-2xl font-bold">{{ $selectedCount }}</div>
                    <div class="text-purple-100 text-xs">Terpilih</div>
                </div>
            </div>

            <!-- Tombol aksi -->
            <div class="mt-auto flex flex-col sm:flex-row gap-3">
                <div class="relative group flex-1">
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-75 group-hover:opacity-100 transition duration-200"></div>
                    <button wire:click="sendSelected" wire:loading.attr="disabled"
                        class="relative w-full flex items-center justify-center px-4 py-3 bg-white text-gray-900 text-sm rounded-2xl group-hover:bg-gradient-to-r group-hover:from-blue-600 group-hover:to-purple-600 group-hover:text-white font-semibold disabled:opacity-60 transition-all duration-200">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Broadcast
                    </button>
                </div>
                <button wire:click="clearSelection"
                    class="px-4 py-3 bg-gray-100 text-gray-700 text-sm rounded-2xl hover:bg-gray-200 active:scale-95 transition-all duration-200 font-medium">
                    Reset Pilihan
                </button>
            </div>

            <!-- Progress bar -->
            @if ($sending)
            <div class="mt-6 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-blue-800">Mengirim pesan...</span>
                    <span class="text-sm text-blue-600">{{ $progress }}%</span>
                </div>
                <div class="w-full bg-blue-200 rounded-full h-2 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500 ease-out relative"
                        :style="width: {{ $progress }}%">
                        <div class="absolute inset-0 bg-white/20 animate-pulse rounded-full"></div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Tabel kontak -->
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-transparent">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                            📇
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-900">Daftar Kontak</h3>
                            <p class="text-gray-500 text-sm">unik per nomor</p>
                        </div>
                    </div>
                    <label class="inline-flex items-center gap-3 px-4 py-2 bg-gray-50 rounded-2xl cursor-pointer hover:bg-gray-100 transition-colors border border-gray-100">
                        <input type="checkbox" wire:click="toggleSelectAllPage" {{ $selectAllPage ? 'checked' : '' }}
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-700">Pilih semua di halaman ini</span>
                    </label>
                </div>
            </div>

            <!-- Table wrapper -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100/50">
                        <tr>
                            <th class="px-6 py-4 w-12"></th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user text-gray-400"></i>
                                    Nama
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fab fa-whatsapp text-green-500"></i>
                                    Nomor
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-chart-line text-gray-400"></i>
                                    Transaksi
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-clock text-gray-400"></i>
                                    Terakhir
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-50">
                        @foreach ($contacts as $c)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-purple-50/50 transition-all duration-200 group">
                            <td class="px-6 py-4">
                                <input type="checkbox" wire:model="selected" value="{{ $c->customer_phone }}"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-colors">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                        {{ substr($c->customer_name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $c->customer_name ?? '—' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fab fa-whatsapp text-green-500 text-sm"></i>
                                    <span class="font-mono text-gray-700 text-sm">{{ $c->customer_phone }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 group-hover:bg-blue-200 transition-colors">
                                    {{ $c->transaksi_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ \Carbon\Carbon::parse($c->last_trx)->format('d M Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 bg-gradient-to-r from-gray-50/50 to-transparent border-t border-gray-100">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>

    <style>
        /* Custom styles for enhanced visual effects */
        .backdrop-blur-sm {
            backdrop-filter: blur(10px);
        }
    </style>
</div>