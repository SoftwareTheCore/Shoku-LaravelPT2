@extends('layouts.app', ['title' => 'Dashboard Customer - Shoku'])

@php
    $user = auth()->user();
    $myReservationsCount = \App\Models\Reservation::where('user_id', $user->id)->count();
    $myOrdersCount = \App\Models\Order::where('user_id', $user->id)->count();
    $totalMenu = \App\Models\Menu::count();

    // Total belanja / transaksi customer
    $totalSpent = \App\Models\Order::where('user_id', $user->id)
        ->where('status', 'completed')
        ->sum('total_amount');

    // Reservasi terbaru customer
    $myReservations = \App\Models\Reservation::with('table')
        ->where('user_id', $user->id)
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
        <h1 class="dashboard-heading mb-2">Dashboard Customer</h1>
        <p class="dashboard-subheading mb-0">Selamat datang kembali, {{ $user->name }}. Ringkasan reservasi & pesanan Anda.</p>
    </div>

    {{-- Metric Stat Cards (3 in a row) --}}
    <div class="row g-4 mb-5">
        {{-- Total Menu Tersedia --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon icon-menu">
                    <i class="bi bi-book"></i>
                </div>
                <div class="stat-card-content">
                    <span class="stat-card-label">Pilihan Menu</span>
                    <span class="stat-card-value">{{ $totalMenu }}</span>
                </div>
            </div>
        </div>

        {{-- Total Pesanan Saya --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon icon-order">
                    <i class="bi bi-bag"></i>
                </div>
                <div class="stat-card-content">
                    <span class="stat-card-label">Pesanan Saya</span>
                    <span class="stat-card-value">{{ $myOrdersCount }}</span>
                </div>
            </div>
        </div>

        {{-- Total Reservasi Saya --}}
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <div class="stat-card-icon icon-reservasi">
                    <i class="bi bi-calendar4"></i>
                </div>
                <div class="stat-card-content">
                    <span class="stat-card-label">Reservasi Meja</span>
                    <span class="stat-card-value">{{ $myReservationsCount }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Transaksi Card --}}
    <div class="mb-5">
        <h2 class="section-title mb-3">Total Transaksi Selesai</h2>
        <div class="card revenue-card">
            <div class="card-body p-0">
                <span class="revenue-label">Total Belanja di Shoku</span>
                <div class="revenue-value">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- Table Histori Reservasi Customer --}}
    <div class="card table-card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;">No</th>
                        <th>ID Reservasi</th>
                        <th>ID Meja</th>
                        <th>Tanggal Booking</th>
                        <th>Jumlah Orang</th>
                        <th class="pe-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myReservations as $index => $res)
                        <tr>
                            <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                            <td class="fw-medium text-dark">#RES-{{ $res->id }}</td>
                            <td class="fw-medium text-dark">{{ $res->table ? $res->table->table_number : ($res->restaurant_table_id ?? '-') }}</td>
                            <td class="text-secondary">{{ $res->created_at ? $res->created_at->format('Y-m-d H:i:s') : $res->reservation_date->format('Y-m-d') }}</td>
                            <td class="text-dark">{{ $res->guest_count }} Orang</td>
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
                                Anda belum memiliki riwayat reservasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>


@endsection
