@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7 col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">

                        <h2 class="fw-bold">
                            Daftar Customer
                        </h2>

                        <p class="text-muted">
                            Buat akun untuk melakukan reservasi di Shque.
                        </p>

                    </div>

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form
                        action="{{ route('register') }}"
                        method="POST"
                    >

                        @csrf

                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                minlength="8"
                                required
                            >

                            <small class="text-muted">
                                Minimal 8 karakter.
                            </small>

                        </div>

                        <div class="mb-4">

                            <label
                                for="password_confirmation"
                                class="form-label"
                            >
                                Konfirmasi Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                minlength="8"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-shque w-100 py-2"
                        >
                            Daftar
                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <span class="text-muted">
                            Sudah punya akun?
                        </span>

                        <a
                            href="{{ route('login') }}"
                            class="text-decoration-none"
                        >
                            Login

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection 