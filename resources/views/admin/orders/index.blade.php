@extends('layouts.app', ['title' => 'Laporan Pesanan & Pemasukan - Shoku'])

@php
    $isPemasukanTab = request()->routeIs('admin.orders.pemasukan') || request()->get('tab') === 'pemasukan';
@endphp

@section('content')
<div class="dashboard-wrapper">

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-shoku-success d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle fs-5"></i>
            <div>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($isPemasukanTab)
        {{-- TAB: Laporan Pemasukan --}}
        <div class="mb-4">
            <h1 class="dashboard-heading mb-3">Pemasukan</h1>
        </div>

        <div class="card p-4 filter-card mb-4">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex flex-wrap align-items-end gap-3">
                <input type="hidden" name="tab" value="pemasukan">

                <div>
                    <label for="period" class="form-label text-uppercase fw-bold text-muted small mb-1" style="font-size: 0.72rem; letter-spacing: 0.05em;">PERIODE</label>
                    <div class="custom-select-wrapper">
                        <select name="period" id="period" class="form-select custom-select-pill">
                            <option value="day" @selected($period === 'day')>Harian</option>
                            <option value="week" @selected($period === 'week')>Mingguan</option>
                            <option value="month" @selected($period === 'month')>Bulanan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <input type="hidden" name="date" value="{{ $date }}">
                    <button type="submit" class="btn btn-outline-filter px-4 py-2">
                        Tampilkan
                    </button>
                </div>
            </form>

            <hr class="my-4 border-light-subtle">

            <div>
                <span class="text-secondary small fw-medium">
                    Total pemasukan periode {{ $period === 'month' ? 'bulanan' : ($period === 'week' ? 'mingguan' : 'harian') }}
                </span>
                <div class="revenue-big-text mt-1">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
            </div>
        </div>

    @else
        {{-- TAB: Laporan Pesanan --}}
        <div class="mb-4">
            <h1 class="dashboard-heading mb-1">Laporan Pesanan</h1>
        </div>

        <div class="card table-card">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 60px;">No</th>
                            <th>ID Menu</th>
                            <th>Tipe</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="pe-4 text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $index => $order)
                            <tr>
                                <td class="ps-4 text-muted">
                                    {{ $orders->firstItem() + $loop->index }}
                                </td>
                                <td class="fw-medium text-dark">
                                    #ORD-{{ $order->id }}
                                </td>
                                <td class="text-secondary">
                                    {{ $order->reservation ? 'Dine In (Meja '.$order->reservation->table?->table_number.')' : 'Take Away' }}
                                </td>
                                <td class="text-secondary">
                                    {{ $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : '-' }}
                                </td>
                                <td>
                                    @if(strtolower($order->status) === 'completed')
                                        <span class="status-badge status-confirmed">Completed</span>
                                    @elseif(strtolower($order->status) === 'pending')
                                        <span class="status-badge status-pending">Pending</span>
                                    @elseif(strtolower($order->status) === 'cancelled')
                                        <span class="status-badge status-cancelled">Cancelled</span>
                                    @else
                                        <span class="status-badge status-other">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end fw-semibold text-dark">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-folder-icon mb-3">
                                        <i class="bi bi-folder2-open"></i>
                                    </div>
                                    <p class="text-muted mb-0 empty-text">Belum ada pesanan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($orders->hasPages())
            <div class="mt-4">{{ $orders->links('pagination::bootstrap-5') }}</div>
        @endif

    @endif

</div>

@push('styles')
<style>
    .dashboard-wrapper {
        max-width: 1300px;
        margin: 0 auto;
    }

    .dashboard-heading {
        font-size: 1.75rem;
        font-weight: 700;
        color: #7b291d;
    }

    .alert-shoku-success {
        background-color: #eafaf1;
        border: 1px solid #c7f0d8;
        color: #27884d;
        border-radius: 12px;
        padding: 12px 18px;
        font-size: 0.88rem;
        font-weight: 500;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .custom-select-pill {
        border-radius: 12px;
        padding: 9px 38px 9px 14px;
        font-size: 0.88rem;
        border: 1px solid #dfd7d2;
        background-color: #fdfaf8;
        min-width: 180px;
    }

    .btn-outline-filter {
        border: 1px solid #7b291d;
        color: #7b291d;
        background: #ffffff;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .btn-outline-filter:hover {
        background-color: #7b291d;
        color: #ffffff;
    }

    .revenue-big-text {
        font-size: 2.3rem;
        font-weight: 800;
        color: #7b291d;
        line-height: 1.1;
    }

    /* Table Card */
    .table-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .table-card table thead th {
        background-color: #ff5232;
        color: #ffffff;
        font-size: 0.82rem;
        font-weight: 600;
        padding-top: 14px;
        padding-bottom: 14px;
        border: none;
    }

    .table-card table tbody td {
        padding-top: 15px;
        padding-bottom: 15px;
        font-size: 0.86rem;
        border-bottom: 1px solid #f3ece6;
    }

    .table-card table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Status Pill Badges */
    .status-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.76rem;
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

    /* Empty Folder State */
    .empty-folder-icon {
        width: 64px;
        height: 64px;
        background-color: #fbf1ea;
        color: #b56247;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .empty-text {
        font-size: 0.9rem;
        color: #79716c !important;
    }
</style>
@endpush
@endsection
