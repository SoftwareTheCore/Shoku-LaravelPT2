@extends('layouts.app', ['title' => 'Histori Order - Shque'])

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Histori Order Customer</h2>
        <p class="text-muted mb-0">Konfirmasi penyelesaian order, pantau pemasukan, dan lihat semua order customer.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <section class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
                <div>
                    <h4 class="fw-bold mb-1">Pemasukan</h4>
                    <p class="text-muted mb-0">Dihitung dari order yang ditandai selesai pada periode terpilih.</p>
                </div>
                <span class="badge text-bg-success fs-6">{{ $periodLabel }}</span>
            </div>

            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 align-items-end mb-4">
                <div class="col-sm-4 col-lg-3">
                    <label for="period" class="form-label">Periode</label>
                    <select name="period" id="period" class="form-select">
                        <option value="day" @selected($period === 'day')>Harian</option>
                        <option value="week" @selected($period === 'week')>Mingguan</option>
                        <option value="month" @selected($period === 'month')>Bulanan</option>
                    </select>
                </div>
                <div class="col-sm-4 col-lg-3">
                    <label for="date" class="form-label">Tanggal acuan</label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" required>
                </div>
                <div class="col-sm-4 col-lg-2">
                    <button type="submit" class="btn btn-outline-dark w-100">
                        <i class="bi bi-funnel me-1"></i>Tampilkan
                    </button>
                </div>
            </form>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="rounded bg-light p-3 h-100">
                        <div class="text-muted small">Total pemasukan</div>
                        <div class="fs-3 fw-bold text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded bg-light p-3 h-100">
                        <div class="text-muted small">Order selesai</div>
                        <div class="fs-3 fw-bold">{{ number_format($orderCount, 0, ',', '.') }} order</div>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mt-4 mb-3">Order selesai pada periode ini</h5>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Waktu selesai</th>
                            <th class="text-end">Pemasukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($completedOrders as $completedOrder)
                            <tr>
                                <td>#{{ $completedOrder->id }}</td>
                                <td>{{ $completedOrder->user->name }}</td>
                                <td>{{ $completedOrder->completed_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">Rp {{ number_format($completedOrder->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Belum ada order selesai pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($completedOrders->hasPages())
                <div class="mt-3">{{ $completedOrders->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </section>

    <h4 class="fw-bold mb-3">Semua Order</h4>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Reservasi</th>
                        <th>Menu</th>
                        <th class="text-end">Total</th>
                        <th>Status</th>
                        <th style="min-width: 240px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                <div class="fw-semibold">#{{ $order->id }}</div>
                                <small class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>
                            <td>
                                <div>Meja {{ $order->reservation->table->table_number }}</div>
                                <small class="text-muted">
                                    {{ $order->reservation->reservation_date->format('d/m/Y') }}
                                    {{ substr($order->reservation->reservation_time, 0, 5) }}
                                </small>
                            </td>
                            <td>
                                @foreach ($order->items as $item)
                                    <div>{{ $item->menu_name }} <span class="text-muted">× {{ $item->quantity }}</span></div>
                                @endforeach
                            </td>
                            <td class="text-end fw-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $order->status === 'pending' ? 'bg-warning text-dark' : ($order->status === 'completed' ? 'bg-success' : 'bg-secondary') }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                                @if ($order->completed_at)
                                    <small class="d-block text-muted mt-1">{{ $order->completed_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </td>
                            <td>
                                @if (in_array($order->status, ['pending', 'preparing'], true))
                                    <form action="{{ route('admin.orders.complete', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label for="admin-note-{{ $order->id }}" class="form-label small mb-1">Pesan untuk customer</label>
                                        <textarea
                                            id="admin-note-{{ $order->id }}"
                                            name="admin_note"
                                            class="form-control form-control-sm mb-2"
                                            rows="2"
                                            maxlength="1000"
                                            placeholder="Contoh: Pesanan telah selesai dan siap diambil."
                                        ></textarea>
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle me-1"></i>Konfirmasi Selesai
                                        </button>
                                    </form>
                                @elseif ($order->admin_note)
                                    <small>{{ $order->admin_note }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">Belum ada order customer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($orders->hasPages())
        <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
