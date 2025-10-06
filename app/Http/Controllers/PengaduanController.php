<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\PengaduanSelesaiMail;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $kategoriId = $request->get('kategori_id'); // ambil parameter dari URL
        $kategori = Kategori::all();

        $pengaduans = Pengaduan::when($kategoriId, function ($query) use ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        })->latest()->get();

        return view('pengaduan.index', compact('pengaduans', 'kategori', 'kategoriId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'whatsapp'       => 'required|max:20',
            'kategori_id' => 'required|exists:kategori,id',
            'opd'         => 'required|string|max:255',
            'keterangan'  => 'required|string',
        ]);

        Pengaduan::create($validated);

        return redirect('/')->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function selesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // update status dan tanggal selesai
        $pengaduan->update([
            'status' => 'selesai',
            'tanggal_selesai' => now()->toDateString(), // otomatis isi tanggal hari ini (YYYY-MM-DD)
        ]);

        // kirim email
        Mail::to($pengaduan->email)->send(new PengaduanSelesaiMail($pengaduan));

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditandai selesai dan notifikasi dikirim.');
    }

    public function exportPdf()
    {
        // ambil semua pengaduan dengan relasi kategori
        $pengaduan = Pengaduan::with('kategori')->get();

        // group by kolom opd langsung
        $pengaduanPerOpd = $pengaduan->groupBy('opd');

        $pdf = Pdf::loadView('pengaduan.pdf', compact('pengaduanPerOpd'));
        return $pdf->download('laporan-pengaduan-tte.pdf');
    }
}
