@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Data Meja
            </h2>

            <p class="text-muted mb-0">
                Kelola meja yang tersedia di restoran Shque.
            </p>
        </div>

        <a href="{{ route('admin.meja.create') }}"
           class="btn btn-shque">

            <i class="bi bi-plus-circle me-1"></i>
            Tambah Meja

        </a>

    </div>


    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>
                            <th width="70">No</th>
                            <th>Nomor Meja</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th width="230">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($tables as $table)

                            <tr>

                                <td>
                                    {{ $tables->firstItem() + $loop->index }}
                                </td>

                                <td>

                                    <strong>
                                        {{ $table->table_number }}
                                    </strong>

                                </td>

                                <td>
                                    {{ $table->capacity }} orang
                                </td>

                                <td>

                                    @if ($table->status === 'available')

                                        <span class="badge bg-success">
                                            Available
                                        </span>

                                    @elseif ($table->status === 'reserved')

                                        <span class="badge bg-warning text-dark">
                                            Reserved
                                        </span>

                                    @elseif ($table->status === 'occupied')

                                        <span class="badge bg-danger">
                                            Occupied
                                        </span>

                                    @elseif ($table->status === 'cleaning')

                                        <span class="badge bg-secondary">
                                            Cleaning
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $table->created_at->format('d/m/Y') }}
                                </td>

                                <td>

                                    <a href="{{ route('admin.meja.show', $table) }}"
                                       class="btn btn-sm btn-info text-white">

                                        <i class="bi bi-eye"></i>
                                        Detail

                                    </a>

                                    <a href="{{ route('admin.meja.edit', $table) }}"
                                       class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil"></i>
                                        Edit

                                    </a>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteTableModal"
                                        data-delete-url="{{ route('admin.meja.destroy', $table) }}"
                                        data-table-number="{{ $table->table_number }}"
                                        aria-label="Hapus meja {{ $table->table_number }}"
                                        title="Hapus"
                                    >
                                        <i class="bi bi-trash"></i>
                                        Hapus
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <i class="bi bi-grid-3x3-gap fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada data meja.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="modal fade" id="deleteTableModal" tabindex="-1" aria-labelledby="deleteTableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body px-4 pt-2 pb-4 text-center">
                    <div class="delete-table-icon mb-3">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="deleteTableModalLabel">Hapus meja?</h5>
                    <p class="text-muted mb-0">
                        Meja <strong class="text-dark" data-delete-table-number></strong> akan dihapus secara permanen.
                    </p>
                </div>

                <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteTableForm" method="POST">
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


    @if ($tables->hasPages())

        <div class="mt-4">

            {{ $tables->links('pagination::bootstrap-5') }}

        </div>

    @endif

</div>

@push('styles')
    <style>
        .delete-table-icon {
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

        #deleteTableForm {
            margin: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const deleteTableModal = document.getElementById('deleteTableModal');

        deleteTableModal.addEventListener('show.bs.modal', (event) => {
            const trigger = event.relatedTarget;
            const deleteForm = deleteTableModal.querySelector('#deleteTableForm');
            const tableNumber = deleteTableModal.querySelector('[data-delete-table-number]');

            deleteForm.action = trigger.getAttribute('data-delete-url');
            tableNumber.textContent = trigger.getAttribute('data-table-number');
        });
    </script>
@endpush

@endsection