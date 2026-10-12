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

@push('styles')
<style>
    .dashboard-wrapper {
        max-width: 1360px;
        margin: 0 auto;
        padding: 44px 44px 64px 44px;
    }

    .dashboard-header {
        margin-bottom: 34px;
    }

    .dashboard-heading {
        font-family: inherit;
        font-size: 1.85rem;
        font-weight: 700;
        color: #7b291d;
        letter-spacing: -0.01em;
    }

    .dashboard-subheading {
        font-size: 0.94rem;
        color: #8c827a;
    }

    .section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #2e2621;
        margin-bottom: 16px;
    }

    .alert-shoku-success {
        background-color: #eafaf1;
        border: 1px solid #c7f0d8;
        color: #27884d;
        border-radius: 16px;
        padding: 16px 24px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 34px;
    }

    /* Stat Cards */
    .stat-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 26px 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        border: 1px solid #f7ece5;
        height: 100%;
        transition: transform 0.15s ease;
    }

    .stat-card-icon {
        width: 58px;
        height: 58px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        flex-shrink: 0;
    }

    .icon-menu {
        background-color: #fbeded;
        color: #9c4545;
    }

    .icon-order {
        background-color: #fdf5ea;
        color: #b5833e;
    }

    .icon-reservasi {
        background-color: #edf3fd;
        color: #4b7bc6;
    }

    .stat-card-content {
        display: flex;
        flex-direction: column;
    }

    .stat-card-label {
        font-size: 0.8rem;
        color: #766f69;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .stat-card-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: #221d1a;
        line-height: 1.1;
    }

    /* Revenue / Spending Card */
    .revenue-card {
        background: #ffffff;
        border: 1px solid #f7ece5;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        padding: 34px 40px;
    }

    .revenue-label {
        font-size: 0.9rem;
        color: #79716c;
        font-weight: 500;
        display: block;
        margin-bottom: 14px;
    }

    .revenue-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #7b291d;
        line-height: 1;
    }

    /* Table Card */
    .table-card {
        background: #ffffff;
        border: 1px solid #f7ece5;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }

    .table-card table thead th {
        background-color: #ff5232;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 600;
        padding-top: 18px;
        padding-bottom: 18px;
        padding-left: 20px;
        padding-right: 20px;
        border: none;
        letter-spacing: 0.02em;
    }

    .table-card table tbody td {
        padding-top: 18px;
        padding-bottom: 18px;
        padding-left: 20px;
        padding-right: 20px;
        font-size: 0.88rem;
        border-bottom: 1px solid #f3ece6;
    }

    .table-card table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Status Pill Badges */
    .status-badge {
        display: inline-block;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .status-confirmed {
        background-color: #e5f8ee;
        color: #218751;
        border: 1px solid #c4eed6;
    }

    .status-pending {
        background-color: #fdf5e6;
        color: #b58330;
        border: 1px solid #f9e7c3;
    }

    .status-cancelled {
        background-color: #fdeeee;
        color: #c93b3b;
        border: 1px solid #facfcf;
    }

    .status-other {
        background-color: #f1f1f1;
        color: #666666;
    }

    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 24px 16px;
        }

        .revenue-card {
            padding: 24px 20px;
        }
    }
</style>
@endpush
@endsection