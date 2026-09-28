@extends('layouts.app', ['title' => 'Menu - Shque'])

@section('content')

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Menu
            </h2>

            <p class="text-muted mb-0">
                Kelola daftar menu makanan dan minuman Shque.
            </p>
        </div>

        <a href="{{ route('admin.menus.create') }}"
           class="btn btn-shque">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Menu
        </a>

    </div>

    {{-- Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    {{-- Table --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>
                            <th width="70">No</th>
                            <th width="100">Foto</th>
                            <th>Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($menus as $menu)

                            <tr>

                                <td>
                                    {{ $menus->firstItem() + $loop->index }}
                                </td>

                                <td>

                                    @if ($menu->image)

                                        <img
                                            src="{{ asset('storage/' . $menu->image) }}"
                                            alt="{{ $menu->name }}"
                                            width="70"
                                            height="70"
                                            class="rounded object-fit-cover"
                                        >

                                    @else

                                        <div
                                            class="bg-light rounded d-flex align-items-center justify-content-center"
                                            style="width:70px;height:70px;"
                                        >
                                            <i class="bi bi-image text-muted fs-4"></i>
                                        </div>

                                    @endif

                                </td>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $menu->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ Str::limit($menu->description, 50) }}
                                    </small>

                                </td>

                                <td>
                                    <span class="badge text-bg-secondary">
                                        {{ $menu->category->name }}
                                    </span>
                                </td>

                                <td>
                                    <span class="fw-semibold">
                                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    {{ $menu->stock }}
                                </td>

                                <td>

                                    @if ($menu->is_available && $menu->stock > 0)

                                        <span class="badge text-bg-success">
                                            Tersedia
                                        </span>

                                    @else

                                        <span class="badge text-bg-danger">
                                            Tidak tersedia
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <a
                                            href="{{ route('admin.menus.show', $menu) }}"
                                            class="btn btn-sm btn-info text-white"
                                            title="Detail"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a
                                            href="{{ route('admin.menus.edit', $menu) }}"
                                            class="btn btn-sm btn-warning"
                                            title="Edit"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteMenuModal"
                                            data-delete-url="{{ route('admin.menus.destroy', $menu) }}"
                                            data-menu-name="{{ $menu->name }}"
                                            aria-label="Hapus menu {{ $menu->name }}"
                                            title="Hapus"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5">

                                    <i class="bi bi-egg-fried fs-1 text-muted"></i>

                                    <p class="text-muted mt-3 mb-0">
                                        Belum ada menu.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="modal fade" id="deleteMenuModal" tabindex="-1" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body px-4 pt-2 pb-4 text-center">
                    <div class="delete-menu-icon mb-3">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="deleteMenuModalLabel">Hapus menu?</h5>
                    <p class="text-muted mb-0">
                        Menu <strong class="text-dark" data-delete-menu-name></strong> akan dihapus secara permanen.
                    </p>
                </div>

                <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteMenuForm" method="POST">
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
        {{ $menus->links() }}
    </div>

</div>

@push('styles')
    <style>
        .delete-menu-icon {
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

        #deleteMenuForm {
            margin: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const deleteMenuModal = document.getElementById('deleteMenuModal');

        deleteMenuModal.addEventListener('show.bs.modal', (event) => {
            const trigger = event.relatedTarget;
            const deleteForm = deleteMenuModal.querySelector('#deleteMenuForm');
            const menuName = deleteMenuModal.querySelector('[data-delete-menu-name]');

            deleteForm.action = trigger.getAttribute('data-delete-url');
            menuName.textContent = trigger.getAttribute('data-menu-name');
        });
    </script>
@endpush

@endsection