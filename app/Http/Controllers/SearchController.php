<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Kategori;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $users = User::where('name', 'like', "%{$q}%")
            ->orWhere('email', 'like', "%{$q}%")
            ->get();

        $pengaduan = Pengaduan::where('judul', 'like', "%{$q}%")
            ->orWhere('isi', 'like', "%{$q}%")
            ->get();

        $kategori = Kategori::where('nama', 'like', "%{$q}%")->get();

        return view('search.results', compact('q', 'users', 'pengaduan', 'kategori'));
    }
}
