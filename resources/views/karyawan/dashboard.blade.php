@extends('layouts.app', ['title' => 'Dashboard Karyawan - Shoku'])

@php
    $totalMenu = \App\Models\Menu::count();
    $totalOrder = \App\Models\Order::count();
    $totalReservasi = \App\Models\Reservation::count();

    // Pemasukan hari ini
    $todayRevenue = \App\Models\Order::where('status', 'completed')
        ->whereDate('completed_at', today())
        ->sum('total_amount');

    // Reservasi terbaru
    $recentReservations = \App\Models\Reservation::with(['user', 'table'])
        ->latest()
        ->take(5)
        ->get();
@endphp

@section('content')
<div class="dashboard-wrapper">

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-shoku-success d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Header Title --}}
    <div class="dashboard-header mb-4">
        <h1 class="dashboard-heading mb-2">Dashboard Karyawan</h1>
        <p class="dashboard-subheading mb-0">Ringkasan aktivitas operasional restaurant Shoku.</p>
    </div>

    {{-- Metric Stat Cards (3 in a row) --}}
    <div class="row g-4 mb-5">
        {{-- Total Menu --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon icon-menu">
                    <i class="bi bi-book"></i>
                </div>
                <div class="stat-card-content">
                    <span class="stat-card-label">Total Menu</span>
                    <span class="stat-card-value">{{ $totalMenu }}</span>
                </div>
            </div>
        </div>

        {{-- Total Order --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon icon-order">
                    <i class="bi bi-bag"></i>
                </div>
                <div class="stat-card-content">
                    <span class="stat-card-label">Total Order</span>
                    <span class="stat-card-value">{{ $totalOrder }}</span>
                </div>
            </div>
        </div>

        {{-- Total Reservasi --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon icon-reservasi">
                    <i class="bi bi-calendar4"></i>
                </div>
                <div class="stat-card-content">
                    <span class="stat-card-label">Total Reservasi</span>
                    <span class="stat-card-value">{{ $totalReservasi }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Pemasukan Hari Ini Card --}}
    <div class="mb-5">
        <h2 class="section-title mb-3">Laporan Penjualan Hari Ini</h2>
        <div class="card revenue-card">
            <div class="card-body p-0">
                <span class="revenue-label">Pemasukan Hari Ini</span>
                <div class="revenue-value">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Table Booking / Reservasi Terbaru --}}
    <div class="card table-card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;">No</th>
                        <th>ID Pelanggan</th>
                        <th>ID Meja</th>
                        <th>Tanggal Booking</th>
                        <th>Jumlah Orang</th>
                        <th class="pe-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReservations as $index => $res)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td class="fw-medium text-dark">{{ $res->user_id }}</td>
                            <td class="fw-medium text-dark">{{ $res->table ? $res->table->table_number : ($res->restaurant_table_id ?? '-') }}</td>
                            <td class="text-secondary">{{ $res->created_at ? $res->created_at->format('Y-m-d H:i:s') : $res->reservation_date->format('Y-m-d') }}</td>
                            <td class="text-dark">{{ $res->guest_count }}</td>
                            <td class="pe-4 text-center">
                                @if(strtolower($res->status) === 'confirmed')
                                    <span class="status-badge status-confirmed">Confirmed</span>
                                @elseif(strtolower($res->status) === 'pending')
                                    <span class="status-badge status-pending">Pending</span>
                                @elseif(strtolower($res->status) === 'cancelled')
                                    <span class="status-badge status-cancelled">Cancelled</span>
                                @else
                                    <span class="status-badge status-other">{{ ucfirst($res->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Belum ada data reservasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


@endsection
