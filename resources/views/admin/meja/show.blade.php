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
                        <i class="bi bi-grid-3x3-gap me-2"></i>
                        Detail Meja
                    </h5>

                </div>


                <div class="card-body p-4">

                    <div class="text-center mb-4">

                        <div
                            class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 90px; height: 90px;"
                        >

                            <i class="bi bi-grid-3x3-gap fs-1 text-secondary"></i>

                        </div>

                        <h4 class="fw-bold mt-3 mb-1">
                            {{ $meja->table_number }}
                        </h4>

                        <p class="text-muted mb-0">
                            Meja Restoran Shoku
                        </p>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Nomor Meja
                        </div>

                        <div class="col-sm-7 fw-semibold">
                            {{ $meja->table_number }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Kapasitas
                        </div>

                        <div class="col-sm-7">
                            {{ $meja->capacity }} orang
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Status
                        </div>

                        <div class="col-sm-7">

                            @if ($meja->status === 'available')

                                <span class="badge bg-success">
                                    Available
                                </span>

                            @elseif ($meja->status === 'reserved')

                                <span class="badge bg-warning text-dark">
                                    Reserved
                                </span>

                            @elseif ($meja->status === 'occupied')

                                <span class="badge bg-danger">
                                    Occupied
                                </span>

                            @elseif ($meja->status === 'cleaning')

                                <span class="badge bg-secondary">
                                    Cleaning
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="row mb-4">

                        <div class="col-sm-5 text-muted">
                            Dibuat
                        </div>

                        <div class="col-sm-7">
                            {{ $meja->created_at->format('d F Y, H:i') }}
                        </div>

                    </div>


                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.meja.index') }}"
                           class="btn btn-secondary">

                            Kembali

                        </a>

                        <a href="{{ route('admin.meja.edit', $meja) }}"
                           class="btn btn-warning">

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