<div>
    <div class="bg-white rounded-lg shadow mb-6">
        <!-- Header -->
        <div class="p-4 border-b flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h3 class="font-semibold text-gray-800 text-lg">Manajemen Karyawan</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola semua data karyawan</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <input wire:model.lazy="search" type="text" placeholder="Cari Nama..."
                    class="bg-gray-100 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-48">
                <button wire:click="resetForm"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Karyawan
                </button>
            </div>
        </div>

        <!-- Tabel Desktop -->
        <div class="hidden lg:block overflow-x-auto">
            @if(count($selectedKaryawan) > 0)
            <button wire:click="confirmBulkDelete"
                class="ml-6 mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i> Hapus Terpilih ({{ count($selectedKaryawan) }})
            </button>
            @endif

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" wire:model="selectAll" wire:click="toggleSelectAll" class="rounded">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qr Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $karyawan)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <input type="checkbox" wire:model="selectedKaryawan" wire:change="$refresh" :value="{{ $karyawan->id }}" class="rounded">
                        </td>
                        <td class="px-6 py-4">{{ $karyawan->name }}</td>
                        <td class="px-6 py-4">{{ $karyawan->email }}</td>
                        <td class="px-6 py-4">{{ $karyawan->phone }}</td>
                        <td class="px-6 py-4">{{ $karyawan->address }}</td>
                        <td class="border px-6 py-4">
                            @php
                            $qrPath = "qrcodes/karyawan_{$karyawan->id}.png";
                            @endphp
                            @if (file_exists(public_path($qrPath)))
                            <img src="{{ asset($qrPath) }}" alt="QR Code" class="w-16 h-16 object-cover">
                            @else
                            <span class="text-sm text-gray-500 italic">Belum ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button wire:click="edit({{ $karyawan->id }})" class="text-green-600 hover:text-green-900 p-1"><i class="fas fa-edit"></i></button>
                                <button wire:click="confirmDelete({{ $karyawan->id }})" class="text-red-600 hover:text-red-900 p-1"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $users ->links() }}
            </div>
        </div>

        <!-- Modal -->
        @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">{{ $editMode ? 'Edit Karyawan' : 'Tambah Karyawan' }}</h3>
                <form wire:submit.prevent="save">
                    <input wire:model.defer="name" type="text" placeholder="Nama" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <input wire:model.defer="email" type="email" placeholder="Email" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <input wire:model.defer="password" type="password" placeholder="Password" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <input wire:model.defer="phone" type="text" placeholder="Telepon" class="w-full mb-3 border px-3 py-2 rounded" />
                    @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    <textarea wire:model.defer="address" placeholder="Alamat" class="w-full mb-3 border px-3 py-2 rounded"></textarea>
                    @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

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
                    <button wire:click="deleteKaryawanConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
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

                <h2 class="text-lg font-bold mb-4 text-gray-800">Hapus Beberapa Karyawan</h2>
                <p class="mb-6 text-gray-600">Apakah kamu yakin ingin menghapus {{ count($selectedKaryawan) }} Karyawan terpilih?</p>
                <div class="flex justify-end space-x-3">
                    <button @click="showConfirmBulk = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button wire:click="deleteSelectedConfirmed" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>