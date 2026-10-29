@extends('layouts.app', ['title' => 'Kategori Menu - Shoku'])

@section('content')
<div class="dashboard-wrapper">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="dashboard-heading mb-2">Kategori Menu</h1>
            <p class="dashboard-subheading mb-0">Kelola kategori menu hidangan dan minuman restoran Shoku.</p>
        </div>

        <a href="{{ route('admin.menu-categories.create') }}" class="btn btn-dark-pill px-4 py-2">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-shoku-success d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card table-card mb-4">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Dibuat</th>
                        <th class="pe-4 text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="ps-4 text-muted">
                                {{ $categories->firstItem() + $loop->index }}
                            </td>
                            <td class="fw-semibold text-dark">
                                {{ $category->name }}
                            </td>
                            <td class="text-secondary">
                                {{ $category->description ? Str::limit($category->description, 80) : '-' }}
                            </td>
                            <td class="text-secondary">
                                {{ $category->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.menu-categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary px-2 py-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger px-2 py-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteCategoryModal"
                                        data-delete-url="{{ route('admin.menu-categories.destroy', $category) }}"
                                        data-category-name="{{ $category->name }}"
                                        title="Hapus"
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-folder-icon mb-3">
                                    <i class="bi bi-folder2-open"></i>
                                </div>
                                <p class="text-muted mb-0 empty-text">Belum ada kategori menu.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($categories->hasPages())
        <div class="mt-4">{{ $categories->links('pagination::bootstrap-5') }}</div>
    @endif

</div>

{{-- Delete Category Modal --}}
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body px-4 pt-2 pb-4 text-center">
                <div class="delete-icon-wrapper mb-3 text-danger">
                    <i class="bi bi-trash3 fs-1"></i>
                </div>
                <h5 class="fw-bold mb-2" id="deleteCategoryModalLabel">Hapus kategori?</h5>
                <p class="text-muted small mb-0">
                    Kategori <strong class="text-dark" data-delete-category-name></strong> akan dihapus permanen.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                <form id="deleteCategoryForm" method="POST">
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
    document.addEventListener('DOMContentLoaded', () => {
        const deleteModal = document.getElementById('deleteCategoryModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', (event) => {
                const trigger = event.relatedTarget;
                const deleteForm = deleteModal.querySelector('#deleteCategoryForm');
                const categoryName = deleteModal.querySelector('[data-delete-category-name]');

                deleteForm.action = trigger.getAttribute('data-delete-url');
                categoryName.textContent = trigger.getAttribute('data-category-name');
            });
        }
    });
</script>
@endpush
@endsection
