<div class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                📢 Broadcast WhatsApp Pelanggan
            </h2>
            <p class="text-gray-600 text-sm sm:text-base mt-1">
                Ambil kontak dari transaksi & kirim pengumuman/promo via Fonnte
            </p>
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <input wire:model.defer="search" type="text" placeholder="Cari nama/nomor"
                class="w-full md:w-64 bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 shadow-sm" />
            <button wire:click="$refresh"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 active:scale-95 transition duration-150 shadow-sm text-sm">
                Cari
            </button>
        </div>
    </div>

    <!-- Alerts -->
    @if (session('success'))
    <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200 text-sm shadow-sm">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200 text-sm shadow-sm">
        {{ session('error') }}
    </div>
    @endif
    @error('selected')
    <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200 text-sm shadow-sm">{{ $message }}</div>
    @enderror
    @error('message')
    <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200 text-sm shadow-sm">{{ $message }}</div>
    @enderror

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Composer -->
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-md p-6 flex flex-col">
            <h3 class="font-semibold text-lg text-gray-900 mb-4 flex items-center gap-2">
                ✍️ Isi Pesan
            </h3>
            <textarea wire:model.defer="message" rows="8"
                class="w-full border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 resize-none shadow-sm"
                placeholder="Halo {nama}, ..."></textarea>
            <div class="text-xs text-gray-500 mt-2">
                Placeholder yang didukung:
                <code class="px-2 py-0.5 bg-gray-100 rounded text-xs font-mono">{nama}</code>
            </div>

            <!-- Info kontak -->
            <div class="flex items-center justify-between mt-4 text-sm text-gray-700">
                <div>Total kontak: <span class="font-semibold">{{ $totalContacts }}</span></div>
                <div>Terpilih: <span class="font-semibold">{{ $selectedCount }}</span></div>
            </div>

            <!-- Tombol aksi -->
            <div class="mt-5 flex flex-col sm:flex-row gap-2">
                <button wire:click="sendSelected" wire:loading.attr="disabled"
                    class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 active:scale-95 disabled:opacity-60 transition duration-200 shadow-sm">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Broadcast
                </button>
                <button wire:click="clearSelection"
                    class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-xl hover:bg-gray-200 active:scale-95 transition duration-150 shadow-sm">
                    Reset Pilihan
                </button>
            </div>

            <!-- Progress bar -->
            @if ($sending)
            <div class="mt-6">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500 ease-out"
                        :style="width: {{ $progress }}%">
                    </div>
                </div>
                <div class="text-xs text-gray-500 mt-1">Progress: {{ $progress }}%</div>
            </div>
            @endif
        </div>

        <!-- Tabel kontak -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-md p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-5 gap-3">
                <h3 class="font-semibold text-lg text-gray-900 flex items-center gap-2">
                    📇 Daftar Kontak (unik per nomor)
                </h3>
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:click="toggleSelectAllPage" {{ $selectAllPage ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="text-gray-700">Pilih semua di halaman ini</span>
                </label>
            </div>

            <!-- Table wrapper -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-medium">
                        <tr>
                            <th class="px-4 py-3 w-12"></th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Nomor</th>
                            <th class="px-4 py-3 text-left">Transaksi</th>
                            <th class="px-4 py-3 text-left">Terakhir</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($contacts as $c)
                        <tr class="hover:bg-blue-50/50 transition duration-150">
                            <td class="px-4 py-3">
                                <input type="checkbox" wire:model="selected" value="{{ $c->customer_phone }}"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </td>
                            <td class="px-4 py-3">{{ $c->customer_name ?? '—' }}</td>
                            <td class="px-4 py-3 font-mono text-gray-700">{{ $c->customer_phone }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $c->transaksi_count }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                {{ \Carbon\Carbon::parse($c->last_trx)->format('d M Y H:i') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-5">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</div>