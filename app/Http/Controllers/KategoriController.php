<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Tampilkan semua kategori.
     */
    public function index()
    {
        $kategoris = Kategori::withCount('pengaduan')->paginate(10);

        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori', 'nama_kategori')
                    ->whereNull('deleted_at'),
            ],
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit kategori.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update kategori di database.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori', 'nama_kategori')
                    ->ignore($kategori->id)
                    ->whereNull('deleted_at'),
            ],
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $jumlahPengaduan = $kategori->pengaduan()->count();

        if ($jumlahPengaduan > 0) {
            return redirect()
                ->route('kategori.index')
                ->with(
                    'error',
                    "Kategori tidak dapat dihapus karena masih digunakan oleh {$jumlahPengaduan} data pengaduan. Pindahkan atau arsipkan data pengaduan terlebih dahulu."
                );
        }

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
