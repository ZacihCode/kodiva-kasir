<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\User;
use App\Models\SlipGaji;
use App\Models\GajiSetting;
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

        $data = [
            'totalKaryawan'       => $totalKaryawan,
            'hadirHariIni'        => $hadirHariIni,
            'persentaseKehadiran' => $persentaseKehadiran,
        ];

        // Hanya untuk role admin & kasir
        if (in_array($user->role, ['admin', 'kasir'])) {
            $transaksiHariIni = Transaksi::whereDate('created_at', $today)->get();
            $transaksiKemarin = Transaksi::whereDate('created_at', $yesterday)->get();

            $omsetHariIni = $transaksiHariIni->sum('total');
            $omsetKemarin = $transaksiKemarin->sum('total');

            $tiketHariIni = $transaksiHariIni->sum(function ($trx) {
                return is_array($trx->detail) ? count($trx->detail) : 0;
            });
            $tiketKemarin = $transaksiKemarin->sum(function ($trx) {
                return is_array($trx->detail) ? count($trx->detail) : 0;
            });

            $persentaseOmset = $omsetKemarin > 0
                ? (($omsetHariIni - $omsetKemarin) / $omsetKemarin) * 100
                : 0;

            $persentaseTiket = $tiketKemarin > 0
                ? (($tiketHariIni - $tiketKemarin) / $tiketKemarin) * 100
                : 0;

            $data = array_merge($data, [
                'omsetHariIni'    => $omsetHariIni,
                'tiketTerjual'    => $tiketHariIni,
                'persentaseOmset' => round($persentaseOmset, 2),
                'persentaseTiket' => round($persentaseTiket, 2),
            ]);
        }

        // Flash hanya sekali saat login
        if (!session()->has('success')) {
            session()->flash('success', $user->role === 'admin' ? 'Login Admin Berhasil!' : 'Login Kasir Berhasil!');
        }

        if ($user->role === 'admin') {
            return view('admin.dashboard.index', $data);
        } elseif ($user->role === 'kasir') {
            return view('kasir.dashboard.index', $data);
        }

        return abort(403);
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
        $tanggal = now();

        // Cek apakah user sudah absen hari ini
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
            'status' => 'hadir',
            'keterangan' => 'Hadir tepat waktu',
        ]);

        // Ambil pengaturan gaji
        $setting = GajiSetting::first();
        $gajiPerHadir = $setting->gaji_per_hadir ?? 50000;
        $tunjanganDefault = $setting->tunjangan_default ?? 0;
        $potonganDefault = $setting->potongan_default ?? 0;

        // Tambah atau update slip gaji
        $user = User::findOrFail($userId);

        $slip = SlipGaji::where('nama_karyawan', $user->name)->first();

        if ($slip) {
            $slip->gaji_pokok += $gajiPerHadir;
            $slip->total_gaji = ($slip->gaji_pokok + $slip->tunjangan) - $slip->potongan;
            $slip->save();
        } else {
            SlipGaji::create([
                'nama_karyawan' => $user->name,
                'posisi' => $user->role ?? 'Karyawan',
                'gaji_pokok' => $gajiPerHadir,
                'tunjangan' => $tunjanganDefault,
                'potongan' => $potonganDefault,
                'total_gaji' => ($gajiPerHadir + $tunjanganDefault) - $potonganDefault,
                'status' => 'Belum Terkirim',
                'no_wa' => $user->phone ?? '0',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => '✅ Absensi berhasil disimpan.'
        ]);
    }

    public function getTiketData(Request $request)
    {
        $filter = $request->query('filter', 'harian'); // 'harian', 'mingguan', 'bulanan'

        $query = Transaksi::selectRaw('DATE(created_at) as tanggal, detail');

        switch ($filter) {
            case 'mingguan':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case 'bulanan':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            default:
                $query->whereDate('created_at', now());
        }

        $result = $query->get();

        $tiketCounter = [];

        foreach ($result as $row) {
            foreach ($row->detail as $item) {
                $name = $item['name'];
                $tiketCounter[$name] = ($tiketCounter[$name] ?? 0) + ($item['qty'] ?? 1);
            }
        }

        return response()->json([
            'labels' => array_keys($tiketCounter),
            'data' => array_values($tiketCounter),
        ]);
    }

    public function getVisitorData(Request $request)
    {
        $filter = $request->query('filter', 'harian'); // default harian

        $query = Transaksi::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc');

        // Filter berdasarkan waktu
        switch ($filter) {
            case 'mingguan':
                $query->where('created_at', '>=', now()->subDays(7));
                break;
            case 'bulanan':
                $query->where('created_at', '>=', now()->subDays(30));
                break;
            default: // harian
                $query->whereDate('created_at', now());
        }

        $data = $query->get();

        // Format data untuk chart
        $labels = [];
        $counts = [];

        foreach ($data as $row) {
            $labels[] = date('d M', strtotime($row->tanggal));
            $counts[] = (int) $row->jumlah;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $counts,
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
