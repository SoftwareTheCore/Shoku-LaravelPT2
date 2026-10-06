<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $appName = match (auth()->user()?->role) {
            'admin' => 'My Admin Shque',
            'karyawan' => 'My Karyawan Shque',
            'customer' => 'Shque Japanese Resto',
            default => 'Shque',
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
            background-color: #f8f9fa;
        }

        .app-shell {
            min-height: 100vh;
            display: flex;
        }

        .app-sidebar {
            --bs-offcanvas-width: 270px;
            width: 270px;
            flex: 0 0 270px;
            background: linear-gradient(155deg, #1d2926 0%, #212529 58%, #292d2d 100%);
            color: #adb5bd;
        }

        .app-sidebar-body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 24px 16px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            font-weight: 700;
            color: #fff;
            font-size: 1.1rem;
            text-decoration: none;
            padding: 0 10px 28px;
        }

        .sidebar-brand:hover {
            color: #fff;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            background-color: #d35400;
            color: #fff;
            font-size: 1.15rem;
        }

        .brand-caption {
            display: block;
            margin-top: 2px;
            color: #929ba0;
            font-size: .68rem;
            font-weight: 400;
        }

        .sidebar-mobile-header {
            min-height: 70px;
            border-bottom: 1px solid #3b4147;
        }

        .sidebar-mobile-header .sidebar-brand {
            padding: 0;
        }

        .sidebar-section-label {
            color: #818991;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0 12px;
            margin: 8px 0 10px;
        }

        .app-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            color: #c4c9ce;
            border-radius: 7px;
            padding: 11px 12px;
            transition: color .16s ease, background-color .16s ease;
        }

        .app-sidebar .nav-link:hover,
        .app-sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, .08);
        }

        .app-sidebar .nav-link i {
            width: 19px;
            color: #aab2b5;
            font-size: 1rem;
            text-align: center;
        }

        .app-sidebar .nav-link.active {
            background-color: rgba(211, 84, 0, .2);
            box-shadow: inset 3px 0 #e77832;
        }

        .app-sidebar .nav-link.active i {
            color: #f2a06f;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 24px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 12px;
            padding: 12px;
            border: 1px solid #3b4147;
            border-radius: 8px;
            background: rgba(255, 255, 255, .035);
        }

        .sidebar-avatar {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background-color: #f1c3a8;
            color: #542b18;
            font-size: 1rem;
        }

        .sidebar-user-name {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .sidebar-logout {
            border-color: #454d52;
            color: #c4c9ce;
            padding: 10px 12px;
        }

        .sidebar-logout:hover {
            border-color: #a94418;
            background-color: rgba(211, 84, 0, .14);
            color: #fff;
        }

        .app-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .mobile-toolbar,
        .public-navbar {
            min-height: 64px;
            background-color: #212529;
            color: #fff;
        }

        .mobile-toolbar {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 18px;
            box-shadow: 0 2px 12px rgba(33, 37, 41, .12);
            z-index: 1;
        }

        .mobile-toolbar .btn {
            color: #fff;
            border-color: #596168;
        }

        .mobile-brand {
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }

        .mobile-toolbar .brand-mark {
            width: 32px;
            height: 32px;
            flex-basis: 32px;
            font-size: 1rem;
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
            padding: 0 24px;
        }

        .public-navbar .navbar-brand {
            color: #fff;
            font-weight: 700;
            text-decoration: none;
        }

        .shque-orange {
            color: #d35400;
        }

        .btn-shque {
            background-color: #d35400;
            border-color: #d35400;
            color: white;
        }

        .btn-shque:hover {
            background-color: #a84300;
            border-color: #a84300;
            color: white;
        }

        @media (min-width: 992px) {
            .app-sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
                overflow-y: auto;
            }
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
                <div class="offcanvas-header sidebar-mobile-header">
                    <a class="sidebar-brand" href="/" id="appSidebarLabel">
                        <span class="brand-mark"><i class="bi bi-shop"></i></span>
                        <span>{{ $appName }}<small class="brand-caption">Restaurant workspace</small></span>
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#appSidebar" aria-label="Tutup menu"></button>
                </div>

                <div class="offcanvas-body app-sidebar-body">
                    <a class="sidebar-brand d-none d-lg-flex" href="/">
                        <span class="brand-mark"><i class="bi bi-shop"></i></span>
                        <span>{{ $appName }}<small class="brand-caption">Restaurant workspace</small></span>
                    </a>

                    <div class="sidebar-section-label">Menu Utama</div>
                    <nav class="nav flex-column gap-1" aria-label="Navigasi utama">
                        @if (auth()->user()->role === 'admin')
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.menu-categories.*') ? 'active' : '' }}" href="{{ route('admin.menu-categories.index') }}">
                                <i class="bi bi-tags"></i> Kategori Menu
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">
                                <i class="bi bi-list-ul"></i> Menu
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}" href="{{ route('admin.karyawan.index') }}">
                                <i class="bi bi-people"></i> Karyawan
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.meja.*') ? 'active' : '' }}" href="{{ route('admin.meja.index') }}">
                                <i class="bi bi-grid-3x3-gap"></i> Meja
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" href="{{ route('admin.reservations.index') }}">
                                <i class="bi bi-calendar-check"></i> Konfirmasi &amp; Histori Booking
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                <i class="bi bi-receipt"></i> Histori Order
                            </a>
                        @elseif (auth()->user()->role === 'karyawan')
                            <a class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}" href="{{ route('karyawan.dashboard') }}">
                                <i class="bi bi-clipboard-check"></i> Dashboard Karyawan
                            </a>
                        @elseif (auth()->user()->role === 'customer')
                            <a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.menu.*') ? 'active' : '' }}" href="{{ route('customer.menu.index') }}">
                                <i class="bi bi-journal-text"></i> Menu
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.reservations.*') ? 'active' : '' }}" href="{{ route('customer.reservations.index') }}">
                                <i class="bi bi-calendar-check"></i> Reservasi
                            </a>
                            <a class="nav-link {{ request()->routeIs('customer.orders.*') ? 'active' : '' }}" href="{{ route('customer.orders.index') }}">
                                <i class="bi bi-bag"></i> Order Saya
                            </a>
                        @else
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="bi bi-house"></i> Home
                            </a>
                        @endif
                    </nav>

                    <div class="sidebar-bottom">
                        <div class="sidebar-user">
                            <span class="sidebar-avatar"><i class="bi bi-person"></i></span>
                            <span class="sidebar-user-name">
                                <small class="d-block text-secondary">{{ ucfirst(auth()->user()->role) }}</small>
                                <span class="text-white fw-semibold">{{ auth()->user()->name }}</span>
                            </span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-light sidebar-logout w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="app-main">
                <div class="mobile-toolbar d-lg-none">
                    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#appSidebar" aria-controls="appSidebar" aria-label="Buka menu">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <a class="mobile-brand d-flex align-items-center gap-2" href="/">
                        <span class="brand-mark"><i class="bi bi-shop"></i></span>{{ $appName }}
                    </a>
                </div>

                <main class="app-content">
                    @yield('content')
                </main>

                <footer class="app-footer">
                    &copy; {{ date('Y') }} Shque. Japanese Restaurant Management System.
                </footer>
            </div>
        </div>
    @else
        <div class="app-main min-vh-100">
            <nav class="public-navbar">
                <a class="navbar-brand" href="{{ route('home') }}">{{ $appName }}</a>
                @if (request()->routeIs('login'))
                    <a href="{{ route('home') }}" class="btn btn-shque">
                        <i class="bi bi-house-door me-1"></i> Kembali ke Home
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-shque">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </a>
                @endif
            </nav>

            <main class="app-content">
                @yield('content')
            </main>

            <footer class="app-footer">
                &copy; {{ date('Y') }} Shque. Japanese Restaurant Management System.
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