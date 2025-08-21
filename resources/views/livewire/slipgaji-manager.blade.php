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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor WA</th>
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
                            <td class="px-6 py-4">{{ $slip->no_wa }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm {{ $slip->status === 'Terkirim' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $slip->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if (strtolower($slip->status) === 'terkirim')
                                <button class="text-gray-400 cursor-not-allowed mr-3" title="Sudah terkirim" disabled>
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                                @else
                                <button wire:click="sendSlip({{ $slip->id }})" class="text-blue-600 hover:text-blue-900 mr-3" title="Kirim via WhatsApp">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                                @endif

                                <button wire:click="edit({{ $slip->id }})" class="text-green-600 hover:text-green-900 mr-2"><i class="fas fa-edit"></i></button>
                                <button wire:click="confirmDelete({{ $slip->id }})" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">{{ $slipGajis->links() }}</div>
            </div>

            <!-- Mobile/Tablet Card Layout -->
            <div class="lg:hidden p-4">
                <!-- Tombol Delete untuk Mobile -->
                @if(count($selectedSlip) > 0)
                <div class="lg:hidden p-4">
                    <button wire:click="confirmBulkDelete"
                        class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-1"></i> Hapus Terpilih ({{ count($selectedSlip) }})
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
                    @foreach ($slipGajis as $slip)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Nama</div>
                                <span class="text-sm font-medium text-blue-600">{{ $slip->nama_karyawan }}</span>
                            </div>
                            <input type="checkbox" wire:model="selectedSlip" wire:change="$refresh" :value="{{ $slip->id }}" />
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Gaji Pokok</div>
                                <div class="flex items-center mt-1">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-gray-900">Rp{{ number_format($slip->gaji_pokok, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Tunjangan</div>
                                <div class="text-sm font-medium text-gray-900 mt-1">Rp{{ number_format($slip->tunjangan, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Potongan</div>
                                <div class="text-sm font-medium text-gray-900 mt-1">Rp{{ number_format($slip->potongan, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Total</div>
                                <div class="text-sm font-medium text-gray-900 mt-1">Rp{{ number_format($slip->total_gaji, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Nomor Wa</div>
                                <div class="text-sm font-medium text-gray-900 mt-1">{{ $slip->no_wa }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Status</div>
                                <div class="text-sm font-medium text-gray-900 mt-1 {{ $slip->status === 'Terkirim' ? 'text-green-600' : 'text-yellow-600' }}">{{ $slip->status }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Tanggal</div>
                                <div class="text-sm font-medium text-gray-900 mt-1">{{ \Carbon\Carbon::parse($slip->tanggal)->format('d M Y H:i:s') }}</div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <div class="flex space-x-3">
                                @if (strtolower($slip->status) === 'terkirim')
                                <button class="text-gray-400 cursor-not-allowed text-sm flex items-center" disabled title="Sudah terkirim">
                                    <i class="fas fa-paper-plane mr-1"></i><span>Kirim</span>
                                </button>
                                @else
                                <button wire:click="sendSlip('{{ $slip->id }}')" class="text-blue-600 hover:text-blue-900 text-sm flex items-center">
                                    <i class="fas fa-paper-plane mr-1"></i><span>Kirim</span>
                                </button>
                                @endif

                                <button wire:click="edit('{{ $slip->id }}')" class="text-green-600 hover:text-green-900 text-sm flex items-center">
                                    <i class="fas fa-edit mr-1"></i><span>Edit</span>
                                </button>
                                <button wire:click="confirmDelete('{{ $slip->id }}')" class="text-red-600 hover:text-red-900 text-sm flex items-center">
                                    <i class="fas fa-trash mr-1"></i><span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $slipGajis->links() }}
                </div>
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