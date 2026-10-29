@extends('layouts.app', ['title' => 'Data Menu - Shoku'])

@section('content')
<div class="dashboard-wrapper">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="dashboard-heading mb-2">Data Menu</h1>
            <p class="dashboard-subheading mb-0">Kelola daftar menu restaurant.</p>
        </div>

        <a href="{{ route('admin.menus.create') }}" class="btn btn-dark-pill px-4 py-2">
            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
        </a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-shoku-success d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card table-card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 60px;">No</th>
                        <th style="width: 100px;">Foto</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="pe-4 text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menu)
                        <tr>
                            <td class="ps-4 text-muted">
                                {{ $menus->firstItem() + $loop->index }}
                            </td>
                            <td>
                                @if ($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" width="60" height="60" class="rounded-3 object-fit-cover">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $menu->name }}</div>
                                <small class="text-secondary">{{ $menu->category ? $menu->category->name : '' }}</small>
                            </td>
                            <td class="fw-semibold text-dark">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </td>
                            <td>
                                @if ($menu->is_available && $menu->stock > 0)
                                    <span class="status-badge status-confirmed">Tersedia</span>
                                @else
                                    <span class="status-badge status-cancelled">Habis</span>
                                @endif
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteMenuModal"
                                            data-delete-url="{{ route('admin.menus.destroy', $menu) }}"
                                            data-menu-name="{{ $menu->name }}"
                                            title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-folder-icon mb-3">
                                    <i class="bi bi-folder2-open"></i>
                                </div>
                                <p class="text-muted mb-0 empty-text">Belum ada menu.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($menus->hasPages())
        <div class="mt-4">{{ $menus->links('pagination::bootstrap-5') }}</div>
    @endif

</div>

{{-- Delete Menu Modal --}}
<div class="modal fade" id="deleteMenuModal" tabindex="-1" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body px-4 pt-2 pb-4 text-center">
                <div class="delete-icon-wrapper mb-3 text-danger">
                    <i class="bi bi-trash3 fs-1"></i>
                </div>
                <h5 class="fw-bold mb-2" id="deleteMenuModalLabel">Hapus menu?</h5>
                <p class="text-muted small mb-0">
                    Menu <strong class="text-dark" data-delete-menu-name></strong> akan dihapus permanen.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                <form id="deleteMenuForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill px-3">
                        <i class="bi bi-trash3 me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteMenuModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const deleteUrl = button.getAttribute('data-delete-url');
                const menuName = button.getAttribute('data-menu-name');

                const form = document.getElementById('deleteMenuForm');
                const namePlaceholder = deleteModal.querySelector('[data-delete-menu-name]');

                form.action = deleteUrl;
                namePlaceholder.textContent = menuName;
            });
        }
    });
</script>
@endpush
@endsection
