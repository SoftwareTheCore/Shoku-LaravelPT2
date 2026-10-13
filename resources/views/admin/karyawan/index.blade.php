@extends('layouts.app', ['title' => 'Data Karyawan - Shoku'])

@section('content')
<div class="dashboard-wrapper">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="dashboard-heading mb-2">Data Karyawan</h1>
            <p class="dashboard-subheading mb-0">Kelola data karyawan restaurant.</p>
        </div>

        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-dark-pill px-4 py-2">
            <i class="bi bi-plus-lg me-1"></i> Tambah Karyawan
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
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>No HP</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th class="pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyawans as $karyawan)
                        <tr>
                            <td class="ps-4 text-muted">
                                {{ $karyawans->firstItem() + $loop->index }}
                            </td>
                            <td class="fw-medium text-dark">
                                {{ $karyawan->name }}
                            </td>
                            <td class="text-secondary">
                                Karyawan
                            </td>
                            <td class="text-secondary">
                                {{ $karyawan->email }}
                            </td>
                            <td class="text-secondary">
                                {{ $karyawan->created_at ? $karyawan->created_at->format('Y-m-d H:i:s') : '-' }}
                            </td>
                            <td>
                                @if ($karyawan->is_active)
                                    <span class="status-badge status-confirmed">Aktif</span>
                                @else
                                    <span class="status-badge status-cancelled">Nonaktif</span>
                                @endif
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-inline-flex gap-1">
                                    <form action="{{ route('admin.karyawan.status', $karyawan) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_active" value="{{ $karyawan->is_active ? 0 : 1 }}">
                                        @if ($karyawan->is_active)
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-person-x me-1" aria-hidden="true"></i>Nonaktifkan
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-person-check me-1" aria-hidden="true"></i>Aktifkan
                                            </button>
                                        @endif
                                    </form>
                                    <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteEmployeeModal"
                                            data-delete-url="{{ route('admin.karyawan.destroy', $karyawan) }}"
                                            data-employee-name="{{ $karyawan->name }}"
                                            title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-folder-icon mb-3">
                                    <i class="bi bi-folder2-open"></i>
                                </div>
                                <p class="text-muted mb-0 empty-text">Belum ada data karyawan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($karyawans->hasPages())
        <div class="mt-4">{{ $karyawans->links('pagination::bootstrap-5') }}</div>
    @endif

</div>

{{-- Delete Employee Modal --}}
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body px-4 pt-2 pb-4 text-center">
                <div class="delete-icon-wrapper mb-3 text-danger">
                    <i class="bi bi-trash3 fs-1"></i>
                </div>
                <h5 class="fw-bold mb-2" id="deleteEmployeeModalLabel">Hapus karyawan?</h5>
                <p class="text-muted small mb-0">
                    Data <strong class="text-dark" data-delete-employee-name></strong> akan dihapus secara permanen.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                <form id="deleteEmployeeForm" method="POST">
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

@push('styles')
<style>
    .dashboard-wrapper {
        max-width: 1360px;
        margin: 0 auto;
        padding: 44px 44px 64px 44px;
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

    .btn-dark-pill {
        background-color: #1e1e24;
        color: #ffffff;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        transition: all 0.15s ease;
    }

    .btn-dark-pill:hover {
        background-color: #33333d;
        color: #ffffff;
    }

    .alert-shoku-success {
        background-color: #eafaf1;
        border: 1px solid #c7f0d8;
        color: #27884d;
        border-radius: 16px;
        padding: 16px 24px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 34px;
    }

    /* Table Card */
    .table-card {
        background: #ffffff;
        border: 1px solid #f7ece5;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
    }

    .table-card table thead th {
        background-color: #ff5232;
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 600;
        padding-top: 18px;
        padding-bottom: 18px;
        padding-left: 20px;
        padding-right: 20px;
        border: none;
        letter-spacing: 0.02em;
    }

    .table-card table tbody td {
        padding-top: 18px;
        padding-bottom: 18px;
        padding-left: 20px;
        padding-right: 20px;
        font-size: 0.88rem;
        border-bottom: 1px solid #f3ece6;
    }

    .table-card table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Status Pill Badges */
    .status-badge {
        display: inline-block;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 0.78rem;
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

    /* Empty Folder State */
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteEmployeeModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const deleteUrl = button.getAttribute('data-delete-url');
                const employeeName = button.getAttribute('data-employee-name');

                const form = document.getElementById('deleteEmployeeForm');
                const namePlaceholder = deleteModal.querySelector('[data-delete-employee-name]');

                form.action = deleteUrl;
                namePlaceholder.textContent = employeeName;
            });
        }
    });
</script>
@endpush
@endsection