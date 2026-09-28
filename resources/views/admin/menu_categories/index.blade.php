@extends('layouts.app', ['title' => 'Kategori Menu - Shque'])

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Kategori Menu
            </h2>

            <p class="text-muted mb-0">
                Kelola kategori menu restoran Shque.
            </p>
        </div>

        <a href="{{ route('admin.menu-categories.create') }}"
           class="btn btn-shque">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Kategori
        </a>

    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">
                        <tr>
                            <th width="80">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th width="180">Dibuat</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($categories as $category)

                            <tr>

                                <td>
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <span class="fw-semibold">
                                        {{ $category->name }}
                                    </span>
                                </td>

                                <td>
                                    @if ($category->description)
                                        {{ Str::limit($category->description, 80) }}
                                    @else
                                        <span class="text-muted">
                                            Tidak ada deskripsi
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $category->created_at->format('d M Y H:i') }}
                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <a href="{{ route('admin.menu-categories.edit', $category) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteCategoryModal"
                                            data-delete-url="{{ route('admin.menu-categories.destroy', $category) }}"
                                            data-category-name="{{ $category->name }}"
                                            aria-label="Hapus kategori {{ $category->name }}"
                                            title="Hapus kategori"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="text-center py-5">

                                    <i class="bi bi-inbox fs-1 text-muted"></i>

                                    <p class="text-muted mt-3 mb-0">
                                        Belum ada kategori menu.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body px-4 pt-2 pb-4 text-center">
                    <div class="delete-category-icon mb-3">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="deleteCategoryModalLabel">Hapus kategori?</h5>
                    <p class="text-muted mb-0">
                        Kategori <strong class="text-dark" data-delete-category-name></strong> akan dihapus secara permanen.
                    </p>
                </div>

                <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteCategoryForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash3 me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $categories->links() }}
    </div>

</div>

@push('styles')
    <style>
        .delete-category-icon {
            display: grid;
            width: 56px;
            height: 56px;
            margin-inline: auto;
            place-items: center;
            border-radius: 50%;
            background: #fff0ed;
            color: #c0392b;
            font-size: 1.4rem;
        }

        #deleteCategoryForm {
            margin: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const deleteCategoryModal = document.getElementById('deleteCategoryModal');

        deleteCategoryModal.addEventListener('show.bs.modal', (event) => {
            const trigger = event.relatedTarget;
            const deleteForm = deleteCategoryModal.querySelector('#deleteCategoryForm');
            const categoryName = deleteCategoryModal.querySelector('[data-delete-category-name]');

            deleteForm.action = trigger.getAttribute('data-delete-url');
            categoryName.textContent = trigger.getAttribute('data-category-name');
        });
    </script>
@endpush

@endsection