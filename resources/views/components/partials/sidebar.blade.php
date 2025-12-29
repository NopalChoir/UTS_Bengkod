<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">POLIKLINIK APP</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                {{-- Menampilkan nama user yang sedang login --}}
                <a href="#" class="d-block">{{ Auth::user()->nama ?? 'Guest' }}</a>
                <span class="d-block text-muted text-sm">{{ ucfirst(Auth::user()->role ?? 'Guest') }}</span>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Menu Dashboard Admin --}}
                @if (Auth::user()->role == 'admin')
                    <li class="nav-header">ADMIN MENU</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard Admin</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hospital"></i>
                            <p>Manajemen Poli</p>
                        </a>
                    </li>
                @endif

                {{-- Menu Dokter --}}
                @if (Auth::user()->role == 'dokter' || Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('dokter.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Manajemen Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwal.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Jadwal Periksa</p>
                        </a>
                    <li class="nav-item">
                        <a href="{{ route('dokter.periksa-pasien.index') }}"
                        class="nav-link {{ request()->routeIs('dokter.periksa-pasien*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-stethoscope"></i>
                            <p>Periksa Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('riwayat-pasien.index') }}"
                        class="nav-link {{ request()->routeIs('riwayat-pasien[].*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Periksa Pasien</p>
                        </a>
                    </li>
                @endif

                {{-- Menu Pasien --}}
                @if (Auth::user()->role == 'pasien' || Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('pasien.dashboard') }}"
                        class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>Dashboard Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.daftar.index') }}"
                        class="nav-link {{ request()->routeIs('pasien.daftar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hospital-user"></i>
                            <p>Poli Pasien</p>
                        </a>
                    </li>
                @endif

                {{-- Menu Obat --}}
                @if (Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('obat.index') }}"
                        class="nav-link {{ request()->routeIs('obat.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>Manajemen Obat</p>
                        </a>
                    </li>
                @endif

                {{-- Tombol Logout --}}
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="nav-link">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger btn-block">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        </div>
    </aside>
