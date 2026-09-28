@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="mb-4">

        <a href="{{ route('admin.meja.index') }}"
           class="text-decoration-none">

            <i class="bi bi-arrow-left"></i>
            Kembali ke Data Meja

        </a>

    </div>


    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-dark text-white py-3">

                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>
                        Tambah Meja
                    </h5>

                </div>


                <div class="card-body p-4">

                    <form action="{{ route('admin.meja.store') }}"
                          method="POST">

                        @csrf


                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nomor Meja
                            </label>

                            <input
                                type="text"
                                name="table_number"
                                class="form-control @error('table_number') is-invalid @enderror"
                                value="{{ old('table_number') }}"
                                placeholder="Contoh: M-01"
                                required
                            >

                            @error('table_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Kapasitas
                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    name="capacity"
                                    class="form-control @error('capacity') is-invalid @enderror"
                                    value="{{ old('capacity') }}"
                                    min="1"
                                    max="50"
                                    placeholder="Contoh: 4"
                                    required
                                >

                                <span class="input-group-text">
                                    Orang
                                </span>

                            </div>

                            @error('capacity')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    -- Pilih Status --
                                </option>

                                <option value="available"
                                    {{ old('status') === 'available' ? 'selected' : '' }}>
                                    Available
                                </option>

                                <option value="reserved"
                                    {{ old('status') === 'reserved' ? 'selected' : '' }}>
                                    Reserved
                                </option>

                                <option value="occupied"
                                    {{ old('status') === 'occupied' ? 'selected' : '' }}>
                                    Occupied
                                </option>

                                <option value="cleaning"
                                    {{ old('status') === 'cleaning' ? 'selected' : '' }}>
                                    Cleaning
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('admin.meja.index') }}"
                               class="btn btn-secondary">

                                Batal

                            </a>

                            <button type="submit"
                                    class="btn btn-shque">

                                <i class="bi bi-save me-1"></i>
                                Simpan Meja

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection