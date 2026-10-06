@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                Dashboard Customer
            </h2>

            <p class="text-muted">
                Selamat datang di Shque Japanese Restaurant.
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

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h5 class="fw-bold">
                Halo, {{ auth()->user()->name }}!
            </h5>

            <p class="text-muted mb-0">
                Jelajahi menu, buat order untuk reservasi aktif, dan pantau riwayatnya.
            </p>

        </div>

    </div>

</div>

@endsection