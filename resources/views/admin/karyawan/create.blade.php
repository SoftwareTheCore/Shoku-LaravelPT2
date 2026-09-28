@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="mb-4">

        <a href="{{ route('admin.karyawan.index') }}"
           class="text-decoration-none">

            <i class="bi bi-arrow-left"></i>
            Kembali ke Data Karyawan

        </a>

    </div>


    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-dark text-white py-3">

                    <h5 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>
                        Tambah Karyawan
                    </h5>

                </div>


                <div class="card-body p-4">

                    <form action="{{ route('admin.karyawan.store') }}"
                          method="POST">

                        @csrf


                        {{-- Nama --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Karyawan
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama karyawan"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="contoh@shque.test"
                                required
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Password --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 8 karakter"
                                required
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Confirm Password --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password"
                                required
                            >

                        </div>


                        {{-- Role --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Role
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="Karyawan"
                                disabled
                            >

                            <small class="text-muted">
                                Role otomatis diatur sebagai Karyawan.
                            </small>

                        </div>


                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('admin.karyawan.index') }}"
                               class="btn btn-secondary">

                                Batal

                            </a>

                            <button type="submit"
                                    class="btn btn-shque">

                                <i class="bi bi-save me-1"></i>
                                Simpan Karyawan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection