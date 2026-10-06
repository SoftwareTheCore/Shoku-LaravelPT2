@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">

                        <h2 class="fw-bold">
                            Login
                        </h2>

                        <p class="text-muted mb-0">
                            Masuk ke sistem Shoku
                        </p>

                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

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
                        action="{{ route('login') }}"
                        method="POST"
                    >

                        @csrf

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
                                placeholder="nama@email.com"
                                required
                                autofocus
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
                                placeholder="Masukkan password"
                                required
                            >

                        </div>

                        <div class="form-check mb-4">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                value="1"
                                id="remember"
                            >

                            <label
                                class="form-check-label"
                                for="remember"
                            >
                                Ingat saya
                            </label>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-shoku w-100 py-2"
                        >
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-4">

                        <span class="text-muted">
                            Belum punya akun?
                        </span>

                        <a
                            href="{{ route('register') }}"
                            class="text-decoration-none"
                        >
                            Daftar sebagai Customer
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection