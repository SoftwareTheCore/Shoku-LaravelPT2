@extends('layouts.app', ['title' => 'Detail Kategori - Shque'])

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="mb-4">

                <h2 class="fw-bold mb-1">
                    Detail Kategori
                </h2>

                <p class="text-muted">
                    Informasi kategori menu Shque.
                </p>

            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <div class="mb-4">

                        <small class="text-muted">
                            Nama Kategori
                        </small>

                        <h4 class="fw-bold mt-1">
                            {{ $menuCategory->name }}
                        </h4>

                    </div>

                    <div class="mb-4">

                        <small class="text-muted">
                            Deskripsi
                        </small>

                        <p class="mt-1 mb-0">
                            {{ $menuCategory->description ?: 'Tidak ada deskripsi.' }}
                        </p>

                    </div>

                    <div class="mb-4">

                        <small class="text-muted">
                            Dibuat
                        </small>

                        <p class="mt-1 mb-0">
                            {{ $menuCategory->created_at->format('d M Y H:i') }}
                        </p>

                    </div>

                    <div>

                        <small class="text-muted">
                            Terakhir diperbarui
                        </small>

                        <p class="mt-1 mb-0">
                            {{ $menuCategory->updated_at->format('d M Y H:i') }}
                        </p>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">

                        <a
                            href="{{ route('admin.menu-categories.index') }}"
                            class="btn btn-secondary"
                        >
                            Kembali
                        </a>

                        <a
                            href="{{ route('admin.menu-categories.edit', $menuCategory) }}"
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

@endsection