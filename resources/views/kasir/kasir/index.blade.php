<!DOCTYPE html>
<html lang="en" x-data="cashierSystem()" x-init="init()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Tiket - AquaTix</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    @extends('layouts.app')
    @section('content')
    <div class="ml-0 md:ml-64 lg:ml-72 min-h-screen bg-gray-50 p-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4 fade-in">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Menu Kasir</h2>
                    <p class="text-gray-600 mt-2">Selamat datang di sistem kasir tiket renang</p>
                </div>
            </div>

            <!-- Kasir Tiket Page -->
            <div class="flex flex-col lg:flex-row gap-6 mb-8">
                <!-- Ticket Selection -->
                <div class="w-full lg:w-2/3 bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Pilih Tiket</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="ticket in ticketTypes" :key="ticket.id">
                            <div class="border p-4 rounded-xl">
                                <div class="font-semibold mb-1" x-text="ticket.name"></div>
                                <div class="text-sm text-gray-500 mb-2" x-text="ticket.description"></div>
                                <div class="text-blue-600 font-bold mb-2" x-text="'Rp ' + ticket.price.toLocaleString()"></div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <button class="w-8 h-8 bg-red-500 text-white rounded" @click="decreaseFromCart(ticket)">-</button>
                                        <span class="text-lg font-semibold" x-text="getQuantity(ticket)">0</span>
                                        <button class="w-8 h-8 bg-green-500 text-white rounded" @click="addToCart(ticket)">+</button>
                                    </div>
                                    <div class="text-right font-medium text-gray-600" x-text="'Subtotal: Rp ' + (ticket.price * getQuantity(ticket)).toLocaleString()"></div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Dropdown Diskon dan Parkir -->
                    <div class="mt-6">
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Pilih Diskon</label>
                            <select x-model.number="selectedDiscount" class="w-full p-2 border rounded-md">
                                <option value="0">Tanpa Diskon</option>
                                <template x-for="diskon in discountOptions" :key="diskon.id">
                                    <option :value="diskon.percentage" x-text="diskon.name + ' - ' + diskon.percentage + '%' "></option>
                                </template>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Pilih Jenis Parkir</label>
                            <select x-model.number="selectedParking" class="w-full p-2 border rounded-md">
                                <option value="0">Tanpa Parkir</option>
                                <template x-for="park in parkingOptions" :key="park.id">
                                    <option :value="park.fee" x-text="park.name + ' - Rp ' + park.fee.toLocaleString()"></option>
                                </template>
                            </select>
                            <!-- Input Plat Nomor -->
                            <div class="mt-3" x-show="selectedParking > 0" x-transition>
                                <label class="block font-medium mb-1">Plat Nomor Kendaraan</label>
                                <input type="text" x-model="platNomor" class="w-full p-2 border rounded-md" placeholder="Masukkan plat nomor...">
                            </div>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Metode Pembayaran</label>
                            <select x-model="paymentMethod" class="w-full p-2 border rounded-md">
                                <option value="cash">Tunai</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Cart & Payment -->
                <div class="w-full lg:w-1/3 bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Keranjang</h3>
                    <div class="space-y-3 mb-6 min-h-[200px]">
                        <template x-if="cart.length === 0">
                            <div class="text-center text-gray-500 mt-8">
                                <div class="text-4xl mb-2">🛒</div>
                                <p>Keranjang kosong</p>
                            </div>
                        </template>
                        <template x-for="item in cart" :key="item.ticket.id">
                            <div class="flex justify-between bg-gray-50 p-2 rounded-lg">
                                <span x-text="item.ticket.name + ' x' + item.quantity"></span>
                                <span x-text="'Rp ' + (item.ticket.price * item.quantity).toLocaleString()"></span>
                            </div>
                        </template>
                        <template x-if="selectedParking > 0 && platNomor">
                            <div class="flex justify-between mb-2">
                                <span>Plat Nomor:</span>
                                <span x-text="platNomor"></span>
                            </div>
                        </template>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal:</span>
                            <span x-text="'Rp ' + subtotal.toLocaleString()"></span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Diskon:</span>
                            <span x-text="'- Rp ' + discountAmount.toLocaleString()"></span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Parkir:</span>
                            <span x-text="'Rp ' + selectedParking.toLocaleString()"></span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-bold text-gray-800">Total:</span>
                            <span class="font-bold text-xl text-blue-600" x-text="'Rp ' + totalAll.toLocaleString()">Rp 0</span>
                        </div>
                        <button
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="cart.length === 0"
                            @click="paymentMethod === 'qris' ? showQrisModal = true : (saveTransaction(), showReceipt = true)">
                            Proses Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal QRIS -->
    <div x-show="showQrisModal" x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" x-transition>
        <div class="bg-white w-[350px] p-6 rounded-xl shadow-xl" @click.outside="showQrisModal = false">
            <h2 class="text-center text-lg font-bold mb-4">Pembayaran QRIS</h2>
            <p class="text-center text-sm text-gray-600 mb-4">Silakan scan barcode di bawah ini untuk melakukan pembayaran.</p>
            <img src="" alt="QRIS" class="w-48 h-48 object-cover mx-auto border p-2 bg-white rounded-md mb-4">
            <button class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700" @click="showQrisModal = false; saveTransaction(); showReceipt = true">
                Sudah Bayar
            </button>
        </div>
    </div>


    <!-- Modal struk -->
    <div x-show="showReceipt" x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center" x-transition>
        <div class="bg-white w-[350px] p-6 rounded-xl shadow-xl" @click.outside="showReceipt = false">
            <h2 class="text-center text-lg font-bold">Struk Pembayaran</h2>
            <h2 class="text-center text-lg font-bold mb-4">Wisata Sendang Plesungan</h2>
            <div class="text-sm text-gray-700">
                <p>Tanggal: <span x-text="new Date().toLocaleString()"></span></p>
                <p>Metode: <span x-text="paymentMethod === 'qris' ? 'QRIS' : 'Tunai'"></span></p>
                <template x-if="selectedParking > 0 && platNomor">
                    <p>Plat Nomor: <span x-text="platNomor"></span></p>
                </template>
                <hr class="my-2">

                <!-- Daftar tiket -->
                <template x-for="item in cart" :key="item.ticket.id">
                    <div class="flex justify-between">
                        <span x-text="item.ticket.name + ' x' + item.quantity"></span>
                        <span x-text="'Rp ' + (item.ticket.price * item.quantity).toLocaleString()"></span>
                    </div>
                </template>

                <!-- Diskon -->
                <div class="flex justify-between mt-2">
                    <span>Diskon</span>
                    <span x-text="'- Rp ' + discountAmount.toLocaleString()"></span>
                </div>

                <!-- Parkir -->
                <div class="flex justify-between">
                    <span>Parkir</span>
                    <span x-text="'Rp ' + selectedParking.toLocaleString()"></span>
                </div>

                <hr class="my-2">

                <!-- Total -->
                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span x-text="'Rp ' + totalAll.toLocaleString()"></span>
                </div>
            </div>

            <!-- Tombol cetak -->
            <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700" @click="printReceipt()">
                Cetak Struk
            </button>
        </div>
    </div>
    @endsection
    <script>
        function cashierSystem() {
            return {
                cart: [],
                showReceipt: false,
                showQrisModal: false,
                selectedDiscount: 0,
                selectedParking: 0,
                paymentMethod: 'cash',
                discountOptions: [],
                parkingOptions: [],
                ticketTypes: [],
                platNomor: '',

                async init() {
                    try {
                        const [ticketsRes, discountsRes, parkingsRes] = await Promise.all([
                            fetch(`/api/tickets`, {
                                credentials: 'include'
                            }),
                            fetch(`/api/discounts`, {
                                credentials: 'include'
                            }),
                            fetch(`/api/parkings`, {
                                credentials: 'include'
                            }),
                        ]);

                        const rawTickets = await ticketsRes.json();
                        const rawDiscounts = await discountsRes.json();
                        const rawParkings = await parkingsRes.json();

                        this.ticketTypes = rawTickets.map(item => ({
                            id: item.id,
                            name: item.nama_produk || item.name || 'Tidak ada nama',
                            description: item.deskripsi || item.description || '',
                            price: Number(item.harga || item.price || 0),
                        }));

                        this.discountOptions = rawDiscounts.map(item => ({
                            id: item.id,
                            name: item.jenis_diskon,
                            percentage: item.persentase,
                        }));

                        this.parkingOptions = rawParkings.map(item => ({
                            id: item.id,
                            name: item.jenis_parkir,
                            fee: Number(item.harga),
                        }));
                    } catch (error) {
                        console.error("Gagal fetch data:", error);
                    }
                },

                async saveTransaction() {
                    try {
                        const res = await fetch(`/api/transaksi`, {
                            method: 'POST',
                            credentials: 'include',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest', // penting
                            },
                            body: JSON.stringify({
                                metode_pembayaran: this.paymentMethod,
                                subtotal: this.subtotal,
                                diskon: this.discountAmount,
                                parkir: this.selectedParking,
                                total: this.totalAll,
                                plat_nomor: this.platNomor,
                                detail: this.cart.map(item => ({
                                    name: item.ticket.name,
                                    quantity: item.quantity,
                                    price: item.ticket.price,
                                    subtotal: item.ticket.price * item.quantity
                                })),
                            })
                        });

                        const result = await res.json();
                        console.log("Transaksi berhasil:", result);
                    } catch (error) {
                        console.error("Gagal simpan transaksi:", error);
                    }
                },

                addToCart(ticket) {
                    const index = this.cart.findIndex(i => i.ticket.id === ticket.id);
                    if (index !== -1) {
                        this.cart[index].quantity++;
                    } else {
                        this.cart.push({
                            ticket,
                            quantity: 1
                        });
                    }
                },

                decreaseFromCart(ticket) {
                    const index = this.cart.findIndex(i => i.ticket.id === ticket.id);
                    if (index !== -1) {
                        if (this.cart[index].quantity > 1) {
                            this.cart[index].quantity--;
                        } else {
                            this.cart.splice(index, 1);
                        }
                    }
                },

                getQuantity(ticket) {
                    const item = this.cart.find(i => i.ticket.id === ticket.id);
                    return item ? item.quantity : 0;
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.ticket.price * item.quantity), 0);
                },

                get discountAmount() {
                    return Math.round(this.subtotal * (this.selectedDiscount / 100));
                },

                get totalAll() {
                    return Math.max(0, this.subtotal - this.discountAmount + this.selectedParking);
                },

                formatRupiah(value) {
                    return value.toLocaleString('id-ID');
                },

                printReceipt() {
                    const win = window.open('', '', 'width=400,height=600');
                    if (!win) {
                        alert("Popup diblokir. Mohon izinkan untuk mencetak.");
                        return;
                    }

                    win.document.write(`
                        <html>
                            <head>
                                <title>Struk Pembayaran</title>
                                <style>
                                    body { font-family: sans-serif; padding: 20px; }
                                    .text-center { text-align: center; }
                                    .mb { margin-bottom: 10px; }
                                    .border-top { border-top: 1px solid #ccc; margin-top: 10px; padding-top: 10px; }
                                </style>
                            </head>
                            <body>
                                <div class="text-center mb">
                                    <strong>Wisata Sendang Plesungan</strong><br>Struk Pembayaran
                                </div>
                                <div>
                                    Tanggal: ${new Date().toLocaleString('id-ID')}<br>
                                    Metode: ${this.paymentMethod === 'qris' ? 'QRIS' : 'Tunai'}<br>
                                    Plat Nomor: ${this.platNomor}
                                </div>
                                <div class="border-top">
                                    ${this.cart.map(item => `
                                        <div>
                                            ${item.ticket.name} x${item.quantity}
                                            <span style="float:right">Rp ${this.formatRupiah(item.ticket.price * item.quantity)}</span>
                                        </div>
                                    `).join('')}
                                    Diskon: <span style="float:right">${this.discountAmount > 0 ? `Rp ${this.formatRupiah(this.discountAmount)}` : '0'}</span><br>
                                    Parkir: <span style="float:right">${this.selectedParking > 0 ? `Rp ${this.formatRupiah(this.selectedParking)}` : '0'}</span>
                                </div>
                                <div class="border-top text-center">
                                    Total: <strong>Rp ${this.formatRupiah(this.totalAll)}</strong>
                                </div>
                            </body>
                        </html>
                    `);
                    win.document.close();
                    win.print();
                }
            }
        }
    </script>
</body>

</html>