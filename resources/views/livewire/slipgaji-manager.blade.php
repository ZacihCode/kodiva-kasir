<div>
    <!-- Form Tambah Karyawan -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Tambah Slip Gaji</h2>
        <form wire:submit.prevent="addSlip" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input wire:model.defer="nama_karyawan" type="text" placeholder="Nama Karyawan" class="border px-3 py-2 rounded" required>
            <input wire:model.defer="posisi" type="text" placeholder="Posisi" class="border px-3 py-2 rounded" required>
            <input wire:model.defer="gaji_pokok" type="number" placeholder="Gaji Pokok" class="border px-3 py-2 rounded" required>
            <input wire:model.defer="tunjangan" type="number" placeholder="Tunjangan" class="border px-3 py-2 rounded">
            <input wire:model.defer="potongan" type="number" placeholder="Potongan" class="border px-3 py-2 rounded">
            <input wire:model.defer="no_wa" type="text" placeholder="Nomor WhatsApp" class="border px-3 py-2 rounded" required>
            <div class="col-span-1 md:col-span-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan Slip</button>
            </div>
        </form>
    </div>

    <!-- Tabel Slip Gaji -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Daftar Slip Gaji</h2>
        <table class="min-w-full table-auto text-sm">
            <thead class="text-left text-gray-600 border-b">
                <tr>
                    <th class="pb-3 font-medium">Nama Karyawan</th>
                    <th class="pb-3 font-medium">Posisi</th>
                    <th class="pb-3 font-medium">Gaji Pokok</th>
                    <th class="pb-3 font-medium">Tunjangan</th>
                    <th class="pb-3 font-medium">Potongan</th>
                    <th class="pb-3 font-medium">Total Gaji</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($slips as $slip)
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="py-3 text-gray-800">{{ $slip->nama_karyawan }}</td>
                    <td class="py-3 text-gray-800">{{ $slip->posisi }}</td>
                    <td class="py-3 text-gray-800">Rp {{ number_format($slip->gaji_pokok) }}</td>
                    <td class="py-3 text-gray-800">Rp {{ number_format($slip->tunjangan) }}</td>
                    <td class="py-3 text-gray-800">Rp {{ number_format($slip->potongan) }}</td>
                    <td class="py-3 text-gray-800 font-bold">Rp {{ number_format($slip->total_gaji) }}</td>
                    <td class="py-3">
                        <span class="px-2 py-1 rounded-full text-sm {{ $slip->status === 'Terkirim' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $slip->status }}
                        </span>
                    </td>
                    <td class="py-3 space-x-2">
                        <button wire:click="sendWa({{ $slip->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition">
                            📱 Kirim WA
                        </button>
                        <button onclick="window.print()"
                            class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600 transition">
                            🖨️ Cetak
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-4">Belum ada data slip gaji.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $slips->links() }}
        </div>
    </div>
</div>