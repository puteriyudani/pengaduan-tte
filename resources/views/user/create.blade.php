@extends('layouts.layout')
@section('title', 'Tambah Kategori')
@section('styles')
    <style>
        .sidebar-brand img {
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.7));
        }
    </style>
@endsection
@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid" style="max-height: 40px;">
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span></a>
            </li>

            @if (Auth::user()->role === 'super_admin')
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Data
                </div>

                <!-- Nav Item -->
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Users</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kategori.index') }}">
                        <i class="fas fa-fw fa-puzzle-piece"></i>
                        <span>Category</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            @endif

            @if (Auth::user()->role === 'admin')
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Data
                </div>

                <!-- Nav Item -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pengaduan.index') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Pengaduan</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            @endif

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ms-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                    Profile
                                </a>
                                {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>
                                    Activity Log
                                </a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tambah User</h1>
                    <p class="mb-4">Silakan isi form untuk menambahkan user baru.</p>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('superadmin.users.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" required>

                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required>

                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control"
                                            required>
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                            data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>

                                    <small id="passwordHelp" class="form-text">
                                        Password minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.
                                    </small>

                                    <div class="valid-feedback">✔ Password sesuai</div>
                                    <div class="invalid-feedback">❌ Password tidak memenuhi syarat</div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" required>
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                            data-target="password_confirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>

                                    <small id="confirmHelp" class="form-text">
                                        Konfirmasi password harus sama dengan password.
                                    </small>

                                    <div class="valid-feedback">✔ Konfirmasi password sesuai</div>
                                    <div class="invalid-feedback">❌ Konfirmasi password tidak cocok</div>
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="admin">Admin</option>
                                        <option value="super_admin">Super Admin</option>
                                    </select>

                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Diskominfotik Bid.Persandian 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a href="{{ route('logout') }}" class="btn btn-primary"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const body = document.body;
            const sidebarToggle = document.getElementById("sidebarToggle");
            const sidebarToggleTop = document.getElementById("sidebarToggleTop");

            function toggleSidebar() {
                body.classList.toggle("sidebar-toggled");
                document.querySelector(".sidebar").classList.toggle("toggled");
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", toggleSidebar);
            }

            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener("click", toggleSidebar);
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const password = document.getElementById("password");
            const confirmPassword = document.getElementById("password_confirmation");
            const passwordHelp = document.getElementById("passwordHelp");
            const confirmHelp = document.getElementById("confirmHelp");

            function validatePassword() {
                const value = password.value;

                // regex: minimal 8 karakter, huruf besar, kecil, angka, simbol
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

                if (regex.test(value)) {
                    password.classList.remove("is-invalid");
                    password.classList.add("is-valid");
                    passwordHelp.classList.remove("text-danger");
                    passwordHelp.classList.add("text-success");
                } else {
                    password.classList.remove("is-valid");
                    password.classList.add("is-invalid");
                    passwordHelp.classList.remove("text-success");
                    passwordHelp.classList.add("text-danger");
                }
                validateConfirmPassword(); // check ulang confirm kalau password berubah
            }

            function validateConfirmPassword() {
                if (confirmPassword.value === "") {
                    confirmPassword.classList.remove("is-valid", "is-invalid");
                    confirmHelp.classList.remove("text-danger", "text-success");
                    return;
                }

                if (confirmPassword.value === password.value) {
                    confirmPassword.classList.remove("is-invalid");
                    confirmPassword.classList.add("is-valid");
                    confirmHelp.classList.remove("text-danger");
                    confirmHelp.classList.add("text-success");
                } else {
                    confirmPassword.classList.remove("is-valid");
                    confirmPassword.classList.add("is-invalid");
                    confirmHelp.classList.remove("text-success");
                    confirmHelp.classList.add("text-danger");
                }
            }

            password.addEventListener("input", validatePassword);
            confirmPassword.addEventListener("input", validateConfirmPassword);
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // toggle show/hide password
            document.querySelectorAll(".toggle-password").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    const targetId = this.getAttribute("data-target");
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector("i");

                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.remove("fa-eye");
                        icon.classList.add("fa-eye-slash");
                    } else {
                        input.type = "password";
                        icon.classList.remove("fa-eye-slash");
                        icon.classList.add("fa-eye");
                    }
                });
            });
        });
    </script>
@endsection
