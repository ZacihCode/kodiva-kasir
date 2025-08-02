<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public $totalKaryawan = 0;
    public $hadirHariIni = 0;
    public function index()
    {
        $user = auth()->user();
        $userName = $user->name;

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        $totalKaryawan = User::where('role', 'user')->count();
        $hadirHariIni = Absensi::whereDate('tanggal', $today)
            ->where('status', 'hadir')
            ->count();

        $persentaseKehadiran = $totalKaryawan > 0
            ? round(($hadirHariIni / $totalKaryawan) * 100, 2)
            : 0;

        if ($user->role === 'admin') {
            // Transaksi hari ini & kemarin
            $transaksiHariIni = Transaksi::whereDate('created_at', $today)->get();
            $transaksiKemarin = Transaksi::whereDate('created_at', $yesterday)->get();

            // Hitung omset
            $omsetHariIni = $transaksiHariIni->sum('total');
            $omsetKemarin = $transaksiKemarin->sum('total');

            // Hitung tiket
            $tiketHariIni = $transaksiHariIni->sum(function ($trx) {
                return is_array($trx->detail) ? count($trx->detail) : 0;
            });
            $tiketKemarin = $transaksiKemarin->sum(function ($trx) {
                return is_array($trx->detail) ? count($trx->detail) : 0;
            });

            // Persentase perubahan
            $persentaseOmset = $omsetKemarin > 0
                ? (($omsetHariIni - $omsetKemarin) / $omsetKemarin) * 100
                : 0;
            $persentaseTiket = $tiketKemarin > 0
                ? (($tiketHariIni - $tiketKemarin) / $tiketKemarin) * 100
                : 0;

            // Flash message jika pertama login
            if (!session()->has('success')) {
                return redirect()->route('admin.dashboard')->with('success', 'Login Admin Berhasil!');
            }

            return view('admin.dashboard.index', [
                'omsetHariIni'        => $omsetHariIni,
                'tiketTerjual'        => $tiketHariIni,
                'persentaseOmset'     => round($persentaseOmset, 2),
                'persentaseTiket'     => round($persentaseTiket, 2),
                'totalKaryawan'       => $totalKaryawan,
                'hadirHariIni'        => $hadirHariIni,
                'persentaseKehadiran' => $persentaseKehadiran,
            ]);
        } elseif ($user->role === 'kasir') {
            return view('kasir.dashboard.index', [
                'omsetHariIni'        => null,
                'tiketTerjual'        => null,
                'persentaseOmset'     => null,
                'persentaseTiket'     => null,
                'totalKaryawan'       => $totalKaryawan,
                'hadirHariIni'        => $hadirHariIni,
                'persentaseKehadiran' => $persentaseKehadiran,
            ]);
        } else {
            return abort(403);
        }
    }

    public function omsetData(Request $request)
    {
        $filter = $request->query('filter', 'harian');

        $labels = [];
        $data = [];

        if ($filter === 'harian') {
            $today = Carbon::today();
            $omset = Transaksi::whereDate('created_at', $today)->sum('total');
            $labels = [$today->translatedFormat('l')];
            $data = [$omset];
        } elseif ($filter === 'mingguan') {
            $startOfWeek = Carbon::now()->startOfWeek();
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $labels[] = $date->translatedFormat('l'); // Senin, Selasa, dst
                $data[] = Transaksi::whereDate('created_at', $date)->sum('total');
            }
        } elseif ($filter === 'bulanan') {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $dateRange = $startOfMonth->diffInDays($endOfMonth);

            for ($i = 0; $i <= $dateRange; $i++) {
                $date = $startOfMonth->copy()->addDays($i);
                $labels[] = $date->format('d M');
                $data[] = Transaksi::whereDate('created_at', $date)->sum('total');
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function qrcode()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $absen = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        // Cek apakah sudah absen
        $sudahAbsen = false;
        $status = 'Belum Absen';

        if ($absen) {
            // User sudah absen sebelumnya
            $sudahAbsen = true;
            $status = $absen->status === 'hadir' ? 'Hadir' : 'Tidak Hadir';
        } else {
            $now = Carbon::now()->format('H:i:s');
            if ($now > '23:00:00') {
                // Jika belum absen dan sekarang lewat jam 22:00
                Absensi::create([
                    'user_id' => $user->id,
                    'tanggal' => now(),
                    'status' => 'tidak hadir',
                    'keterangan' => 'Tidak hadir karena sudah lewat jam 22:00',
                ]);
                $status = 'Tidak Hadir';
                $sudahAbsen = true;
            }
        }

        return view('user.qrcodes.index', compact('user', 'sudahAbsen', 'status'));
    }

    public function scanAbsensi()
    {
        return view('admin.absensi.scan');
    }

    public function submitAbsensi(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
        ]);

        $userId = $request->input('user_id');
        $tanggal = now(); // gunakan full datetime

        // Cek apakah user sudah absen hari ini (bandingkan hanya tanggalnya)
        $existing = Absensi::where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($existing) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Karyawan sudah melakukan absensi hari ini.'
            ]);
        }

        // Simpan absensi
        Absensi::create([
            'user_id' => $userId,
            'tanggal' => $tanggal,
            'status'  => 'hadir',
            'keterangan' => 'Hadir tepat waktu',
        ]);

        // ==== Tambahkan atau Update Slip Gaji ====
        $user = \App\Models\User::findOrFail($userId);

        $slip = \App\Models\SlipGaji::where('nama_karyawan', $user->name)->first();

        if ($slip) {
            // Sudah ada, update gaji
            $slip->gaji_pokok += 50000;
            $slip->total_gaji = ($slip->gaji_pokok + $slip->tunjangan) - $slip->potongan;
            $slip->save();
        } else {
            // Belum ada, buat baru
            \App\Models\SlipGaji::create([
                'nama_karyawan' => $user->name,
                'posisi' => $user->role ?? 'Karyawan', // sesuaikan jika posisi disimpan di field lain
                'gaji_pokok' => 50000,
                'tunjangan' => 0,
                'potongan' => 0,
                'total_gaji' => 50000,
                'status' => 'Belum Terkirim',
                'no_wa' => $user->phone ?? '0',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => '✅ Absensi berhasil disimpan.'
        ]);
    }

    public function produk()
    {
        return view('admin.produk.index');
    }

    public function kasir()
    {
        return view('kasir.kasir.index');
    }

    public function laporan()
    {
        return view('admin.laporan.index');
    }

    public function slipgaji()
    {
        return view('admin.slipgaji.index');
    }

    public function slipgajiSetting()
    {
        return view('admin.slipgaji.setting');
    }

    public function parkir()
    {
        return view('admin.parkir.index');
    }

    public function diskon()
    {
        return view('admin.diskon.index');
    }

    public function karyawan()
    {
        return view('admin.karyawan.index');
    }

    public function absensi()
    {
        return view('admin.absensi.index');
    }

    public function keuangan()
    {
        return view('admin.keuangan.index');
    }

    public function setting()
    {
        return view('admin.setting.index');
    }
}
