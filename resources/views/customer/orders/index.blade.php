@extends('layouts.app', ['title' => 'Histori Pesanan - Shoku'])

@section('content')
<div class="dashboard-wrapper">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="dashboard-heading mb-2">Histori Pesanan</h1>
            <p class="dashboard-subheading mb-0">Riwayat seluruh pesanan makanan dan minuman Anda di Shoku.</p>
        </div>

        <a href="{{ route('customer.orders.create') }}" class="btn btn-dark-pill px-4 py-2">
            <i class="bi bi-plus-lg me-1"></i> Buat Order
        </a>
    </div>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="alert alert-shoku-success d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card table-card mb-4">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;">No</th>
                        <th>ID Pesanan</th>
                        <th>Reservasi Meja</th>
                        <th>Tanggal Order</th>
                        <th>Item Menu</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $index => $order)
                        <tr>
                            <td class="ps-4 text-muted">{{ $orders->firstItem() + $loop->index }}</td>
                            <td class="fw-medium text-dark">#ORD-{{ $order->id }}</td>
                            <td class="text-secondary">
                                Meja {{ $order->reservation->table?->table_number ?? '-' }}
                                <small class="d-block text-muted">
                                    {{ $order->reservation->reservation_date->format('d/m/Y') }} {{ substr($order->reservation->reservation_time, 0, 5) }}
                                </small>
                            </td>
                            <td class="text-secondary">
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td>
                                <div class="small">
                                    @foreach ($order->items as $item)
                                        <div>{{ $item->menu_name }} <span class="text-muted">× {{ $item->quantity }}</span></div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                @if(strtolower($order->status) === 'completed')
                                    <span class="status-badge status-confirmed">Selesai</span>
                                @elseif(strtolower($order->status) === 'pending')
                                    <span class="status-badge status-pending">Pending</span>
                                @elseif(strtolower($order->status) === 'cancelled')
                                    <span class="status-badge status-cancelled">Dibatalkan</span>
                                @else
                                    <span class="status-badge status-other">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end fw-bold text-dark">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
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

</div>

@push('styles')
<style>
    .dashboard-wrapper {
        max-width: 1360px;
        margin: 0 auto;
        padding: 44px 44px 64px 44px;
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

    .btn-dark-pill {
        background-color: #1e1e24;
        color: #ffffff;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        transition: all 0.15s ease;
    }

    .btn-dark-pill:hover {
        background-color: #33333d;
        color: #ffffff;
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
        font-size: 0.92rem;
        color: #79716c !important;
    }

    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 24px 16px;
        }
    }
</style>
@endpush
@endsection
