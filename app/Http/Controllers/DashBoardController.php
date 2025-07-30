<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userName = auth()->user()->name;
        if ($user->role === 'admin') {
            // Cek apakah ini redirect pertama kali (flash session masih kosong)
            if (!session()->has('success')) {
                return redirect()->route('dashboard')->with('success', 'Login Admin Berhasil!');
            }
            return view('kasir.dashboard.index');
        }
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

    public function parkir()
    {
        return view('admin.parkir.index');
    }

    public function diskon()
    {
        return view('admin.diskon.index');
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
