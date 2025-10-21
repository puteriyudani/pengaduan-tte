@extends('layouts.layout')
@section('title', 'Pengaduan TTE')
@section('styles')
    <style>
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

        .logo-top {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 3;
        }

        .logo-top img {
            height: 60px;
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.7));
        }

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

        /* Bintang merah untuk field wajib */
        .required-star {
            color: #dc3545;
            font-weight: bold;
            margin-left: 2px;
        }

        /* Border merah kalau input kosong saat submit */
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.1rem rgba(220, 53, 69, 0.25);
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-bg">
        <div class="logo-top">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
        </div>

        <div class="content-wrapper">
            <h3>Selamat Datang di Sistem Pengaduan Tanda Tangan Elektronik</h3>
            <a href="#" class="btn-laporan" data-bs-toggle="modal" data-bs-target="#formLaporanModal">
                Buat Laporan
            </a>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
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
                    <form id="formPengaduan" action="{{ route('pengaduan.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama (sesuai KTP)<span
                                    class="required-star">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Dinas<span class="required-star">*</span></label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="nama@riau.go.id" required>
                        </div>

                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">No. WhatsApp<span
                                    class="required-star">*</span></label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control"
                                placeholder="628xxxxxxxxxx" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori Permasalahan<span
                                    class="required-star">*</span></label>
                            <select name="kategori_id" id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3 d-none" id="kategori_lainnya_wrapper">
                            <label for="kategori_lainnya" class="form-label">Tulis Kategori Lainnya<span
                                    class="required-star">*</span></label>
                            <input type="text" name="kategori_lainnya" id="kategori_lainnya" class="form-control"
                                placeholder="Masukkan kategori permasalahan lain">
                        </div>

                        <div class="mb-3">
                            <label for="opd_id" class="form-label">OPD<span class="required-star">*</span></label>
                            <select name="opd_id" id="opd_id" class="form-select" required>
                                <option value="">-- Pilih OPD --</option>
                                @foreach ($opd as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_opd }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan<span
                                    class="required-star">*</span></label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="4"
                                placeholder="Jelaskan kendala yang dialami" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var formModal = new bootstrap.Modal(document.getElementById('formLaporanModal'));
                formModal.show();
            });
        </script>
    @endif
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectKategori = document.getElementById('kategori_id');
            const inputLainnyaWrapper = document.getElementById('kategori_lainnya_wrapper');
            const inputLainnya = document.getElementById('kategori_lainnya');

            selectKategori.addEventListener('change', function() {
                if (this.value === 'lainnya') {
                    inputLainnyaWrapper.classList.remove('d-none');
                    inputLainnya.required = true;
                } else {
                    inputLainnyaWrapper.classList.add('d-none');
                    inputLainnya.required = false;
                    inputLainnya.value = '';
                }
            });

            // Tambahkan validasi warna merah otomatis
            const form = document.getElementById('formPengaduan');
            form.addEventListener('submit', function(e) {
                let invalid = false;
                form.querySelectorAll('input[required], select[required], textarea[required]').forEach(
                    field => {
                        if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            invalid = true;
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });
                if (invalid) {
                    e.preventDefault(); // cegah submit jika ada yang kosong
                }
            });
        });
    </script>
@endsection
