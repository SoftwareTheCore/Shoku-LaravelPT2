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
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Karyawan
                    </h5>

                </div>


                <div class="card-body p-4">

                    <form
                        action="{{ route('admin.karyawan.update', $karyawan) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Nama --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Karyawan
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $karyawan->name) }}"
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
                                value="{{ old('email', $karyawan->email) }}"
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
                                Password Baru
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak ingin mengubah password"
                            >

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                Password minimal 8 karakter.
                            </small>

                        </div>


                        {{-- Confirm Password --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Konfirmasi Password Baru
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password baru"
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
                                Role tidak dapat diubah melalui halaman ini.
                            </small>

                        </div>


                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('admin.karyawan.index') }}"
                               class="btn btn-secondary">

                                Batal

                            </a>

                            <button type="submit"
                                    class="btn btn-shoku">

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