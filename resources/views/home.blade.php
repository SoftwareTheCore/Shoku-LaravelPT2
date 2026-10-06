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
            <p class="home-hero__eyebrow">Japanese dining · Shoku</p>
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
            <span class="home-intro__mark" aria-hidden="true">食</span>
        </div>
    </section>

    @push('styles')
        <style>
            .home-hero {
                position: relative;
                display: flex;
                min-height: min(760px, 82svh);
                align-items: center;
                overflow: hidden;
                background: #24201d;
                color: #fff;
            }

            .home-hero__image,
            .home-hero__overlay {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
            }

            .home-hero__image {
                object-fit: cover;
                object-position: center 54%;
                animation: home-image-enter 1.2s ease-out both;
            }

            .home-hero__overlay {
                background: linear-gradient(90deg, rgba(20, 18, 16, .82) 0%, rgba(20, 18, 16, .55) 48%, rgba(20, 18, 16, .08) 100%);
            }

            .home-hero__content {
                position: relative;
                z-index: 1;
                padding-top: 84px;
                padding-bottom: 104px;
                animation: home-copy-enter .7s .12s ease-out both;
            }

            .home-hero__eyebrow,
            .home-intro__eyebrow {
                margin-bottom: 22px;
                color: rgb(255, 82, 50);
                font-size: .78rem;
                font-weight: 700;
                letter-spacing: .16em;
                text-transform: uppercase;
            }

            .home-hero h1 {
                margin: 0;
                font-family: Georgia, 'Times New Roman', serif;
                font-size: clamp(3.5rem, 8vw, 6.5rem);
                font-weight: 700;
                line-height: .98;
                letter-spacing: 0;
            }

            .home-hero h1 span {
                color: rgb(255, 82, 50);
                font-size: .56em;
                font-weight: 400;
            }

            .home-hero__description {
                max-width: 430px;
                margin: 28px 0 32px;
                color: rgba(255, 255, 255, .84);
                font-size: 1.1rem;
                line-height: 1.7;
            }

            .home-hero__button {
                padding: 13px 22px;
                font-size: 1rem;
            }

            .home-hero__scroll {
                position: absolute;
                right: max(24px, calc((100vw - 1320px) / 2));
                bottom: 34px;
                z-index: 1;
                display: grid;
                width: 42px;
                height: 42px;
                place-items: center;
                border: 1px solid rgba(255, 255, 255, .7);
                border-radius: 50%;
            }

            .home-hero__scroll span:first-child {
                width: 9px;
                height: 9px;
                border-right: 1px solid #fff;
                border-bottom: 1px solid #fff;
                transform: translateY(-2px) rotate(45deg);
            }

            .home-intro {
                padding: 76px 0 82px;
                background: #f5f2ed;
            }

            .home-intro__inner {
                position: relative;
                display: grid;
                grid-template-columns: minmax(170px, .7fr) 2fr auto;
                align-items: start;
                gap: 32px;
            }

            .home-intro__eyebrow {
                margin: 8px 0 0;
                color: rgb(255, 82, 50);
            }

            .home-intro__copy h2 {
                max-width: 660px;
                margin: 0 0 16px;
                color: #25211f;
                font-family: Georgia, 'Times New Roman', serif;
                font-size: 2.3rem;
                line-height: 1.2;
                letter-spacing: 0;
            }

            .home-intro__copy p {
                max-width: 620px;
                margin: 0;
                color: #625b56;
                font-size: 1rem;
                line-height: 1.8;
            }

            .home-intro__mark {
                color: rgb(255, 82, 50);
                font-family: Georgia, 'Times New Roman', serif;
                font-size: 3rem;
                line-height: 1;
            }

            @keyframes home-image-enter {
                from { opacity: .65; transform: scale(1.035); }
                to { opacity: 1; transform: scale(1); }
            }

            @keyframes home-copy-enter {
                from { opacity: 0; transform: translateY(18px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @media (max-width: 767.98px) {
                .home-hero {
                    min-height: 680px;
                    min-height: min(760px, 82svh);
                }

                .home-hero__image {
                    object-position: 62% center;
                }

                .home-hero__overlay {
                    background: linear-gradient(90deg, rgba(20, 18, 16, .8), rgba(20, 18, 16, .28)), linear-gradient(0deg, rgba(20, 18, 16, .2), transparent 60%);
                }

                .home-hero__content {
                    padding-top: 64px;
                    padding-bottom: 88px;
                }

                .home-hero__description {
                    max-width: 350px;
                    font-size: 1rem;
                }

                .home-intro {
                    padding: 54px 0 60px;
                }

                .home-intro__inner {
                    grid-template-columns: 1fr auto;
                    gap: 18px;
                }

                .home-intro__eyebrow {
                    grid-column: 1 / -1;
                }

                .home-intro__copy h2 {
                    font-size: 1.8rem;
                }

                .home-intro__mark {
                    align-self: end;
                    font-size: 2.2rem;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .home-hero__image,
                .home-hero__content {
                    animation: none;
                }
            }
        </style>
    @endpush
@endsection
