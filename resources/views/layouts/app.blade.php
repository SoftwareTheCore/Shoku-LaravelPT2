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

    <style>
        body {
            background-color: #fbf0ea;
            color: #333333;
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
        }

        .app-sidebar {
            --bs-offcanvas-width: 260px;
            width: 260px;
            flex: 0 0 260px;
            background: #ffffff;
            color: #6c757d;
            border-right: 1px solid #f2e3db;
        }

        .app-sidebar-body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 24px 18px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 72px;
            padding: 8px 10px 28px;
            text-decoration: none;
        }

        .brand-mark {
            max-width: 100%;
            height: 44px;
            width: auto;
            object-fit: contain;
        }

        .sidebar-section-label {
            color: #9c9590;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0 14px;
            margin: 20px 0 10px;
        }

        .app-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #79716c;
            border-radius: 14px;
            min-height: 46px;
            padding: 11px 16px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 6px;
            transition: all 0.15s ease;
        }

        .app-sidebar .nav-link:hover {
            color: #ff5232;
            background-color: #fff4f0;
        }

        .app-sidebar .nav-link i {
            flex: 0 0 20px;
            width: 20px;
            font-size: 1.1rem;
            color: #8c8580;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-link-label {
            min-width: 0;
            line-height: 1.3;
        }

        .app-sidebar .nav-link:hover i {
            color: #ff5232;
        }

        .app-sidebar .nav-link.active {
            background-color: #ff5232;
            color: #ffffff;
            font-weight: 600;
        }

        .app-sidebar .nav-link.active i {
            color: #ffffff;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 24px;
            border-top: 1px solid #f2e6df;
        }

        .sidebar-logout-btn {
            background: transparent;
            border: none;
            color: #ff5232;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 12px 16px;
            border-radius: 12px;
            transition: background-color 0.15s ease;
        }

        .sidebar-logout-btn:hover {
            background-color: #fff2ed;
            color: #d93d1f;
        }

        @media (min-width: 992px) {
            .app-sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
                overflow-y: auto;
            }
        }

        .app-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background-color: #fbf0ea;
        }

        /* Top Bar */
        .app-topbar {
            min-height: 72px;
            background-color: #ff5232;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 28px;
            color: #ffffff;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-user-info {
            text-align: right;
            line-height: 1.3;
        }

        .topbar-user-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: #ffffff;
            display: block;
        }

        .topbar-user-id {
            font-size: 0.74rem;
            color: rgba(255, 255, 255, 0.82);
            letter-spacing: 0.04em;
        }

        .topbar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #7b291d;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ROOT WARNA */
        :root {
            --shoku-primary: rgb(255, 82, 50);
            --shoku-primary-dark: #cc3b1e;
            --shoku-secondary: #ffffff;
        }

        .mobile-toolbar,
        .public-navbar {
            min-height: 72px;
            background-color: var(--shoku-primary);
            color: #fff;
        }

        .mobile-toolbar {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 18px;
            box-shadow: 0 2px 12px rgba(255, 82, 50, .2);
            z-index: 1;
        }

        .mobile-toolbar .btn {
            color: #fff;
            border-color: rgba(255, 255, 255, .4);
        }

        .mobile-brand {
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }

        .mobile-toolbar .brand-mark {
            width: 36px;
            height: 36px;
            flex-basis: 36px;
        }

        .app-content {
            flex: 1;
        }

        .app-footer {
            padding: 18px 24px;
            color: #6c757d;
            font-size: .875rem;
            border-top: 1px solid #e9ecef;
        }

        .public-navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 28px;
            box-shadow: 0 2px 12px rgba(255, 82, 50, .18);
        }

        .public-navbar .navbar-brand {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        .navbar-logo {
            width: 140px;
            height: 60px;
            object-fit: contain;
        }

        .shoku-orange {
            color: var(--shoku-primary);
        }

        .btn-shoku {
            background-color: var(--shoku-primary);
            border-color: var(--shoku-primary);
            color: white;
            font-weight: 600;
        }

        .btn-shoku:hover,
        .btn-shoku:focus {
            background-color: var(--shoku-primary-dark);
            border-color: var(--shoku-primary-dark);
            color: white;
        }

        .public-navbar .btn-public-nav {
            background-color: #fff;
            color: var(--shoku-primary);
            border: 1px solid #fff;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all .2s ease;
        }

        .public-navbar .btn-public-nav:hover,
        .public-navbar .btn-public-nav:focus {
            background-color: rgba(255, 255, 255, .92);
            color: var(--shoku-primary-dark);
        }

        @media (max-width: 991.98px) {
            .app-sidebar-body {
                min-height: 0;
                height: calc(100vh - 70px);
            }

            .public-navbar {
                padding: 0 16px;
            }
        }
    </style>

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
                        @if (auth()->user()->role === 'admin')
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-grid-fill"></i><span class="sidebar-link-label">Dashboard</span>
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}" href="{{ route('admin.karyawan.index') }}">
                                <i class="bi bi-people"></i><span class="sidebar-link-label">Karyawan</span>
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">
                                <i class="bi bi-book"></i><span class="sidebar-link-label">Menu</span>
                            </a>

                            <div class="sidebar-section-label mt-3">RECORDS</div>
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') && request('tab') !== 'pemasukan' ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="bi bi-list-task"></i><span class="sidebar-link-label">Histori Pesanan</span>
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" href="{{ route('admin.reservations.index') }}">
                                <i class="bi bi-calendar4"></i><span class="sidebar-link-label">Histori Reservasi</span>
                            </a>
                            <a class="nav-link {{ request('tab') === 'pemasukan' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['tab' => 'pemasukan']) }}">
                                <i class="bi bi-graph-up-arrow"></i><span class="sidebar-link-label">Histori Pemasukan</span>
                            </a>
                        @elseif (auth()->user()->role === 'karyawan')
                            <a class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}" href="{{ route('karyawan.dashboard') }}">
                                <i class="bi bi-grid-fill"></i><span class="sidebar-link-label">Dashboard</span>
                            </a>
                        @elseif (auth()->user()->role === 'customer')
                            <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                                <i class="bi bi-grid-fill"></i><span class="sidebar-link-label">Dashboard</span>
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.menu.*') ? 'active' : '' }}" href="{{ route('customer.menu.index') }}">
                                <i class="bi bi-book"></i><span class="sidebar-link-label">Menu</span>
                            </a>
                            <div class="sidebar-section-label mt-3">RECORDS</div>
                            <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">
                                <i class="bi bi-list-task"></i><span class="sidebar-link-label">Histori Pesanan</span>
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.reservations.*') ? 'active' : '' }}" href="{{ route('customer.reservations.index') }}">
                                <i class="bi bi-calendar4"></i><span class="sidebar-link-label">Histori Reservasi</span>
                            </a>
                        @else
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="bi bi-house"></i><span class="sidebar-link-label">Home</span>
                            </a>
                        @endif
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
                {{-- Orange Topbar --}}
                <header class="app-topbar">
                    <div class="d-flex align-items-center justify-content-between w-100">
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

    @stack('scripts')

</body>
</html>
