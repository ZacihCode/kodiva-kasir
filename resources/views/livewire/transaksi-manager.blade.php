<div class="mt-8 fade-in">
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 border-b">
            <h3 class="text-lg font-bold text-gray-800">Riwayat Transaksi</h3>
            <input wire:model.debounce.300ms="search" type="text" placeholder="Cari metode..." class="border rounded px-3 py-2 w-full sm:w-64">
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Metode</th>
                        <th class="px-4 py-2">Subtotal</th>
                        <th class="px-4 py-2">Diskon</th>
                        <th class="px-4 py-2">Parkir</th>
                        <th class="px-4 py-2 font-bold">Total</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($transaksis as $trx)
                    <tr>
                        <td class="px-4 py-2">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-2">{{ ucfirst($trx->metode_pembayaran) }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($trx->subtotal) }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($trx->diskon) }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($trx->parkir) }}</td>
                        <td class="px-4 py-2 font-bold text-blue-600">Rp {{ number_format($trx->total) }}</td>
                        <td class="px-4 py-2 text-center">
                            <button wire:click="viewDetail({{ $trx->id }})" class="text-blue-600 hover:underline">Detail</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    @if($showDetail && $selectedTransaksi)
    <div class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6 relative">
            <h2 class="text-lg font-bold mb-2">Detail Transaksi</h2>
            <p class="text-sm text-gray-600 mb-4">Tanggal: {{ $selectedTransaksi->created_at->format('d M Y H:i') }}</p>

            <ul class="space-y-2 mb-4">
                @foreach($selectedTransaksi->detail as $item)
                <li class="flex justify-between">
                    <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                    <span>Rp {{ number_format($item['subtotal']) }}</span>
                </li>
                @endforeach
            </ul>

            <div class="border-t pt-2 text-right text-sm text-gray-700">
                <p>Subtotal: Rp {{ number_format($selectedTransaksi->subtotal) }}</p>
                <p>Diskon: Rp {{ number_format($selectedTransaksi->diskon) }}</p>
                <p>Parkir: Rp {{ number_format($selectedTransaksi->parkir) }}</p>
                <p class="font-bold text-blue-600 text-base">Total: Rp {{ number_format($selectedTransaksi->total) }}</p>
            </div>

            <button wire:click="closeDetail" class="absolute top-2 right-2 text-gray-400 hover:text-red-600 text-xl">&times;</button>
        </div>
    </div>
    @endif
</div>