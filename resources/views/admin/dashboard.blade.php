@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Dashboard Admin
            </h2>

            <p class="text-muted mb-0">
                Selamat datang di sistem manajemen Shque.
            </p>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="btn btn-outline-danger">
                Logout
            </button>
        </form>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Role
                    </small>

                    <h4 class="fw-bold mb-0">
                        Admin
                    </h4>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Sistem
                    </small>

                    <h4 class="fw-bold mb-0">
                        Shque
                    </h4>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small class="text-muted">
                        Status
                    </small>

                    <h4 class="fw-bold text-success mb-0">
                        Aktif
                    </h4>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection