<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Models\Produk;
use App\Models\Diskon;
use App\Models\Parkir;
use App\Models\Transaksi;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect ke dashboard jika sudah login
Route::get('/', function () {
    return Auth::check() ? redirect('admin.dashboard') : redirect('/login');
});

// Login Page
Route::get('/login', function (Request $request) {
    if (auth()->check()) {
        $userName = auth()->user()->name;
        return redirect('admin.dashboard')->with('info', "Anda Sudah Login, $userName!");
    }
    return view('login.index', [
        'infoMessage' => $request->query('msg', '')
    ]);
})->name('login');

// Proses Login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login')->with('success', 'Logout Berhasil!');
})->name('logout');


// ✅ Middleware Auth untuk halaman utama
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/produk', [DashboardController::class, 'produk'])->name('produk');
    Route::get('/kasir', [DashboardController::class, 'kasir'])->name('kasir');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
    Route::get('/slipgaji', [DashboardController::class, 'slipgaji'])->name('slipgaji');
    Route::get('/parkir', [DashboardController::class, 'parkir'])->name('parkir');
    Route::get('/diskon', [DashboardController::class, 'diskon'])->name('diskon');
    Route::get('/karyawan', [DashboardController::class, 'karyawan'])->name('karyawan');
    Route::get('/absensi', [DashboardController::class, 'absensi'])->name('absensi');
    Route::get('/keuangan', [DashboardController::class, 'keuangan'])->name('keuangan');
    Route::get('/setting', [DashboardController::class, 'setting'])->name('setting');
});

// Admin Group
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/produk', [DashboardController::class, 'produk'])->name('admin.produk');
    Route::get('/kasir', [DashboardController::class, 'kasir'])->name('admin.kasir');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('admin.laporan');
    Route::get('/slipgaji', [DashboardController::class, 'slipgaji'])->name('admin.slipgaji');
    Route::get('/parkir', [DashboardController::class, 'parkir'])->name('admin.parkir');
    Route::get('/diskon', [DashboardController::class, 'diskon'])->name('admin.diskon');
    Route::get('/karyawan', [DashboardController::class, 'karyawan'])->name('admin.karyawan');
    Route::get('/absensi', [DashboardController::class, 'absensi'])->name('admin.absensi');
    Route::get('/keuangan', [DashboardController::class, 'keuangan'])->name('admin.keuangan');
    Route::get('/setting', [DashboardController::class, 'setting'])->name('admin.setting');
});

// Kasir Group
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('kasir.dashboard');
    Route::get('/kasir', [DashboardController::class, 'kasir'])->name('kasir.kasir');
    Route::get('/setting', [DashboardController::class, 'setting'])->name('kasir.setting');
    Route::get('/absensi/scan', [DashboardController::class, 'scanAbsensi'])->name('kasir.absensi.scan');
    Route::post('/absensi/submit', [DashboardController::class, 'submitAbsensi'])->name('kasir.absensi.submit');
});

// User Group
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/qrcode', [DashboardController::class, 'qrcode'])->name('user.qrcode');
});

Route::middleware('auth')->group(function () {
    Route::get('/api/tickets', fn() => Produk::all());
    Route::get('/api/discounts', fn() => Diskon::all());
    Route::get('/api/parkings', fn() => Parkir::all());

    Route::post('/api/transaksi', function (Request $request) {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string',
            'subtotal' => 'required|integer',
            'diskon' => 'required|integer',
            'parkir' => 'required|integer',
            'total' => 'required|integer',
            'detail' => 'required|array',
        ]);

        $transaksi = Transaksi::create($validated);
        return response()->json(['status' => 'success', 'data' => $transaksi]);
    });
});

Route::get('/api/omset', [DashboardController::class, 'omsetData']);
