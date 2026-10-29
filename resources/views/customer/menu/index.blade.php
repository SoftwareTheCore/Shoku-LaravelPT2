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
                                        @if ($menu->is_available && $menu->stock > 0)
                                            <a href="{{ route('customer.menu.show', $menu) }}" class="btn btn-sm btn-outline-secondary px-3 py-1 rounded-pill">
                                                Detail Menu
                                            </a>
                                        @else
                                            <span class="btn btn-sm btn-outline-secondary px-3 py-1 rounded-pill disabled" aria-disabled="true">
                                                Tidak tersedia
                                            </span>
                                        @endif
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


@endsection
