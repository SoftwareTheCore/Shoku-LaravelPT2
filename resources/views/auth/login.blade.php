@extends('layouts.app')

@section('content')
<div class="auth-wrapper py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                <div class="auth-card">
                    <div class="auth-card__header text-center">
                        <h1 class="auth-card__title">Masuk ke Shoku</h1>
                        <p class="auth-card__subtitle">Silakan masukkan email dan password untuk melanjutkan reservasi atau mengelola pesanan.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
                            <div class="fw-semibold mb-1">Periksa kembali data yang dimasukkan:</div>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="auth-form">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label auth-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text auth-input-icon">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input
                                    type="email"
                                    class="form-control auth-input"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    required
                                    autofocus
                                    autocomplete="email"
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label auth-label">Password</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text auth-input-icon">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input
                                    type="password"
                                    class="form-control auth-input"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    required
                                    autocomplete="current-password"
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-shoku w-100 py-2 auth-btn-submit">
                            Masuk
                        </button>
                    </form>

                    <div class="auth-card__footer text-center mt-4 pt-3 border-top">
                        <a href="{{ route('register') }}" class="auth-link ms-1 small fw-semibold">
                            Daftar sebagai Customer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 140px);
        display: flex;
        align-items: center;
        background: #fbfbfb;
    }

    .auth-card {
        background: #ffffff;
        border: 1px solid #ede8e3;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        padding: 36px 32px;
    }

    .auth-card__header {
        margin-bottom: 28px;
    }

    .auth-card__title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 8px;
        letter-spacing: -0.02em;
    }

    .auth-card__subtitle {
        font-size: 0.9rem;
        color: #6c757d;
        line-height: 1.45;
        margin-bottom: 0;
    }

    .auth-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #343a40;
        margin-bottom: 6px;
    }

    .auth-input-icon {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        padding-left: 14px;
        padding-right: 14px;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    .auth-input {
        border-color: #dee2e6;
        font-size: 0.95rem;
        padding: 10px 14px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .auth-input:focus {
        border-color: var(--shoku-primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 82, 50, 0.2);
    }

    .auth-btn-submit {
        border-radius: 8px;
        font-size: 0.95rem;
        transition: background-color 0.15s ease, border-color 0.15s ease;
    }

    .auth-link {
        color: var(--shoku-primary-dark);
        text-decoration: none;
    }

    .auth-link:hover {
        text-decoration: underline;
        color: var(--shoku-primary);
    }

    .auth-card__footer {
        border-color: #f1f1f1 !important;
    }

    @media (max-width: 575.98px) {
        .auth-card {
            padding: 26px 20px;
        }

        .auth-card__title {
            font-size: 1.4rem;
        }
    }
</style>
@endpush
@endsection
