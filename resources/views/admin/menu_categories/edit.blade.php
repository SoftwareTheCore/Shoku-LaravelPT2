@extends('layouts.app', ['title' => 'Edit Kategori - Shoku'])

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="mb-4">

                <h2 class="fw-bold mb-1">
                    Edit Kategori Menu
                </h2>

                <p class="text-muted">
                    Perbarui informasi kategori menu.
                </p>

            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <form
                        action="{{ route('admin.menu-categories.update', $menuCategory) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Kategori
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $menuCategory->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
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
                            >{{ old('description', $menuCategory->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('admin.menu-categories.index') }}"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="btn btn-shoku"
                            >
                                <i class="bi bi-save me-1"></i>
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection