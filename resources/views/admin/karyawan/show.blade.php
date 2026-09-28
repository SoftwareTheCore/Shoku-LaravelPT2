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
                        <i class="bi bi-person me-2"></i>
                        Detail Karyawan
                    </h5>

                </div>


                <div class="card-body p-4">

                    <div class="mb-4 text-center">

                        <div
                            class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width: 90px; height: 90px;">

                            <i class="bi bi-person-fill fs-1 text-secondary"></i>

                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-4 text-muted">
                            Nama
                        </div>

                        <div class="col-sm-8 fw-semibold">
                            {{ $karyawan->name }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-4 text-muted">
                            Email
                        </div>

                        <div class="col-sm-8">
                            {{ $karyawan->email }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-4 text-muted">
                            Role
                        </div>

                        <div class="col-sm-8">

                            <span class="badge bg-primary">
                                Karyawan
                            </span>

                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-4 text-muted">
                            Bergabung
                        </div>

                        <div class="col-sm-8">
                            {{ $karyawan->created_at->format('d F Y, H:i') }}
                        </div>

                    </div>


                    <div class="row mb-4">

                        <div class="col-sm-4 text-muted">
                            Terakhir Diubah
                        </div>

                        <div class="col-sm-8">
                            {{ $karyawan->updated_at->format('d F Y, H:i') }}
                        </div>

                    </div>


                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.karyawan.index') }}"
                           class="btn btn-secondary">

                            Kembali

                        </a>

                        <a href="{{ route('admin.karyawan.edit', $karyawan) }}"
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