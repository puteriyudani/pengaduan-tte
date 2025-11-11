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
            display: flex;
            align-items: center;
            gap: 10px;
            /* jarak antar logo */
        }

        .logo-top img {
            height: 60px;
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.7));
            transition: transform 0.2s ease;
        }

        .logo-top img:hover {
            transform: scale(1.05);
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

        /* Tombol WhatsApp melayang */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 25px;
            right: 25px;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover {
            background-color: #1EBE5D;
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        .whatsapp-icon {
            margin-top: 14px;
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-bg">
        <div class="logo-top">
            <img src="{{ asset('img/riau.png') }}" alt="Logo Kiri" class="logo-left">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Kanan" class="logo-right">
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

    <!-- Tombol WhatsApp -->
    <a href="https://wa.me/6281275116838" target="_blank" class="whatsapp-float">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="white" viewBox="0 0 24 24">
            <path
                d="M20.52 3.48A11.89 11.89 0 0 0 12.06 0 11.94 11.94 0 0 0 0 12a11.81 11.81 0 0 0 1.58 5.94L0 24l6.3-1.64A12.08 12.08 0 0 0 12.06 24a11.94 11.94 0 0 0 8.46-20.52zM12.06 22a9.91 9.91 0 0 1-5.06-1.38l-.36-.21-3.74.97 1-3.64-.23-.38A9.87 9.87 0 0 1 2.1 12a9.96 9.96 0 0 1 9.96-9.96 9.83 9.83 0 0 1 7 2.9 9.75 9.75 0 0 1 2.92 7A9.96 9.96 0 0 1 12.06 22zm5.46-7.47c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.66.15-.2.3-.76.97-.93 1.17-.17.2-.34.23-.63.08-.3-.15-1.25-.46-2.38-1.47a8.9 8.9 0 0 1-1.65-2.05c-.17-.3 0-.46.13-.61.13-.13.3-.34.45-.51.15-.17.2-.3.3-.5.1-.2.05-.38-.03-.53-.08-.15-.66-1.6-.9-2.2-.24-.58-.48-.5-.66-.5h-.56c-.2 0-.53.08-.8.38s-1.05 1.02-1.05 2.5 1.08 2.9 1.23 3.1c.15.2 2.12 3.23 5.15 4.53.72.31 1.28.5 1.72.64.72.23 1.37.2 1.89.12.58-.09 1.77-.73 2.02-1.43.25-.7.25-1.3.17-1.43-.08-.13-.27-.2-.57-.35z" />
        </svg>
    </a>

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
