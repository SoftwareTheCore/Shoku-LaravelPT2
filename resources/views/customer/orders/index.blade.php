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
                                        <div>{{ $item->menu_name }} <span class="text-muted">Ã— {{ $item->quantity }}</span></div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                @if(strtolower($order->status) === 'completed')
                                    <span class="status-badge status-confirmed">Diterima</span>
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


@endsection
