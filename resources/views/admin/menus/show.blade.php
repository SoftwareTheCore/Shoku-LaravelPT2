@extends('layouts.app', ['title' => 'Detail Menu - Shoku'])

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="mb-4">

                <h2 class="fw-bold mb-1">
                    Detail Menu
                </h2>

                <p class="text-muted">
                    Informasi lengkap menu Shoku.
                </p>

            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <div class="row g-4">

                        {{-- Foto --}}
                        <div class="col-md-5">

                            @if ($menu->image)

                                <img
                                    src="{{ asset('storage/' . $menu->image) }}"
                                    alt="{{ $menu->name }}"
                                    class="img-fluid rounded"
                                    style="width:100%; height:320px; object-fit:cover;"
                                >

                            @else

                                <div
                                    class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="height:320px;"
                                >
                                    <i class="bi bi-image fs-1 text-muted"></i>
                                </div>

                            @endif

                        </div>

                        {{-- Detail --}}
                        <div class="col-md-7">

                            <span class="badge text-bg-secondary mb-2">
                                {{ $menu->category->name }}
                            </span>

                            <h2 class="fw-bold">
                                {{ $menu->name }}
                            </h2>

                            <h4 class="text-danger fw-bold mb-3">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </h4>

                            <p class="text-muted">
                                {{ $menu->description ?: 'Tidak ada deskripsi.' }}
                            </p>

                            <hr>

                            <div class="row">

                                <div class="col-6">

                                    <small class="text-muted">
                                        Stok
                                    </small>

                                    <h5 class="fw-bold">
                                        {{ $menu->stock }}
                                    </h5>

                                </div>

                                <div class="col-6">

                                    <small class="text-muted">
                                        Status
                                    </small>

                                    <div class="mt-1">

                                        @if ($menu->is_available && $menu->stock > 0)

                                            <span class="badge text-bg-success">
                                                Tersedia
                                            </span>

                                        @else

                                            <span class="badge text-bg-danger">
                                                Tidak tersedia
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="d-flex gap-2">

                                <a
                                    href="{{ route('admin.menus.index') }}"
                                    class="btn btn-secondary"
                                >
                                    Kembali
                                </a>

                                <a
                                    href="{{ route('admin.menus.edit', $menu) }}"
                                    class="btn btn-warning"
                                >
                                    <i class="bi bi-pencil me-1"></i>
                                    Edit
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection