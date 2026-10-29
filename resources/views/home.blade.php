@extends('layouts.app')

@section('content')
    <section class="home-hero">
        <img
            class="home-hero__image"
            src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=2200&q=85"
            alt="Sajian sushi khas Jepang"
        >
        <div class="home-hero__overlay"></div>

        <div class="container home-hero__content">
            <p class="home-hero__eyebrow">Japanese Dining · Shoku</p>
            <h1>Shoku<br><span>Japanese Resto</span></h1>
            <p class="home-hero__description">
                Temukan kehangatan suasana dan cita rasa Jepang dalam setiap kunjungan.
            </p>
            <a href="{{ route('login') }}" class="btn btn-shoku btn-lg home-hero__button">
                Masuk ke akun <i class="bi bi-arrow-up-right ms-2"></i>
            </a>
        </div>

        <a class="home-hero__scroll" href="#tentang-shoku" aria-label="Lihat tentang Shoku">
            <span></span>
            <span class="visually-hidden">Gulir untuk mengenal Shoku</span>
        </a>
    </section>

    <section class="home-intro" id="tentang-shoku">
        <div class="container home-intro__inner">
            <p class="home-intro__eyebrow">Selamat datang di Shoku</p>
            <div class="home-intro__copy">
                <h2>Ruang untuk menikmati momen, dengan sentuhan Jepang.</h2>
                <p>
                    Shoku menghadirkan pengalaman restoran Jepang yang nyaman untuk
                    dinikmati bersama keluarga, teman, maupun diri sendiri.
                </p>
            </div>
        </div>
    </section>


@endsection
