@extends('layouts.app')

@section('content')
<div class="auth-page-container">
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

@push('styles')
<style>
    /* Full height orange backdrop like design */
    .public-navbar {
        display: none !important;
    }

    .app-footer {
        display: none !important;
    }

    body {
        background-color: var(--shoku-primary, #ff5232) !important;
    }

    .auth-page-container {
        min-height: 100vh;
        width: 100%;
        background-color: var(--shoku-primary, #ff5232);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
    }

    .auth-card-wrapper {
        width: 100%;
        max-width: 440px;
    }

    .auth-card {
        background: #ffffff;
        border-radius: 28px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        padding: 44px 38px 36px 38px;
        position: relative;
    }

    .auth-brand-logo {
        height: 64px;
        width: auto;
        object-fit: contain;
    }

    .auth-card__title {
        font-family: inherit;
        font-size: 1.25rem;
        font-weight: 700;
        color: #7b291d;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .auth-kanji {
        font-weight: 600;
        color: #9c3324;
    }

    .auth-card__subtitle {
        font-size: 0.82rem;
        color: #7d726b;
        margin-bottom: 24px;
    }

    .auth-input-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: #756f6b;
        margin-bottom: 6px;
        display: block;
    }

    /* Input Pill Group */
    .auth-field-group {
        position: relative;
        display: flex;
        align-items: center;
        background-color: #fcf8f5;
        border: 1px solid #ebdcd3;
        border-radius: 12px;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .auth-field-group:focus-within {
        border-color: #ff5232;
        box-shadow: 0 0 0 3px rgba(255, 82, 50, 0.15);
        background-color: #ffffff;
    }

    .auth-field-icon {
        color: #968c85;
        padding-left: 14px;
        padding-right: 8px;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
    }

    .auth-input-field {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 10px 10px 10px 4px;
        font-size: 0.88rem;
        color: #333333;
        width: 100%;
    }

    .auth-input-field::placeholder {
        color: #b0a69f;
        font-size: 0.85rem;
    }

    .auth-toggle-pwd {
        border: none;
        background: transparent;
        color: #8c827b;
        padding-right: 14px;
        padding-left: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 1.05rem;
    }

    .auth-toggle-pwd:hover {
        color: #555555;
    }

    /* Submit CTA Button */
    .auth-btn-cta {
        background-color: #ff5232;
        border-color: #ff5232;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 12px 18px;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(255, 82, 50, 0.3);
        transition: transform 0.15s ease, background-color 0.15s ease, box-shadow 0.15s ease;
    }

    .auth-btn-cta:hover,
    .auth-btn-cta:focus {
        background-color: #e54224;
        border-color: #e54224;
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(255, 82, 50, 0.35);
    }

    .auth-switch-link {
        color: #ff5232;
        text-decoration: none;
    }

    .auth-switch-link:hover {
        text-decoration: underline;
        color: #cc3b1e;
    }

    /* Card Footer Info */
    .auth-card__footer {
        padding-top: 14px;
        border-top: 1px solid #f4ece6;
    }

    .auth-version-text {
        font-size: 0.73rem;
        font-weight: 600;
        color: #9c5c4e;
        margin-bottom: 3px;
    }

    .auth-copyright-text {
        font-size: 0.69rem;
        color: #9c948e;
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 32px 22px 24px 22px;
            border-radius: 22px;
        }
    }
</style>
@endpush

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
