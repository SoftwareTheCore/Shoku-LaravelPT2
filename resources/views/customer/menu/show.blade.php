@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="mb-4">

        <a
            href="{{ route('customer.menu.index') }}"
            class="text-decoration-none"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Menu
        </a>

    </div>


    <div class="row g-5 align-items-center">

        <div class="col-lg-6">

            @if ($menu->image)

                <img
                    src="{{ asset('storage/' . $menu->image) }}"
                    class="img-fluid rounded shadow-sm"
                    style="width: 100%; max-height: 450px; object-fit: cover;"
                    alt="{{ $menu->name }}"
                >

            @else

                <div
                    class="bg-light rounded d-flex align-items-center justify-content-center"
                    style="height: 450px;"
                >

                    <i class="bi bi-image fs-1 text-muted"></i>

                </div>

            @endif

        </div>


        <div class="col-lg-6">

            <span class="badge bg-secondary mb-3">
                {{ $menu->category->name }}
            </span>

            <h1 class="fw-bold">
                {{ $menu->name }}
            </h1>

            <h3 class="shoku-orange fw-bold mb-4">
                Rp {{ number_format($menu->price, 0, ',', '.') }}
            </h3>

            <p class="text-muted">
                {{ $menu->description }}
            </p>

            <div class="mb-4">

                <strong>
                    Stok:
                </strong>

                {{ $menu->stock }}

            </div>

            <div class="d-flex flex-wrap gap-2">
                <a
                    href="{{ route('customer.orders.create', ['menu' => $menu->id]) }}"
                    class="btn btn-shoku"
                >
                    <i class="bi bi-bag-plus me-1"></i>
                    Pesan Menu
                </a>

                <a
                    href="{{ route('customer.reservations.create') }}"
                    class="btn btn-outline-secondary"
                >
                    <i class="bi bi-calendar-check me-1"></i>
                    Reservasi Meja
                </a>
            </div>

        </div>

    </div>

</div>

@endsection