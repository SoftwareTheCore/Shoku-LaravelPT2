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

    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #fbf0ea !important;
        }
        body:has(.auth-page-container) {
            background-color: var(--shoku-primary, #ff5232) !important;
        }
        .app-shell, .app-main {
            min-height: 100vh;
            background-color: #fbf0ea;
        }

        /* Desktop sidebar collapse */
        @media (min-width: 992px) {
            .app-sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
                overflow-y: auto;
                transition: margin-left 0.25s ease-in-out, opacity 0.2s ease-in-out;
            }

            .app-shell.sidebar-collapsed .app-sidebar,
            html.sidebar-init-collapsed .app-shell .app-sidebar {
                margin-left: -260px !important;
                opacity: 0 !important;
                visibility: hidden !important;
                pointer-events: none !important;
            }

            .app-main {
                transition: margin-left 0.25s ease-in-out;
            }
        }

        /* Breadcrumb styling */
        .app-breadcrumb-container .breadcrumb {
            font-size: 0.85rem;
        }
        .app-breadcrumb-container .breadcrumb-item a {
            color: var(--shoku-primary, #ff5232);
            text-decoration: none;
            font-weight: 500;
        }
        .app-breadcrumb-container .breadcrumb-item a:hover {
            color: var(--shoku-primary-dark, #d93d1f);
            text-decoration: underline;
        }
        .app-breadcrumb-container .breadcrumb-item.active {
            color: #8c8580;
            font-weight: 600;
        }
    </style>

    <script>
        // Apply collapsed state before render to avoid flickering
        if (localStorage.getItem('shokuSidebarCollapsed') === '1' && window.innerWidth >= 992) {
            document.documentElement.classList.add('sidebar-init-collapsed');
        }
    </script>

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
                            class="btn btn-outline-light me-3 d-inline-flex align-items-center justify-content-center"
                            type="button"
                            id="appSidebarToggle"
                            aria-label="Toggle menu navigasi"
                            style="width: 38px; height: 38px; border-radius: 8px;"
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

                <div class="app-breadcrumb-container px-4 pt-3 pb-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 align-items-center">
                            @hasSection('breadcrumb')
                                @yield('breadcrumb')
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ $workspaceUrl }}" class="d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-house-door-fill"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                @php
                                    $segments = request()->segments();
                                    $subSegments = array_slice($segments, 1);
                                    $currentTab = request('tab');
                                    $titleMap = [
                                        'menu-categories' => 'Kategori Menu',
                                        'menus' => 'Menu Restoran',
                                        'menu' => 'Menu',
                                        'orders' => 'Laporan Pesanan',
                                        'reservations' => 'Laporan Reservasi',
                                        'karyawan' => 'Data Karyawan',
                                        'meja' => 'Data Meja',
                                        'create' => 'Tambah',
                                        'edit' => 'Ubah'
                                    ];
                                @endphp
                                @if(!empty($subSegments) && !(count($subSegments) === 1 && $subSegments[0] === 'dashboard'))
                                    @php
                                        $urlAcc = url($segments[0]);
                                        $totalSubs = count($subSegments);
                                    @endphp
                                    @foreach($subSegments as $idx => $seg)
                                        @php
                                            $urlAcc .= '/' . $seg;
                                            $isLast = ($idx === $totalSubs - 1) && empty($currentTab);
                                            $segKey = strtolower($seg);
                                            $label = $titleMap[$segKey] ?? (is_numeric($seg) ? '#' . $seg : ucwords(str_replace(['-', '_'], ' ', $seg)));
                                        @endphp
                                        @if($isLast)
                                            <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
                                        @else
                                            <li class="breadcrumb-item">
                                                <a href="{{ $urlAcc }}">{{ $label }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                    @if(!empty($currentTab))
                                        <li class="breadcrumb-item active text-capitalize" aria-current="page">
                                            {{ ucwords(str_replace(['-', '_'], ' ', $currentTab)) }}
                                        </li>
                                    @endif
                                @endif
                            @endif
                        </ol>
                    </nav>
                </div>

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

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Global Frontend Handlers (Pure Vanilla JS) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Restore desktop collapsed state
            const appShell = document.querySelector('.app-shell');
            if (localStorage.getItem('shokuSidebarCollapsed') === '1' && window.innerWidth >= 992) {
                appShell?.classList.add('sidebar-collapsed');
            }
            document.documentElement.classList.remove('sidebar-init-collapsed');

            // Attach single sidebar toggle listener
            const sidebarToggle = document.getElementById('appSidebarToggle');
            const sidebarEl = document.getElementById('appSidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (window.innerWidth < 992) {
                        // Mobile: Toggle Bootstrap Offcanvas drawer
                        if (sidebarEl && typeof bootstrap !== 'undefined') {
                            const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebarEl);
                            bsOffcanvas.toggle();
                        }
                    } else {
                        // Desktop: Toggle sidebar-collapsed class on .app-shell
                        if (appShell) {
                            const isCollapsed = appShell.classList.toggle('sidebar-collapsed');
                            localStorage.setItem('shokuSidebarCollapsed', isCollapsed ? '1' : '0');
                        }
                    }
                });
            }

            // Global SweetAlert2 Session Flash Notifications
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: @json(session('success')),
                    confirmButtonColor: '#ff5232',
                    timer: 3000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: @json(session('error')),
                    confirmButtonColor: '#ff5232'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Periksa Kembali Form',
                    html: '{!! implode("<br>", array_map("e", $errors->all())) !!}',
                    confirmButtonColor: '#ff5232'
                });
            @endif

            // Unified Confirmation Handler with data-confirm (Vanilla JS)
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('[data-confirm]');
                if (!btn) return;

                e.preventDefault();
                const form = btn.closest('form');
                const message = btn.getAttribute('data-confirm') || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ff5232',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (form) {
                                form.submit();
                            } else if (btn.getAttribute('href')) {
                                window.location.href = btn.getAttribute('href');
                            }
                        }
                    });
                } else if (confirm(message)) {
                    if (form) form.submit();
                    else if (btn.getAttribute('href')) window.location.href = btn.getAttribute('href');
                }
            });
        });
    </script>

    @auth
    @endauth

    @stack('scripts')

</body>
</html>
