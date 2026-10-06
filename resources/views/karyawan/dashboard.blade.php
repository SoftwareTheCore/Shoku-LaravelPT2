@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                Dashboard Karyawan
            </h2>

            <p class="text-muted">
                Kelola pesanan, booking, dan stok menu Shoku.
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

    <div class="alert alert-primary">
        Anda login sebagai <strong>Karyawan</strong>.
    </div>

</div>

@endsection