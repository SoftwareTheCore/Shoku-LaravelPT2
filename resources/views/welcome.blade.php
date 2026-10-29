@extends('layouts.app', ['title' => 'Selamat datang - Shoku'])

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5 text-center">
                        <h1 class="h2 fw-bold text-dark mb-3">Selamat datang di Shoku</h1>
                        <p class="lead text-secondary mb-4">
                            Kelola menu, meja, pesanan, dan reservasi restoran dalam satu tempat.
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-shoku px-4">
                            Masuk ke akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
