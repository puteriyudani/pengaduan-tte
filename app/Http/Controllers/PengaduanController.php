<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Mail\PengaduanSelesaiMail;
use Illuminate\Support\Facades\Mail;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $kategoriId = $request->get('kategori_id'); // ambil parameter dari URL
        $kategori = \App\Models\Kategori::all();

        $pengaduans = \App\Models\Pengaduan::when($kategoriId, function ($query) use ($kategoriId) {
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

        \App\Models\Pengaduan::create($validated);

        return redirect('/')->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function selesai($id)
    {
        $pengaduan = \App\Models\Pengaduan::findOrFail($id);

        // update status
        $pengaduan->status = 'selesai';
        $pengaduan->save();

        // kirim email
        Mail::to($pengaduan->email)->send(new PengaduanSelesaiMail($pengaduan));

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditandai selesai dan notifikasi dikirim.');
    }
}
