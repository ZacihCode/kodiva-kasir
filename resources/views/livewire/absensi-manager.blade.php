<div>
    <!-- Absensi Page -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Karyawan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalKaryawan }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                    <span class="text-gray-600 text-xl">👥</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Hadir Hari Ini</p>
                    <p class="text-2xl font-bold text-green-600">{{ $hadirHariIni }} / {{ $totalKaryawan }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <span class="text-green-600 text-xl">✅</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Tidak Hadir</p>
                    <p class="text-2xl font-bold text-red-600">{{ $tidakHadirHariIni }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <span class="text-red-600 text-xl">❌</span>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow mb-6">
        <!-- Header -->
        <div class="p-4 border-b flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h3 class="font-semibold text-gray-800 text-lg">Manajemen Absensi</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola data absensi karyawan</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <input wire:model.lazy="search" type="text" placeholder="Cari Nama Karyawan..."
                    class="bg-gray-100 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-60">
                <button wire:click="resetForm"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Absensi
                </button>
            </div>
        </div>

        <!-- Tabel Desktop -->
        <div class="hidden lg:block overflow-x-auto">
            @if(count($selectedAbsensi) > 0)
            <button wire:click="confirmBulkDelete" class="ml-6 mb-4 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow hover:bg-red-700">
                <i class="fas fa-trash mr-1"></i> Hapus Terpilih ({{ count($selectedAbsensi) }})
            </button>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($absensis as $absen)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:model="selectedAbsensi" wire:change="$refresh" :value="{{ $absen->id }}" />
                        </td>
                        <td class="px-6 py-4">{{ $absen->user->name }}</td>
                        <td class="px-6 py-4">{{ $absen->user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $absen->status === 'hadir' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($absen->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $absen->keterangan }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y H:i:s') }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="edit({{ $absen->id }})" class="text-green-600 hover:text-green-900 p-1"><i class="fas fa-edit"></i></button>
                            <button wire:click="confirmDelete({{ $absen->id }})" class="text-red-600 hover:text-red-900 p-1"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $absensis->links() }}
            </div>
        </div>

        <!-- Mobile/Tablet Card Layout -->
        <div class="lg:hidden p-4">
            <!-- Tombol Delete untuk Mobile -->
            @if(count($selectedAbsensi) > 0)
            <div class="lg:hidden p-4">
                <button wire:click="confirmBulkDelete"
                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-1"></i> Hapus Terpilih ({{ count($selectedAbsensi) }})
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
                @foreach ($absensis as $absen)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Nama</div>
                            <span class="text-sm font-medium text-blue-600">{{ $absen->user->name }}</span>
                        </div>
                        <input type="checkbox" wire:model="selectedAbsensi" wire:change="$refresh" :value="{{ $absen->id }}" />
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Email</div>
                            <div class="flex items-center mt-1">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-900">{{ $absen->user->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Status</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">{{ $absen->status }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Keterangan</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">{{ $absen->keterangan }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wider">Tanggal Dibuat</div>
                            <div class="text-sm font-medium text-gray-900 mt-1">{{ $absen->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <button wire:click="edit('{{ $absen->id }}')" class="text-green-600 hover:text-green-900 text-sm flex items-center">
                                <i class="fas fa-edit mr-1"></i><span>Edit</span>
                            </button>
                            <button wire:click="confirmDelete('{{ $absen->id }}')" class="text-red-600 hover:text-red-900 text-sm flex items-center">
                                <i class="fas fa-trash mr-1"></i><span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $absensis->links() }}
            </div>
        </div>

        <!-- Modal -->
        @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">{{ $editMode ? 'Edit Absensi' : 'Tambah Absensi' }}</h3>
                <form wire:submit.prevent="save">
                    <select wire:model="user_id" class="w-full mb-3 border px-3 py-2 rounded">
                        <option value="">Pilih Karyawan</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('user_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <input wire:model="tanggal" type="datetime-local" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('tanggal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <select wire:model="status" class="w-full mb-3 border px-3 py-2 rounded">
                        <option value="hadir">Hadir</option>
                        <option value="tidak hadir">Tidak Hadir</option>
                    </select>
                    @error('status') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <textarea wire:model="keterangan" placeholder="Keterangan"
                        class="w-full mb-3 border px-3 py-2 rounded"></textarea>
                    @error('keterangan') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <div class="flex justify-end space-x-2">
                        <button wire:click="$set('showModal', false)" type="button" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
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
                    <button wire:click="deleteConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
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

                <h2 class="text-lg font-bold mb-4 text-gray-800">Hapus Beberapa Absensi</h2>
                <p class="mb-6 text-gray-600">Apakah kamu yakin ingin menghapus {{ count($selectedAbsensi) }} Absensi terpilih?</p>
                <div class="flex justify-end space-x-3">
                    <button @click="showConfirmBulk = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button wire:click="deleteSelectedConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>