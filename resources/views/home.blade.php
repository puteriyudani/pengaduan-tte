@extends('layouts.layout')
@section('title', 'Pengaduan TTE')
@section('styles')
    <style>
        /* Background full page */
        .dashboard-bg {
            position: relative;
            background: url("{{ asset('img/background.png') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1rem;
        }

        /* Overlay gelap */
        .dashboard-bg::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        /* Logo kiri atas */
        .logo-top {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 3;
        }

        .logo-top img {
            height: 60px;
            /* bisa disesuaikan */
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.7));
        }

        /* Konten di atas overlay */
        .content-wrapper {
            position: relative;
            z-index: 2;
            color: #fff;
            max-width: 700px;
        }

        .content-wrapper h3 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        /* Tombol */
        .btn-laporan {
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            cursor: pointer;
        }

        .btn-laporan:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-bg">
        <!-- Logo kiri atas -->
        <div class="logo-top">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
        </div>

        <div class="content-wrapper">
            <h3>Selamat Datang di Sistem Pengaduan Tanda Tangan Elektronik</h3>
            <!-- Tombol untuk buka modal -->
            <a href="#" class="btn-laporan" data-bs-toggle="modal" data-bs-target="#formLaporanModal">
                Buat Laporan
            </a>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="formLaporanModal" tabindex="-1" aria-labelledby="formLaporanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="formLaporanLabel">Form Pengaduan TTE</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pengaduan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama (sesuai KTP)</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Dinas</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="nama@riau.go.id" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori Permasalahan</label>
                            <select name="kategori_id" id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="opd" class="form-label">OPD</label>
                            <input type="text" name="opd" id="opd" class="form-control"
                                placeholder="Instansi anda" required>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="- jika tidak ada" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
