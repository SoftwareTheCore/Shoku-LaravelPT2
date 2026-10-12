@extends('layouts.app', ['title' => 'Menu - Shoku'])

@section('content')
<div class="dashboard-wrapper">

    {{-- Header --}}
    <div class="dashboard-header mb-4">
        <h1 class="dashboard-heading mb-2">Menu Shoku</h1>
        <p class="dashboard-subheading mb-0">Nikmati berbagai pilihan hidangan makanan dan minuman khas Jepang favorit kami.</p>
    </div>

    @forelse ($categories as $category)
        @if ($category->menus->count())
            <div class="menu-category-section mb-5">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <h2 class="category-heading mb-0">{{ $category->name }}</h2>
                    <span class="category-badge">{{ $category->menus->count() }} Pilihan</span>
                </div>
                @if ($category->description)
                    <p class="text-secondary small mb-4" style="max-width: 700px;">{{ $category->description }}</p>
                @endif

                <div class="row g-4">
                    @foreach ($category->menus as $menu)
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="card menu-item-card h-100">
                                @if ($menu->image)
                                    <div class="menu-img-wrapper">
                                        <img src="{{ asset('storage/' . $menu->image) }}" class="menu-item-img" alt="{{ $menu->name }}">
                                    </div>
                                @else
                                    <div class="menu-img-placeholder">
                                        <i class="bi bi-image fs-1 text-muted"></i>
                                    </div>
                                @endif

                                <div class="card-body p-4 d-flex flex-direction-column flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                            <h5 class="menu-item-title mb-0">{{ $menu->name }}</h5>
                                            @if ($menu->is_available && $menu->stock > 0)
                                                <span class="status-badge status-confirmed">Tersedia</span>
                                            @else
                                                <span class="status-badge status-cancelled">Habis</span>
                                            @endif
                                        </div>
                                        <p class="menu-item-desc mb-3">
                                            {{ Str::limit($menu->description, 90) ?: 'Hidangan istimewa dari dapur Shoku.' }}
                                        </p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light-subtle">
                                        <div class="menu-item-price">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </div>
                                        <a href="{{ route('customer.menu.show', $menu) }}" class="btn btn-sm btn-outline-secondary px-3 py-1 rounded-pill">
                                            Detail Menu
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @empty
        <div class="card table-card text-center py-5">
            <div class="empty-folder-icon mb-3">
                <i class="bi bi-folder2-open"></i>
            </div>
            <p class="text-muted mb-0 empty-text">Belum ada menu yang tersedia.</p>
        </div>
    @endforelse

</div>

@push('styles')
<style>
    .dashboard-wrapper {
        max-width: 1360px;
        margin: 0 auto;
        padding: 44px 44px 64px 44px;
    }

    .dashboard-header {
        margin-bottom: 34px;
    }

    .dashboard-heading {
        font-family: inherit;
        font-size: 1.85rem;
        font-weight: 700;
        color: #7b291d;
        letter-spacing: -0.01em;
    }

    .dashboard-subheading {
        font-size: 0.94rem;
        color: #8c827a;
    }

    .category-heading {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2e2621;
    }

    .category-badge {
        background-color: #fcefe9;
        color: #c44d33;
        font-size: 0.76rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .menu-item-card {
        background: #ffffff;
        border: 1px solid #f7ece5;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .menu-item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .menu-img-wrapper {
        height: 200px;
        overflow: hidden;
        background: #fdfaf8;
    }

    .menu-item-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .menu-img-placeholder {
        height: 200px;
        background-color: #fbf5f2;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .menu-item-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #2e2621;
    }

    .menu-item-desc {
        font-size: 0.84rem;
        color: #7d7570;
        line-height: 1.45;
        min-height: 38px;
    }

    .menu-item-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: #ff5232;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 600;
    }

    .status-confirmed {
        background-color: #e5f8ee;
        color: #218751;
        border: 1px solid #c4eed6;
    }

    .status-cancelled {
        background-color: #fdeeee;
        color: #c93b3b;
        border: 1px solid #facfcf;
    }

    .empty-folder-icon {
        width: 64px;
        height: 64px;
        background-color: #fbf1ea;
        color: #b56247;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .empty-text {
        font-size: 0.92rem;
        color: #79716c !important;
    }

    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 24px 16px;
        }
    }
</style>
@endpush
@endsection