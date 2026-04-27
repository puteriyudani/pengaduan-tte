<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PengaduanSelesaiMail;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\PDF;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $kategoriId = $request->get('kategori_id'); // ambil parameter dari URL
        $kategori = Kategori::all();

        $pengaduans = Pengaduan::when($kategoriId, function ($query) use ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        })->latest()->paginate(10);

        return view('pengaduan.index', compact('pengaduans', 'kategori', 'kategoriId'));
    }

    public function pending(Request $request)
    {
        $kategoriId = $request->get('kategori_id');
        $kategori = Kategori::all();

        $pengaduans = Pengaduan::where('status', 'pending')
            ->when($kategoriId, function ($query) use ($kategoriId) {
                $query->where('kategori_id', $kategoriId);
            })
            ->latest()
            ->paginate(10);

        return view('pengaduan.pending', compact('pengaduans', 'kategori', 'kategoriId'));
    }

    public function selesaiList(Request $request)
    {
        $kategoriId = $request->get('kategori_id');
        $kategori = Kategori::all();

        $pengaduans = Pengaduan::where('status', 'selesai')
            ->when($kategoriId, function ($query) use ($kategoriId) {
                $query->where('kategori_id', $kategoriId);
            })
            ->latest()
            ->paginate(10);

        return view('pengaduan.selesai', compact('pengaduans', 'kategori', 'kategoriId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@riau.go.id')) {
                        $fail('Email harus menggunakan domain @riau.go.id');
                    }
                }
            ],
            'whatsapp'    => 'required|max:20',
            'kategori_id' => 'required|exists:kategori,id',
            'opd_id'      => 'required|exists:opds,id',
            'keterangan'  => 'required|string',
        ]);

        $pengaduan = Pengaduan::create($validated);

        // ambil relasi biar tampil nama
        $pengaduan->load('kategori', 'opd');

        // format pesan
        $pesan = "Pengaduan TTE Baru\n\n"
            . "Nama: {$pengaduan->nama}\n"
            . "Email: {$pengaduan->email}\n"
            . "No WA: {$pengaduan->whatsapp}\n"
            . "Kategori: {$pengaduan->kategori->nama_kategori}\n"
            . "OPD: {$pengaduan->opd->nama_opd}\n"
            . "Keterangan: {$pengaduan->keterangan}";

        // encode biar aman di URL
        $pesanEncoded = urlencode($pesan);

        // nomor tujuan
        $nomor = "6281275116838";

        // redirect ke WhatsApp
        return redirect("https://wa.me/$nomor?text=$pesanEncoded");
    }

    public function selesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // update status dan tanggal selesai
        $pengaduan->update([
            'status' => 'selesai',
            'tanggal_selesai' => now()->format('Y-m-d H:i:s'),
        ]);

        // kirim email
        Mail::to($pengaduan->email)->send(new PengaduanSelesaiMail($pengaduan));

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditandai selesai dan notifikasi dikirim.');
    }

    public function downloadRekap()
    {
        $pengaduan = Pengaduan::with(['opd', 'kategori'])->get();

        // Group by OPD
        $rekapPerOpd = $pengaduan->groupBy('opd.nama_opd');

        // Hitung total
        $total = $pengaduan->count();
        $totalPending = $pengaduan->where('status', 'pending')->count();
        $totalSelesai = $pengaduan->where('status', 'selesai')->count();

        $pdf = PDF::loadView('laporan.pengaduan_rekap', compact('rekapPerOpd', 'total', 'totalPending', 'totalSelesai'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Rekap_Pengaduan_TTE.pdf');
    }

    public function downloadDetail()
    {
        $pengaduan = Pengaduan::with(['opd', 'kategori'])->get();
        $pengaduanPerOpd = $pengaduan->groupBy('opd_id');

        $pdf = PDF::loadView('laporan.pengaduan_detail', compact('pengaduanPerOpd'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Detail_Pengaduan_TTE.pdf');
    }
}
