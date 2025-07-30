<div>
    <div class="bg-white rounded-lg shadow mb-6">
        <!-- Header -->
        <div class="p-4 border-b flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div>
                <h3 class="font-semibold text-gray-800 text-lg">Diskon Management</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola semua jenis diskon</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <input wire:model.lazy="search" type="text" placeholder="Cari Diskon..."
                    class="bg-gray-100 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-48">
                <button wire:click="resetForm"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Diskon
                </button>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Diskon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Persentase</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($diskons as $diskon)
                    <tr>
                        <td class="px-6 py-4">{{ $diskon->jenis_diskon }}</td>
                        <td class="px-6 py-4">{{ $diskon->deskripsi }}</td>
                        <td class="px-6 py-4">{{ $diskon->persentase }}%</td>
                        <td class="px-6 py-4 flex space-x-2">
                            <button wire:click="edit({{ $diskon->id }})" class="text-green-600 hover:text-green-800"><i class="fas fa-edit"></i></button>
                            <button wire:click="confirmDelete({{ $diskon->id }})" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $diskons->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">{{ $editMode ? 'Edit Diskon' : 'Tambah Diskon' }}</h3>
            <form wire:submit.prevent="save">
                <input wire:model="jenis_diskon" type="text" placeholder="Jenis Diskon" class="w-full mb-3 border px-3 py-2 rounded" />
                @error('jenis_diskon') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                <input wire:model="deskripsi" type="text" placeholder="Deskripsi" class="w-full mb-3 border px-3 py-2 rounded" />
                @error('deskripsi') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                <input wire:model="persentase" type="number" placeholder="Persentase (%)" class="w-full mb-3 border px-3 py-2 rounded" />
                @error('persentase') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                <div class="flex justify-end space-x-2">
                    <button wire:click="$set('showModal', false)" type="button" class="bg-gray-300 px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>