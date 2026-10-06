@extends('layouts.app', ['title' => 'Buat Order - Shoku'])

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('customer.menu.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Menu
        </a>
        <h2 class="fw-bold mt-3 mb-1">Buat Order</h2>
        <p class="text-muted mb-0">Pilih reservasi dan menu yang ingin dipesan.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($reservations->isEmpty())
        <div class="alert alert-warning">
            Anda perlu memiliki reservasi aktif untuk membuat order.
            <a href="{{ route('customer.reservations.create') }}" class="alert-link">Buat reservasi meja</a>.
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.orders.store') }}" method="POST">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <label for="reservation_id" class="form-label fw-semibold">Reservasi Meja</label>
                <select
                    name="reservation_id"
                    id="reservation_id"
                    class="form-select @error('reservation_id') is-invalid @enderror"
                    required
                    {{ $reservations->isEmpty() ? 'disabled' : '' }}
                >
                    <option value="">Pilih reservasi</option>
                    @foreach ($reservations as $reservation)
                        <option
                            value="{{ $reservation->id }}"
                            @selected(old('reservation_id', $selectedReservationId) == $reservation->id)
                        >
                            {{ $reservation->table->table_number }}
                            — {{ $reservation->reservation_date->format('d/m/Y') }}
                            {{ substr($reservation->reservation_time, 0, 5) }}
                            ({{ ucfirst(str_replace('_', ' ', $reservation->status)) }})
                        </option>
                    @endforeach
                </select>
                @error('reservation_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        @forelse ($categories as $category)
            <section class="mb-4">
                <h4 class="fw-bold mb-3">{{ $category->name }}</h4>
                <div class="row g-3">
                    @foreach ($category->menus as $menu)
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ $menu->name }}</h5>
                                            @if ($menu->description)
                                                <p class="small text-muted mb-2">{{ $menu->description }}</p>
                                            @endif
                                        </div>
                                        <span class="text-nowrap fw-semibold shoku-orange">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="mt-auto d-flex justify-content-between align-items-center pt-3">
                                        <small class="text-muted">Stok: {{ $menu->stock }}</small>
                                        <div class="input-group input-group-sm" style="width: 120px;">
                                            <label class="input-group-text" for="menu-{{ $menu->id }}">Qty</label>
                                            <input
                                                type="number"
                                                id="menu-{{ $menu->id }}"
                                                name="items[{{ $menu->id }}]"
                                                class="form-control"
                                                min="0"
                                                max="{{ min($menu->stock, 100) }}"
                                                value="{{ old('items.' . $menu->id, $selectedMenuId === $menu->id ? 1 : 0) }}"
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @empty
            <div class="alert alert-info">Belum ada menu yang tersedia untuk dipesan.</div>
        @endforelse

        <div class="d-flex justify-content-end mt-4">
            <button
                type="submit"
                class="btn btn-shoku"
                {{ $reservations->isEmpty() || $categories->isEmpty() ? 'disabled' : '' }}
            >
                <i class="bi bi-bag-check me-1"></i>Buat Order
            </button>
        </div>
    </form>
</div>
@endsection
