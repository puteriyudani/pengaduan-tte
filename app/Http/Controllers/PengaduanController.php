<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'opd'         => 'required|string|max:255',
            'keterangan'  => 'required|string',
        ]);

        \App\Models\Pengaduan::create($validated);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }
}
