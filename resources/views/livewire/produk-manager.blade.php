<div>
    <div class="bg-white rounded-lg shadow mb-6">
        <!-- Header -->
        <div class="p-4 border-b flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h3 class="font-semibold text-gray-800 text-lg">Produk Management</h3>
                <p class="text-sm text-gray-500 mt-1">Manage all Produk</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="relative">
                    <input wire:model.lazy="search" type="text" placeholder="Search Produk..."
                        class="bg-gray-100 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-48">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
                </div>
                <button wire:click="resetForm" x-data @click="$dispatch('open-modal')"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    <span class="hidden sm:inline">New Produk</span>
                    <span class="sm:hidden">Add</span>
                </button>
            </div>
        </div>

        <!-- Table Desktop -->
        <div class="hidden lg:block overflow-x-auto">
            @if(count($selectedProduk) > 0)
            <button wire:click="confirmBulkDelete"
                class="group relative inline-flex items-center gap-2 px-4 py-2 mb-4 ml-6
                bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 
                text-white font-medium text-sm
                rounded-lg shadow-md hover:shadow-lg 
                transform hover:scale-[1.02] active:scale-95
                transition-all duration-150 ease-in-out
                border border-red-400/20 hover:border-red-300/30
                focus:outline-none focus:ring-2 focus:ring-red-500/30">

                <!-- Icon -->
                <svg class="w-4 h-4 group-hover:rotate-6 transition-transform duration-150"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>

                <!-- Text -->
                <span class="relative flex items-center">
                    Delete Selected
                    <span class="inline-flex items-center justify-center w-5 h-5 ml-1.5 
                    bg-red-700/60 rounded-full text-xs font-semibold
                    group-hover:bg-red-800/70 transition-colors duration-150">
                        {{ count($selectedProduk) }}
                    </span>
                </span>

                <!-- Subtle hover glow -->
                <div class="absolute inset-0 rounded-lg bg-white/5 opacity-0 group-hover:opacity-100 
                transition-opacity duration-150 pointer-events-none"></div>
            </button>
            @endif
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($produks as $produk)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:model="selectedProduk" wire:change="$refresh" :value="{{ $produk->id }}" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-900 font-medium">{{ $produk->nama_produk }}</span>
                                    <div class="text-xs text-gray-500">{{ $produk->deskripsi }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $produk->kategori }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp{{ $produk->harga }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($produk->created_at)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <button wire:click="edit({{ $produk->id }})" class="text-green-600 hover:text-green-900 p-1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="confirmDelete('{{ $produk->id }}')" class="text-red-600 hover:text-red-900 p-1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $produks->links() }}
            </div>
        </div>
        <!-- Mobile/Tablet Card Layout -->
        <div class="lg:hidden p-4">
            <!-- Tombol Delete untuk Mobile -->
            @if(count($selectedProduk) > 0)
            <div class="lg:hidden p-4">
                <button wire:click="confirmBulkDelete"
                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-1"></i> Hapus Terpilih ({{ count($selectedProduk) }})
                </button>
            </div>
            @endif
            <div class="lg:hidden px-4 mb-2">
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll" class="rounded border-gray-300">
                    <span class="text-sm text-gray-700">Pilih Semua</span>
                </label>
            </div>
            <div class="space-y-4">
                @foreach ($produks as $produk)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Nama Produk</div>
                            <span class="text-sm font-medium text-blue-600">{{ $produk->nama_produk }}</span>
                        </div>
                        <input type="checkbox" wire:model="selectedProduk" wire:change="$refresh" :value="{{ $produk->id }}" />
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Kategori</div>
                            <div class="flex items-center mt-1">
                                <!-- <i class="fas fa-tshirt text-blue-600 mr-2 text-sm"></i> -->
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-900">{{ $produk->kategori }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Harga</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">{{ $produk->harga }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Tanggal Dibuat</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">{{ \Carbon\Carbon::parse($produk->created_at)->format('d M Y') }} Jam</div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <button wire:click="edit('{{ $produk->id }}')" class="text-green-600 hover:text-green-900 text-sm flex items-center">
                                <i class="fas fa-edit mr-1"></i><span>Edit</span>
                            </button>
                            <button wire:click="confirmDelete('{{ $produk->id }}')" class="text-red-600 hover:text-red-900 text-sm flex items-center">
                                <i class="fas fa-trash mr-1"></i><span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $produks->links() }}
            </div>
        </div>
        <!-- Modal -->
        @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div @click.away="show = false" class="bg-white p-6 rounded-lg w-full max-w-md">
                <h3 class="text-lg font-bold mb-4" x-text="!@js($editMode) ? 'Tambah Produk' : 'Edit Produk'"></h3>
                <form wire:submit.prevent="save">
                    <input wire:model="nama_produk" type="text" placeholder="Nama Produk" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('nama_produk') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    <input wire:model="kategori" type="text" placeholder="Kategori" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('kategori') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    <input wire:model="deskripsi" type="text" placeholder="Deskripsi" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    <input wire:model="harga" type="number" placeholder="Harga" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('harga') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    <div class="flex justify-end space-x-2">
                        <button wire:click="$set('showModal', false)" type="button" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        <!-- Modal -->
        <div x-data="{ showConfirm: @entangle('confirmingDelete') }" x-show="showConfirm" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div @click.away="showConfirm = false"
                class="bg-white p-6 rounded-lg shadow-xl w-full max-w-sm transform"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <h2 class="text-lg font-bold mb-4 text-gray-800">Konfirmasi Hapus</h2>
                <p class="mb-6 text-gray-600">Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-end space-x-3">
                    <button @click="showConfirm = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button wire:click="deleteUserConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                </div>
            </div>
        </div>
        <!-- Bulk Delete Confirmation Modal -->
        <div x-data="{ showConfirmBulk: @entangle('confirmingBulkDelete') }" x-show="showConfirmBulk" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div @click.away="showConfirmBulk = false"
                class="bg-white p-6 rounded-lg shadow-xl w-full max-w-sm transform"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                <h2 class="text-lg font-bold mb-4 text-gray-800">Hapus Beberapa Layanan</h2>
                <p class="mb-6 text-gray-600">Apakah kamu yakin ingin menghapus {{ count($selectedProduk) }} Layanan terpilih?</p>
                <div class="flex justify-end space-x-3">
                    <button @click="showConfirmBulk = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button wire:click="deleteSelectedConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>