<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // default biar aman
        $jumlahSuperAdmin = $jumlahAdmin = $jumlahKategori = null;
        $totalPengaduan = $pendingPengaduan = $selesaiPengaduan = null;
        $pengaduanPerBulan = [];
        $pengaduanPerOpd = [];
        $pengaduanPerKategori = [];

        if ($user->role === 'super_admin') {
            $jumlahSuperAdmin = User::where('role', 'super_admin')->count();
            $jumlahAdmin      = User::where('role', 'admin')->count();
            $jumlahKategori   = Kategori::count();
        }

        if ($user->role === 'admin') {
            $totalPengaduan   = Pengaduan::count();
            $pendingPengaduan = Pengaduan::where('status', 'pending')->count();
            $selesaiPengaduan = Pengaduan::where('status', 'selesai')->count();

            // Grafik per bulan
            $pengaduanPerBulan = Pengaduan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('bulan')
                ->pluck('total', 'bulan')
                ->toArray();

            $allMonths = range(1, 12);
            $pengaduanPerBulan = collect($allMonths)->mapWithKeys(function ($m) use ($pengaduanPerBulan) {
                return [$m => $pengaduanPerBulan[$m] ?? 0];
            })->toArray();

            // Grafik per OPD
            $pengaduanPerOpd = DB::table('pengaduan')
                ->join('opds', 'pengaduan.opd_id', '=', 'opds.id')
                ->select('opds.nama_opd', DB::raw('COUNT(pengaduan.id) as total'))
                ->groupBy('opds.nama_opd')
                ->pluck('total', 'opds.nama_opd')
                ->toArray();

            // Grafik per Kategori (semua kategori, termasuk yang 0)
            $kategoriList = Kategori::all();

            $pengaduanPerKategori = $kategoriList->mapWithKeys(function ($kategori) {
                $total = Pengaduan::where('kategori_id', $kategori->id)->count();
                return [$kategori->nama_kategori => $total];
            })->toArray();
        }

        return view('dashboard', compact(
            'jumlahSuperAdmin',
            'jumlahAdmin',
            'jumlahKategori',
            'totalPengaduan',
            'pendingPengaduan',
            'selesaiPengaduan',
            'pengaduanPerBulan',
            'pengaduanPerOpd',
            'pengaduanPerKategori'
        ));
    }
}
