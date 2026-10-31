@extends('layouts.app', ['title' => 'Data Meja - Shoku'])

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data Meja</li>
@endsection

@section('content')
<div class="dashboard-wrapper">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="dashboard-heading mb-2">Data Meja</h1>
            <p class="dashboard-subheading mb-0">Kelola meja yang tersedia di restoran Shoku.</p>
        </div>

        <a href="{{ route('admin.meja.create') }}" class="btn btn-dark-pill px-4 py-2">
            <i class="bi bi-plus-lg me-1"></i> Tambah Meja
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
                        <th>Nomor Meja</th>
                        <th>Kapasitas</th>
                        <th class="pe-4 text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tables as $table)
                        <tr>
                            <td class="ps-4 text-muted">
                                {{ $tables->firstItem() + $loop->index }}
                            </td>
                            <td class="fw-semibold text-dark">
                                Meja {{ $table->table_number }}
                            </td>
                            <td class="text-secondary">
                                {{ $table->capacity }} orang
                            </td>
                            <td class="pe-4 text-center">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.meja.edit', $table) }}" class="btn btn-sm btn-outline-secondary px-2 py-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.meja.destroy', $table) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger px-2 py-1"
                                            data-confirm="Meja {{ $table->table_number }} akan dihapus permanen. Lanjutkan?"
                                            title="Hapus"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-folder-icon mb-3">
                                    <i class="bi bi-folder2-open"></i>
                                </div>
                                <p class="text-muted mb-0 empty-text">Belum ada data meja.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($tables->hasPages())
        <div class="mt-4">{{ $tables->links('pagination::bootstrap-5') }}</div>
    @endif

</div>
@endsection
