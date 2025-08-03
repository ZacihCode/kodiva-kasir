<div>
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4 fade-in">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Slip Gaji Karyawan</h2>
            <p class="text-gray-600 mt-2">Manajemen penggajian dan pengiriman slip gaji otomatis</p>
        </div>
        <div class="flex items-center space-x-4">
            <input type="date"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Filter
            </button>
        </div>
    </div>
    <!-- Slip Gaji Page -->
    <div class="grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Payroll Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Gaji</p>
                        <p class="text-2xl font-bold text-blue-600">Rp{{ number_format($totalGaji, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 text-xl">💰</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Slip Terkirim</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $slipTerkirim }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-purple-600 text-xl">📤</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Pending</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $slipBelumTerkirim }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-orange-600 text-xl">⏳</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow mb-6">
            <!-- Header -->
            <div class="p-4 border-b flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h3 class="font-semibold text-gray-800 text-lg">Slip Gaji</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola slip gaji karyawan berdasarkan kehadiran</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input wire:model.lazy="search" type="text" placeholder="Cari nama karyawan"
                        class="bg-gray-100 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-48">
                    <button wire:click="resetForm"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Slip
                    </button>
                </div>
            </div>

            <!-- Tabel Desktop -->
            <div class="hidden lg:block overflow-x-auto">
                @if(count($selectedSlip) > 0)
                <button wire:click="confirmBulkDelete"
                    class="ml-6 mb-4 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 flex items-center gap-2">
                    <i class="fas fa-trash"></i> Hapus Terpilih ({{ count($selectedSlip) }})
                </button>
                @endif

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll" />
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gaji Pokok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tunjangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Potongan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($slipGajis as $slip)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4"><input type="checkbox" wire:change="$refresh" wire:model="selectedSlip" value="{{ $slip->id }}" /></td>
                            <td class="px-6 py-4">{{ $slip->nama_karyawan }}</td>
                            <td class="px-6 py-4">Rp{{ number_format($slip->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp{{ number_format($slip->tunjangan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp{{ number_format($slip->potongan, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp{{ number_format($slip->total_gaji, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm {{ $slip->status === 'Terkirim' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $slip->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="edit({{ $slip->id }})" class="text-green-600 hover:text-green-900 mr-2"><i class="fas fa-edit"></i></button>
                                <button wire:click="confirmDelete({{ $slip->id }})" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">{{ $slipGajis->links() }}</div>
            </div>

            <!-- Modal Tambah/Edit -->
            @if($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg w-full max-w-md">
                    <h3 class="text-lg font-bold mb-4">{{ $editMode ? 'Edit Slip Gaji' : 'Tambah Slip Gaji' }}</h3>
                    <form wire:submit.prevent="save">
                        <input wire:model="nama_karyawan" type="text" placeholder="Nama Karyawan" class="w-full mb-3 border px-3 py-2 rounded" />
                        @error('nama_karyawan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        <input wire:model="gaji_pokok" type="number" placeholder="Gaji Pokok" class="w-full mb-3 border px-3 py-2 rounded" />
                        <input wire:model="tunjangan" type="number" placeholder="Tunjangan" class="w-full mb-3 border px-3 py-2 rounded" />
                        <input wire:model="potongan" type="number" placeholder="Potongan" class="w-full mb-3 border px-3 py-2 rounded" />
                        <input wire:model="no_wa" type="text" placeholder="Nomor WhatsApp" class="w-full mb-3 border px-3 py-2 rounded" />

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
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity">
                <div @click.away="showConfirm = false" class="bg-white p-6 rounded-lg shadow-xl w-full max-w-sm">
                    <h2 class="text-lg font-bold mb-4 text-gray-800">Konfirmasi Hapus</h2>
                    <p class="mb-6 text-gray-600">Yakin ingin menghapus slip gaji ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="flex justify-end space-x-3">
                        <button @click="showConfirm = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button wire:click="deleteSlipConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>