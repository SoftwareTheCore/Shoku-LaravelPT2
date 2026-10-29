@extends('layouts.app')

@section('content')
<div class="auth-page-container">
    <div class="auth-visual-panel">
        <img
            src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=1400&q=85"
            alt="Sajian sushi khas Jepang"
            class="auth-visual-image"
        >
        <div class="auth-visual-overlay"></div>
        <a href="{{ route('home') }}" class="auth-back-link">
            <i class="bi bi-arrow-left"></i>
            Kembali ke beranda
        </a>
        {{-- <div class="auth-visual-copy">
            <span class="auth-visual-kicker">Shoku Japanese Resto</span>
            <h2>Selamat datang kembali.</h2>
            <p>Kelola pengalaman bersantap dan reservasi Anda dalam satu ruang.</p>
        </div> --}}
    </div>
    <div class="auth-card-wrapper">
        <div class="auth-card">
            {{-- Brand Logo & Header --}}
            <div class="auth-card__header text-center">
                <a href="{{ route('home') }}" class="d-inline-block mb-3 text-decoration-none">
                    <img src="{{ route('brand.logo') }}" alt="Shoku Logo" class="auth-brand-logo">
                </a>
                <h1 class="auth-card__title">
                    Portal Login Shoku
                </h1>
                <p class="auth-card__subtitle">
                    Sistem Manajemen Login Shoku
                </p>
            </div>

            {{-- Alerts / Feedback --}}
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3 py-2 px-3 small rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3 py-2 px-3 small rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-3 py-2 px-3 small rounded-3" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label auth-input-label">EMAIL</label>
                    <div class="auth-field-group">
                        <span class="auth-field-icon">
                            <i class="bi bi-person"></i>
                        </span>
                        <input
                            type="email"
                            class="form-control auth-input-field"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="cth: nama@email.com"
                            required
                            autofocus
                            autocomplete="email"
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label auth-input-label">KATA SANDI</label>
                    <div class="auth-field-group">
                        <span class="auth-field-icon">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            type="password"
                            class="form-control auth-input-field"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            required
                            autocomplete="current-password"
                        >
                        <button
                            type="button"
                            class="auth-toggle-pwd"
                            id="togglePassword"
                            aria-label="Tampilkan atau sembunyikan kata sandi"
                        >
                            <i class="bi bi-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn auth-btn-cta w-100">
                    Masuk ke Shoku <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

            {{-- Footer Switch Link --}}
            <div class="text-center mt-3 mb-4">
                <span class="text-muted small">Daftar Sebagai Costumer</span>
                <a href="{{ route('register') }}" class="auth-switch-link small fw-semibold ms-1">
                    Daftar di sini
                </a>
            </div>

            {{-- Card Sub-footer --}}
            <div class="auth-card__footer text-center">
                <div class="auth-version-text">Shoku Dining v1.0.3</div>
                <div class="auth-copyright-text">
                    &copy; {{ date('Y') }} Shoku Dining Portal &bull; <a href="{{ route('home') }}" class="text-decoration-none text-muted">Bantuan / Support</a>
                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && icon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                icon.classList.toggle('bi-eye', !isPassword);
                icon.classList.toggle('bi-eye-slash', isPassword);
            });
        }
    });
</script>
@endpush
@endsection
