@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Data Karyawan
            </h2>

            <p class="text-muted mb-0">
                Kelola seluruh data karyawan Shque.
            </p>
        </div>

        <a href="{{ route('admin.karyawan.create') }}"
           class="btn btn-shque">
            <i class="bi bi-person-plus me-1"></i>
            Tambah Karyawan
        </a>
    </div>


    {{-- Success Message --}}
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

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Total Karyawan</div>
                    <div class="h3 fw-bold mb-0">{{ $totalKaryawan }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Aktif</div>
                    <div class="h3 fw-bold text-success mb-0">{{ $karyawanAktif }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Nonaktif</div>
                    <div class="h3 fw-bold text-secondary mb-0">{{ $karyawanNonaktif }}</div>
                </div>
            </div>
        </div>
    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>
                            <th width="70">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th width="230">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($karyawans as $karyawan)

                            <tr>

                                <td>
                                    {{ $karyawans->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $karyawan->name }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $karyawan->email }}
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        Karyawan
                                    </span>
                                </td>

                                <td>
                                    @if ($karyawan->is_active)
                                        <span class="badge rounded-pill bg-success-subtle text-success-emphasis">
                                            <i class="bi bi-check-circle me-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis">
                                            <i class="bi bi-pause-circle me-1"></i> Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $karyawan->created_at->format('d/m/Y') }}
                                </td>

                                <td>

                                    <a href="{{ route('admin.karyawan.show', $karyawan) }}"
                                       class="btn btn-sm btn-info text-white">

                                        <i class="bi bi-eye"></i>
                                        Detail

                                    </a>

                                    <a href="{{ route('admin.karyawan.edit', $karyawan) }}"
                                       class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil"></i>
                                        Edit

                                    </a>

                                    <button type="button"
                                            class="btn btn-sm {{ $karyawan->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#employeeStatusModal"
                                            data-status-url="{{ route('admin.karyawan.status', $karyawan) }}"
                                            data-employee-name="{{ $karyawan->name }}"
                                            data-is-active="{{ $karyawan->is_active ? 0 : 1 }}"
                                            title="{{ $karyawan->is_active ? 'Nonaktifkan akun' : 'Aktifkan akun' }}">
                                        <i class="bi {{ $karyawan->is_active ? 'bi-person-dash' : 'bi-person-check' }}"></i>
                                        {{ $karyawan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>

                                    <button type="button"
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteEmployeeModal"
                                            data-delete-url="{{ route('admin.karyawan.destroy', $karyawan) }}"
                                            data-employee-name="{{ $karyawan->name }}"
                                            aria-label="Hapus karyawan {{ $karyawan->name }}"
                                            title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-5">

                                    <i class="bi bi-people fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada data karyawan.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="modal fade" id="employeeStatusModal" tabindex="-1" aria-labelledby="employeeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body px-4 pt-2 pb-4 text-center">
                    <div class="delete-menu-icon employee-status-icon mb-3">
                        <i class="bi bi-person-dash"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="employeeStatusModalLabel">Ubah status karyawan?</h5>
                    <p class="text-muted mb-0">
                        <strong class="text-dark" data-status-employee-name></strong>
                        <span data-status-description></span>
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form id="employeeStatusForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="is_active" value="" data-status-value>
                        <button type="submit" class="btn btn-danger" data-status-submit>
                            <i class="bi bi-person-dash me-1"></i> Nonaktifkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body px-4 pt-2 pb-4 text-center">
                    <div class="delete-menu-icon mb-3">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <h5 class="fw-bold mb-2" id="deleteEmployeeModalLabel">Hapus karyawan?</h5>
                    <p class="text-muted mb-0">
                        Data <strong class="text-dark" data-delete-employee-name></strong> akan dihapus secara permanen.
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteEmployeeForm" method="POST">
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
    @if ($karyawans->hasPages())

        <div class="mt-4">
            {{ $karyawans->links('pagination::bootstrap-5') }}
        </div>

    @endif

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

        .employee-status-icon.is-activate {
            background: #e9f7ef;
            color: #198754;
        }

        #employeeStatusForm,
        #deleteEmployeeForm {
            margin: 0;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const employeeStatusModal = document.getElementById('employeeStatusModal');
        employeeStatusModal.addEventListener('show.bs.modal', (event) => {
            const trigger = event.relatedTarget;
            const shouldActivate = trigger.getAttribute('data-is-active') === '1';
            const form = employeeStatusModal.querySelector('#employeeStatusForm');
            const submitButton = employeeStatusModal.querySelector('[data-status-submit]');
            const statusIcon = employeeStatusModal.querySelector('.employee-status-icon');

            form.action = trigger.getAttribute('data-status-url');
            form.querySelector('[data-status-value]').value = shouldActivate ? '1' : '0';
            employeeStatusModal.querySelector('[data-status-employee-name]').textContent = trigger.getAttribute('data-employee-name');
            employeeStatusModal.querySelector('[data-status-description]').textContent = shouldActivate
                ? ' akan diaktifkan dan dapat login kembali.'
                : ' akan dinonaktifkan dan tidak dapat login.';
            submitButton.className = `btn ${shouldActivate ? 'btn-success' : 'btn-danger'}`;
            submitButton.innerHTML = `<i class="bi ${shouldActivate ? 'bi-person-check' : 'bi-person-dash'} me-1"></i> ${shouldActivate ? 'Aktifkan' : 'Nonaktifkan'}`;
            statusIcon.classList.toggle('is-activate', shouldActivate);
            statusIcon.innerHTML = `<i class="bi ${shouldActivate ? 'bi-person-check' : 'bi-person-dash'}"></i>`;
        });

        const deleteEmployeeModal = document.getElementById('deleteEmployeeModal');
        deleteEmployeeModal.addEventListener('show.bs.modal', (event) => {
            const trigger = event.relatedTarget;
            deleteEmployeeModal.querySelector('#deleteEmployeeForm').action = trigger.getAttribute('data-delete-url');
            deleteEmployeeModal.querySelector('[data-delete-employee-name]').textContent = trigger.getAttribute('data-employee-name');
        });
    </script>
@endpush

@endsection