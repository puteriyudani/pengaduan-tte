<?php

namespace App\Http\Controllers;

use App\Models\OPD;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opds = OPD::withCount('pengaduan')
            ->orderBy('nama_opd', 'asc')
            ->paginate(10);
        return view('opd.index', compact('opds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('opd.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_opd' => 'required|string|max:255|unique:opds,nama_opd',
        ]);

        OPD::create([
            'nama_opd' => $request->nama_opd,
        ]);

        return redirect()->route('opd.index')->with('success', 'OPD berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $opd = OPD::findOrFail($id);
        return view('opd.edit', compact('opd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $opd = OPD::findOrFail($id);

        $request->validate([
            'nama_opd' => 'required|string|max:255|unique:opds,nama_opd,' . $opd->id,
        ]);

        $opd->update([
            'nama_opd' => $request->nama_opd,
        ]);

        return redirect()->route('opd.index')->with('success', 'OPD berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $opd = OPD::findOrFail($id);

        $jumlahPengaduan = $opd->pengaduan()->count();

        if ($jumlahPengaduan > 0) {
            return redirect()
                ->route('opd.index')
                ->with(
                    'error',
                    "OPD tidak dapat dihapus karena masih digunakan oleh {$jumlahPengaduan} data pengaduan. Pindahkan atau arsipkan data pengaduan terlebih dahulu."
                );
        }

        $opd->delete();

        return redirect()
            ->route('opd.index')
            ->with('success', 'OPD berhasil dihapus.');
    }
}
