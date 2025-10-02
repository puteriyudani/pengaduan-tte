<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // kasih default dulu biar aman
        $jumlahSuperAdmin = $jumlahAdmin = $jumlahKategori = null;
        $totalPengaduan = $pendingPengaduan = $selesaiPengaduan = null;

        if ($user->role === 'super_admin') {
            $jumlahSuperAdmin = User::where('role', 'super_admin')->count();
            $jumlahAdmin      = User::where('role', 'admin')->count();
            $jumlahKategori   = Kategori::count();
        }

        if ($user->role === 'admin') {
            $totalPengaduan   = Pengaduan::count();
            $pendingPengaduan = Pengaduan::where('status', 'pending')->count();
            $selesaiPengaduan = Pengaduan::where('status', 'selesai')->count();
        }

        return view('dashboard', compact(
            'jumlahSuperAdmin',
            'jumlahAdmin',
            'jumlahKategori',
            'totalPengaduan',
            'pendingPengaduan',
            'selesaiPengaduan'
        ));
    }
}
