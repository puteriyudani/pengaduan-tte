@extends('layouts.layout')
@section('title', 'Pengaduan')
@section('styles')
    <style>
        .sidebar-brand img {
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.7));
        }

        .nav-link .fa-chevron-right {
            transition: transform 0.3s ease;
        }

        .nav-link[aria-expanded="true"] .fa-chevron-right {
            transform: rotate(90deg);
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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Users</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('kategori.index') }}">
                        <i class="fas fa-fw fa-puzzle-piece"></i>
                        <span>Category</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('opd.index') }}">
                        <i class="fas fa-fw fa-university"></i>
                        <span>OPD</span></a>
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
                <li class="nav-item active">
                    <a class="nav-link collapsed d-flex justify-content-between align-items-center" href="#"
                        data-bs-toggle="collapse" data-bs-target="#collapsePengaduan" aria-expanded="false"
                        aria-controls="collapsePengaduan">
                        <div>
                            <i class="fas fa-fw fa-bullhorn"></i>
                            <span>Pengaduan</span>
                        </div>
                        <i class="fas fa-chevron-right transition"></i>
                    </a>
                    <div id="collapsePengaduan" class="collapse" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{ route('pengaduan.index') }}">Semua Pengaduan</a>
                            <a class="collapse-item active" href="{{ route('pengaduan.pending') }}">Pending</a>
                            <a class="collapse-item" href="{{ route('pengaduan.selesailist') }}">Selesai</a>
                        </div>
                    </div>
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

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Pengaduan Pending</h1>
                    <p class="mb-4">Daftar pengaduan TTE yang masih berstatus pending.</p>

                    <!-- Pengaduan -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Pengaduan</h6>
                            <a href="{{ route('pengaduan.exportPdf', ['status' => 'pending']) }}" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-download fa-sm text-white-50"></i> Download
                            </a>
                        </div>

                        <div class="card-body">
                            <!-- Filter Kategori -->
                            <div class="mb-3">
                                <a href="{{ route('pengaduan.pending') }}"
                                    class="btn btn-sm {{ !$kategoriId ? 'btn-primary' : 'btn-outline-primary' }}">
                                    Semua
                                </a>
                                @foreach ($kategori as $item)
                                    <a href="{{ route('pengaduan.pending', ['kategori_id' => $item->id]) }}"
                                        class="btn btn-sm {{ $kategoriId == $item->id ? 'btn-primary' : 'btn-outline-primary' }}">
                                        {{ $item->nama_kategori }}
                                    </a>
                                @endforeach
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No. WhatsApp</th>
                                            <th>OPD</th>
                                            <th>Keterangan</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pengaduans as $index => $pengaduan)
                                            <tr @if ($pengaduan->status === 'selesai') class="table-success" @endif>
                                                <td>{{ $pengaduans->firstItem() + $index }}</td>
                                                <td>{{ $pengaduan->created_at->format('d-m-Y H:i') }}</td>
                                                <td>{{ $pengaduan->nama }}</td>
                                                <td>{{ $pengaduan->email }}</td>
                                                <td>{{ $pengaduan->whatsapp }}</td>
                                                <td>{{ $pengaduan->opd->nama_opd }}</td>
                                                <td>{{ $pengaduan->keterangan }}</td>
                                                <td>
                                                    <span class="badge bg-info text-dark">
                                                        {{ $pengaduan->kategori->nama_kategori ?? '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($pengaduan->status === 'selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($pengaduan->status !== 'selesai')
                                                        <form action="{{ route('pengaduan.selesai', $pengaduan->id) }}"
                                                            method="POST" style="display:inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                onclick="return confirm('Tandai pengaduan ini selesai?')">
                                                                Selesai
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">Sudah selesai</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center text-muted">
                                                    Belum ada pengaduan yang masuk.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $pengaduans->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
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
@endsection
