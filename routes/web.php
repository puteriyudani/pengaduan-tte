<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $kategori = Kategori::all();
    return view('home', compact('kategori'));
});

Route::resource('pengaduan', PengaduanController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('kategori', KategoriController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('pengaduan', PengaduanController::class);
    Route::patch('pengaduan/{id}/selesai', [PengaduanController::class, 'selesai'])->name('pengaduan.selesai');
});

require __DIR__ . '/auth.php';
