<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Models\Produk;
// use App\Models\Diskon;
// use App\Models\Parkir;
// use App\Models\Transaksi;
// use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API untuk fetch data ke kasir (gunakan auth:sanctum jika ingin amankan)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/tickets', fn() => Produk::all());
//     Route::get('/discounts', fn() => Diskon::all());
//     Route::get('/parkings', fn() => Parkir::all());

//     Route::post('/transaksi', function (Request $request) {
//         // Log::info('Transaksi request diterima:', $request->all());
//         $validated = $request->validate([
//             'metode_pembayaran' => 'required|string',
//             'subtotal' => 'required|integer',
//             'diskon' => 'required|integer',
//             'parkir' => 'required|integer',
//             'total' => 'required|integer',
//             'detail' => 'required|array',
//         ]);

//         $transaksi = Transaksi::create($validated);
//         return response()->json(['status' => 'success', 'data' => $transaksi]);
//     });
// });
