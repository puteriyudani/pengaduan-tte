<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Models\Kategori;
use App\Models\OPD;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $kategori = Kategori::all();
    $opd = OPD::all();
    return view('home', compact('kategori', 'opd'));
});

Route::post('pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

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
    Route::resource('user', UserController::class);
    Route::resource('opd', OpdController::class);

    Route::get('superadmin/users/create', [RegisteredUserController::class, 'createForSuperAdmin'])
        ->name('superadmin.users.create');
    Route::post('superadmin/users', [RegisteredUserController::class, 'storeForSuperAdmin'])
        ->name('superadmin.users.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::patch('pengaduan/{id}/selesai', [PengaduanController::class, 'selesai'])->name('pengaduan.selesai');
    Route::get('/pengaduan/pending', [PengaduanController::class, 'pending'])->name('pengaduan.pending');
    Route::get('/pengaduan/selesai', [PengaduanController::class, 'selesaiList'])->name('pengaduan.selesailist');
    Route::get('/pengaduan/pdf', [PengaduanController::class, 'exportPdf'])
        ->name('pengaduan.exportPdf');
});

require __DIR__ . '/auth.php';
