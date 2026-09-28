@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold">
            Menu Shque
        </h2>

        <p class="text-muted">
            Nikmati berbagai pilihan makanan Jepang favorit kami.
        </p>

    </div>


    @forelse ($categories as $category)

        @if ($category->menus->count())

            <div class="mb-5">

                <div class="mb-3">

                    <h4 class="fw-bold mb-1">
                        {{ $category->name }}
                    </h4>

                    @if ($category->description)
                        <p class="text-muted">
                            {{ $category->description }}
                        </p>
                    @endif

                </div>


                <div class="row g-4">

                    @foreach ($category->menus as $menu)

                        <div class="col-md-6 col-lg-4">

                            <div class="card h-100 border-0 shadow-sm">

                                @if ($menu->image)

                                    <img
                                        src="{{ asset('storage/' . $menu->image) }}"
                                        class="card-img-top"
                                        style="height: 220px; object-fit: cover;"
                                        alt="{{ $menu->name }}"
                                    >

                                @else

                                    <div
                                        class="bg-light d-flex align-items-center justify-content-center"
                                        style="height: 220px;"
                                    >

                                        <i class="bi bi-image fs-1 text-muted"></i>

                                    </div>

                                @endif


                                <div class="card-body">

                                    <h5 class="fw-bold">
                                        {{ $menu->name }}
                                    </h5>

                                    <p class="text-muted small">
                                        {{ $menu->description }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">

                                        <strong class="shque-orange">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </strong>

                                        <a
                                            href="{{ route('customer.menu.show', $menu) }}"
                                            class="btn btn-sm btn-shque"
                                        >
                                            Detail
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    @empty

        <div class="text-center py-5">

            <h5>
                Menu belum tersedia.
            </h5>

        </div>

    @endforelse

</div>

@endsection