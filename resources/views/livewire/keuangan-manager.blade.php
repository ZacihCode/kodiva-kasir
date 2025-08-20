<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 fade-in">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Manajemen Keuangan</h2>
            <p class="text-gray-600 mt-2">Pencatatan pemasukan dan pengeluaran</p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
            <input type="date" wire:model.lazy="tanggalFilter"
                class="w-full sm:w-auto border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button wire:click="$set('tanggalFilter', null)"
                class="w-full sm:w-auto bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Reset Filter
            </button>
        </div>
    </div>
    <!-- Financial Summary Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pemasukan Hari Ini</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
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
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
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
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($labaBersih, 0, ',', '.') }}</p>
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
                    <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($totalKeuangan, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <span class="text-purple-600 text-xl">🏦</span>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow mb-6 mt-4">
        <!-- Header -->
        <div class="p-4 border-b flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h3 class="font-semibold text-gray-800 text-lg">Manajemen Keuangan</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola data pemasukan dan pengeluaran</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <input wire:model.lazy="search" type="text" placeholder="Cari kategori..."
                    class="bg-gray-100 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-48">
                <button wire:click="resetForm"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Data
                </button>
            </div>
        </div>

        <!-- Tabel Desktop -->
        <div class="hidden lg:block overflow-x-auto">
            @if(count($selectedKeuangan) > 0)
            <button wire:click="confirmBulkDelete"
                class="ml-6 mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i> Hapus Terpilih ({{ count($selectedKeuangan) }})
            </button>
            @endif

            <table class="min-w-full divide-y divide-gray-200 mt-4">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll" class="rounded">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($keuangans as $data)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:model="selectedKeuangan" wire:change="$refresh" :value="{{ $data->id }}" class="rounded">
                        </td>
                        <td class="px-6 py-4 capitalize">{{ $data->jenis_keuangan }}</td>
                        <td class="px-6 py-4">{{ $data->kategori }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($data->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $data->keterangan }}</td>
                        <td class="px-6 py-4">{{ $data->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button wire:click="edit({{ $data->id }})" class="text-green-600 hover:text-green-900"><i class="fas fa-edit"></i></button>
                                <button wire:click="confirmDelete({{ $data->id }})" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 px-4">
                {{ $keuangans->links() }}
            </div>
        </div>

        <!-- Mobile/Tablet Card Layout -->
        <div class="lg:hidden p-4">
            <!-- Tombol Delete untuk Mobile -->
            @if(count($selectedKeuangan) > 0)
            <div class="lg:hidden p-4">
                <button wire:click="confirmBulkDelete"
                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-1"></i> Hapus Terpilih ({{ count($selectedKeuangan) }})
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
                @foreach ($keuangans as $data)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Jenis</div>
                            <span class="text-sm font-medium text-blue-600">{{ $data->jenis_keuangan }}</span>
                        </div>
                        <input type="checkbox" wire:model="selectedKeuangan" wire:change="$refresh" :value="{{ $data->id }}" />
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Kategori</div>
                            <div class="flex items-center mt-1">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-900">{{ $data->kategori }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Jumlah</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">Rp {{ number_format($data->jumlah, 0, ',', '.') }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Keterangan</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">{{ $data->keterangan }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Tanggal Dibuat</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">{{ $data->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <button wire:click="edit('{{ $data->id }}')" class="text-green-600 hover:text-green-900 text-sm flex items-center">
                                <i class="fas fa-edit mr-1"></i><span>Edit</span>
                            </button>
                            <button wire:click="confirmDelete('{{ $data->id }}')" class="text-red-600 hover:text-red-900 text-sm flex items-center">
                                <i class="fas fa-trash mr-1"></i><span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $keuangans->links() }}
            </div>
        </div>

        <!-- Modal Form -->
        @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">{{ $editMode ? 'Edit Data Keuangan' : 'Tambah Data Keuangan' }}</h3>
                <form wire:submit.prevent="save">
                    <select wire:model="jenis_keuangan" class="w-full mb-3 border px-3 py-2 rounded">
                        <option value="">Pilih Jenis</option>
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>
                    @error('jenis_keuangan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <input wire:model="kategori" type="text" placeholder="Kategori" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('kategori') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <input wire:model="jumlah" type="number" placeholder="Jumlah" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('jumlah') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <textarea wire:model="keterangan" placeholder="Keterangan (opsional)" class="w-full mb-3 border px-3 py-2 rounded"></textarea>
                    @error('keterangan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <div class="flex justify-end space-x-2">
                        <button wire:click="$set('showModal', false)" type="button" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Konfirmasi Hapus -->
        <div x-data="{ showConfirm: @entangle('confirmingDelete') }" x-show="showConfirm" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="showConfirm = false" class="bg-white p-6 rounded-lg w-full max-w-sm">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Konfirmasi Hapus</h2>
                <p class="mb-6 text-gray-600">Yakin ingin menghapus data ini?</p>
                <div class="flex justify-end space-x-3">
                    <button @click="showConfirm = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button wire:click="deleteKeuanganConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                </div>
            </div>
        </div>

        <!-- Konfirmasi Hapus Massal -->
        <div x-data="{ showConfirmBulk: @entangle('confirmingBulkDelete') }" x-show="showConfirmBulk" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="showConfirmBulk = false" class="bg-white p-6 rounded-lg w-full max-w-sm">
                <h2 class="text-lg font-bold mb-4 text-gray-800">Hapus Beberapa Data</h2>
                <p class="mb-6 text-gray-600">Yakin ingin menghapus {{ count($selectedKeuangan) }} data terpilih?</p>
                <div class="flex justify-end space-x-3">
                    <button @click="showConfirmBulk = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button wire:click="deleteSelectedConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>