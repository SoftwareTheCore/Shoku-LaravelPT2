@extends('layouts.app', ['title' => 'Order Saya - Shoku'])

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Order Saya</h2>
            <p class="text-muted mb-0">Riwayat pesanan dan reservasi yang terhubung.</p>
        </div>
        <a href="{{ route('customer.orders.create') }}" class="btn btn-shoku">
            <i class="bi bi-plus-lg me-1"></i>Buat Order
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @forelse ($orders as $order)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between gap-3 mb-3">
                    <div>
                        <span class="fw-bold">Order #{{ $order->id }}</span>
                        <span class="text-muted ms-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        <div class="small text-muted mt-1">
                            Reservasi meja {{ $order->reservation->table->table_number }}
                            — {{ $order->reservation->reservation_date->format('d/m/Y') }}
                            {{ substr($order->reservation->reservation_time, 0, 5) }}
                        </div>
                    </div>
                    <span class="badge align-self-start {{ $order->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>

                @if ($order->completed_at)
                    <div class="alert alert-success py-2">
                        <div class="fw-semibold">Pesanan selesai pada {{ $order->completed_at->format('d/m/Y H:i') }}</div>
                        @if ($order->admin_note)
                            <div>{{ $order->admin_note }}</div>
                        @endif
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-2">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->menu_name }}</td>
                                    <td class="text-end">{{ $item->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->line_total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-bag-x fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">Anda belum memiliki order.</p>
            </div>
        </div>
    @endforelse

    @if ($orders->hasPages())
        <div class="mt-4">{{ $orders->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
