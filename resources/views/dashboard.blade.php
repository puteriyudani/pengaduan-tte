@extends('layouts.layout')
@section('title', 'Pengaduan TTE')
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
            <li class="nav-item active">
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
                <li class="nav-item">
                    <a class="nav-link" href="#">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        @if (Auth::user()->role === 'super_admin')
                            <!-- Jumlah Super Admin -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Jumlah Super Admin</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahSuperAdmin ?? 0 }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jumlah Admin -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Jumlah Admin</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahAdmin ?? 0 }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jumlah Kategori -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Jumlah Kategori</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jumlahKategori ?? 0 }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-tags fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Auth::user()->role === 'admin')
                            <!-- Total Pengaduan -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Pengaduan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengaduan ?? 0 }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Pengaduan -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Pending</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $pendingPengaduan ?? 0 }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Selesai Pengaduan -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Selesai</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $selesaiPengaduan ?? 0 }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
@endsection
