<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $role = auth()->user()?->role;
        $appName = match ($role) {
            'admin' => 'My Admin Shoku',
            'karyawan' => 'My Karyawan Shoku',
            'customer' => 'Shoku Japanese Resto',
            default => 'Shoku',
        };
        $logoPath = route('brand.logo');
        $workspaceUrl = match ($role) {
            'admin' => route('admin.dashboard'),
            'karyawan' => route('karyawan.dashboard'),
            'customer' => route('customer.dashboard'),
            default => route('home'),
        };
    @endphp

    <title>{{ $title ?? $appName }}</title>

    {{-- Bootstrap 5 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body>

    @auth
        <div class="app-shell">
            <aside class="offcanvas-lg offcanvas-start app-sidebar" tabindex="-1" id="appSidebar" aria-labelledby="appSidebarLabel">
                <div class="offcanvas-header p-3 border-bottom d-lg-none">
                    <a class="sidebar-brand p-0" href="{{ $workspaceUrl }}" id="appSidebarLabel">
                        <img class="brand-mark" src="{{ $logoPath }}" alt="Shoku">
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#appSidebar" aria-label="Tutup menu"></button>
                </div>

                <div class="offcanvas-body app-sidebar-body">
                    <a class="sidebar-brand d-none d-lg-flex" href="{{ $workspaceUrl }}">
                        <img class="brand-mark" src="{{ $logoPath }}" alt="Shoku">
                    </a>

                    <div class="sidebar-section-label">MAIN MENU</div>
                    <nav class="nav flex-column gap-1" aria-label="Navigasi utama">
                        <ul id="sidebarnav" class="list-unstyled w-100 mb-0">
                        @if (auth()->user()->role === 'admin')
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-grid-fill"></i><span class="sidebar-link-label">Dashboard</span>
                            </a></li>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}" href="{{ route('admin.karyawan.index') }}">
                                <i class="bi bi-people"></i><span class="sidebar-link-label">Karyawan</span>
                            </a></li>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('admin.menu-categories.*') ? 'active' : '' }}" href="{{ route('admin.menu-categories.index') }}">
                                <i class="bi bi-book"></i><span class="sidebar-link-label">Kategori Menu</span>
                            </a></li>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">
                                <i class="bi bi-book"></i><span class="sidebar-link-label">Menu</span>
                            </a></li>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('admin.meja.*') ? 'active' : '' }}" href="{{ route('admin.meja.index') }}">
                                <i class="bi bi-grid-3x3-gap"></i><span class="sidebar-link-label">Meja</span>
                            </a></li>


                            <div class="sidebar-section-label mt-3">RECORDS</div>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('admin.orders.*') && request('tab') !== 'pemasukan' ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="bi bi-list-task"></i><span class="sidebar-link-label">Laporan Pesanan</span>
                            </a></li>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" href="{{ route('admin.reservations.index') }}">
                                <i class="bi bi-calendar4"></i><span class="sidebar-link-label">Laporan Reservasi</span>
                            </a></li>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request('tab') === 'pemasukan' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['tab' => 'pemasukan']) }}">
                                <i class="bi bi-graph-up-arrow"></i><span class="sidebar-link-label">Laporan Pemasukan</span>
                            </a></li>
                        @elseif (auth()->user()->role === 'karyawan')
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}" href="{{ route('karyawan.dashboard') }}">
                                <i class="bi bi-grid-fill"></i><span class="sidebar-link-label">Dashboard</span>
                            </a></li>
                        @elseif (auth()->user()->role === 'customer')
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                                <i class="bi bi-grid-fill"></i><span class="sidebar-link-label">Dashboard</span>
                            </a></li>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('customer.menu.*') ? 'active' : '' }}" href="{{ route('customer.menu.index') }}">
                                <i class="bi bi-book"></i><span class="sidebar-link-label">Menu</span>
                            </a></li>
                            <div class="sidebar-section-label mt-3">RECORDS</div>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">
                                <i class="bi bi-list-task"></i><span class="sidebar-link-label">Histori Pesanan</span>
                            </a></li>
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('customer.reservations.*') ? 'active' : '' }}" href="{{ route('customer.reservations.index') }}">
                                <i class="bi bi-calendar4"></i><span class="sidebar-link-label">Histori Reservasi</span>
                            </a></li>
                        @else
                            <li class="sidebar-item"><a class="nav-link sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="bi bi-house"></i><span class="sidebar-link-label">Home</span>
                            </a></li>
                        @endif
                        </ul>
                    </nav>

                    <div class="sidebar-bottom">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="sidebar-logout-btn w-100 text-start d-flex align-items-center gap-2">
                                <i class="bi bi-box-arrow-left fs-5"></i><span class="sidebar-link-label">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="app-main">
                <header class="app-topbar">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <button
                            class="btn btn-outline-light d-lg-none"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#appSidebar"
                            aria-controls="appSidebar"
                            aria-label="Buka menu navigasi"
                        >
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <div class="topbar-user ms-auto">
                            <div class="topbar-user-info">
                                <span class="topbar-user-name">
                                    {{ auth()->user()->role === 'admin' ? 'Administrator' : auth()->user()->name }}
                                </span>
                                <span class="topbar-user-id">
                                    @if(auth()->user()->role === 'admin')
                                        SHK-HEAD-01
                                    @elseif(auth()->user()->role === 'karyawan')
                                        KRY-{{ str_pad(auth()->id(), 4, '0', STR_PAD_LEFT) }}
                                    @else
                                        CUST-{{ str_pad(auth()->id(), 4, '0', STR_PAD_LEFT) }}
                                    @endif
                                </span>
                            </div>
                            <div class="topbar-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>
                    </div>
                </header>

                <main class="app-content">
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <div class="app-main min-vh-100">
            <nav class="public-navbar">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="navbar-logo" src="{{ $logoPath }}" alt="Shoku">
                </a>
                @if (request()->routeIs('login'))
                    <a href="{{ route('home') }}" class="btn-public-nav">
                        <i class="bi bi-house-door me-1"></i> Kembali ke Home
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-public-nav">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                @endif
            </nav>

            <main class="app-content">
                @yield('content')
            </main>

            <footer class="app-footer">
                &copy; {{ date('Y') }} Shoku. Japanese Restaurant Management System.
            </footer>
        </div>
    @endauth


    {{-- Bootstrap JS --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    @auth
    @endauth

    @stack('scripts')

</body>
</html>
