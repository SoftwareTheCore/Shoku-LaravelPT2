@extends('layouts.app', ['title' => 'Laporan Pesanan & Pemasukan - Shoku'])

@php
    $isPemasukanTab = request()->routeIs('admin.orders.pemasukan') || request()->get('tab') === 'pemasukan';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Laporan Pesanan</a></li>
    @if ($isPemasukanTab)
        <li class="breadcrumb-item active" aria-current="page">Pemasukan</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">Daftar Pesanan</li>
    @endif
@endsection

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
                            <th class="pe-4 text-end">Aksi</th>
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
                                    @elseif(strtolower($order->status) === 'preparing')
                                        <span class="status-badge status-other">Diproses</span>
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
                                <td class="pe-4 text-end">
                                    @if (in_array($order->status, ['pending', 'preparing'], true))
                                        <form action="{{ route('admin.orders.complete', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-confirm-order btn-sm" data-confirm="Apakah Anda yakin ingin mengonfirmasi bahwa pesanan ini telah diterima?">
                                                Konfirmasi diterima
                                            </button>
                                        </form>
                                    @elseif ($order->status === 'completed')
                                        <span class="text-success small fw-semibold">Sudah diterima</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
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


@endsection
