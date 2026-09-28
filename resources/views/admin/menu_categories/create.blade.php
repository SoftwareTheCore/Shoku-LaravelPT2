@extends('layouts.app', ['title' => 'Tambah Kategori - Shque'])

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="mb-4">
                <h2 class="fw-bold mb-1">
                    Tambah Kategori Menu
                </h2>

                <p class="text-muted">
                    Tambahkan kategori baru untuk menu restoran.
                </p>
            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <form
                        action="{{ route('admin.menu-categories.store') }}"
                        method="POST"
                    >

                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Kategori
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Contoh: Ramen"
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan deskripsi kategori..."
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Button --}}
                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('admin.menu-categories.index') }}"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="btn btn-shque"
                            >
                                <i class="bi bi-check-lg me-1"></i>
                                Simpan Kategori
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection