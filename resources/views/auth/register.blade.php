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
            <h2>Pesan meja untuk momen Anda.</h2>
            <p>Buat akun customer dan nikmati pengalaman reservasi yang lebih mudah.</p>
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
                    Daftar Customer
                </h1>
                <p class="auth-card__subtitle">
                    Buat Akun Customer & Reservasi Meja Shoku Dining
                </p>
            </div>

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="alert alert-danger mb-3 py-2 px-3 small rounded-3" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Register --}}
            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label auth-input-label">NAMA LENGKAP</label>
                    <div class="auth-field-group">
                        <span class="auth-field-icon">
                            <i class="bi bi-person"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control auth-input-field"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="cth: Budi Santoso"
                            required
                            autofocus
                            autocomplete="name"
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label auth-input-label">EMAIL</label>
                    <div class="auth-field-group">
                        <span class="auth-field-icon">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input
                            type="email"
                            class="form-control auth-input-field"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="cth: budi@email.com"
                            required
                            autocomplete="email"
                        >
                    </div>
                </div>

                <div class="mb-3">
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
                            minlength="8"
                            placeholder="Minimal 8 karakter"
                            required
                            autocomplete="new-password"
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

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label auth-input-label">KONFIRMASI KATA SANDI</label>
                    <div class="auth-field-group">
                        <span class="auth-field-icon">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            type="password"
                            class="form-control auth-input-field"
                            id="password_confirmation"
                            name="password_confirmation"
                            minlength="8"
                            placeholder="Ulangi kata sandi"
                            required
                            autocomplete="new-password"
                        >
                        <button
                            type="button"
                            class="auth-toggle-pwd"
                            id="togglePasswordConfirmation"
                            aria-label="Tampilkan atau sembunyikan konfirmasi kata sandi"
                        >
                            <i class="bi bi-eye" id="togglePasswordConfirmationIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn auth-btn-cta w-100">
                    Daftar Sekarang <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

            {{-- Footer Switch Link --}}
            <div class="text-center mt-3 mb-4">
                <span class="text-muted small">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="auth-switch-link small fw-semibold ms-1">
                    Masuk di sini
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
        const toggleConfirmationBtn = document.getElementById('togglePasswordConfirmation');
        const confirmationInput = document.getElementById('password_confirmation');
        const confirmationIcon = document.getElementById('togglePasswordConfirmationIcon');

        if (toggleBtn && passwordInput && icon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                icon.classList.toggle('bi-eye', !isPassword);
                icon.classList.toggle('bi-eye-slash', isPassword);
            });
        }

        if (toggleConfirmationBtn && confirmationInput && confirmationIcon) {
            toggleConfirmationBtn.addEventListener('click', function () {
                const isPassword = confirmationInput.getAttribute('type') === 'password';
                confirmationInput.setAttribute('type', isPassword ? 'text' : 'password');
                confirmationIcon.classList.toggle('bi-eye', !isPassword);
                confirmationIcon.classList.toggle('bi-eye-slash', isPassword);
            });
        }
    });
</script>
@endpush
@endsection
