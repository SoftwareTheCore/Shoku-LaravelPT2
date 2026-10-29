@extends('layouts.app', ['title' => 'Laporan Reservasi - Shoku'])

@section('content')
<div class="dashboard-wrapper">

    {{-- Header --}}
    <div class="dashboard-header mb-4">
        <h1 class="dashboard-heading mb-2">Laporan Reservasi</h1>
        <p class="dashboard-subheading mb-0">Seluruh booking customer dan status terkininya.</p>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-shoku-success d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4 rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card table-card">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 60px;">No</th>
                        <th>ID Pelanggan</th>
                        <th>ID Meja</th>
                        <th>Tanggal Booking</th>
                        <th>Jumlah Orang</th>
                        <th class="text-center">Status</th>
                        <th class="pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="reservation-rows">
                    @forelse ($reservations as $index => $reservation)
                        <tr>
                            <td class="ps-4 text-muted">
                                {{ $reservations->firstItem() + $loop->index }}
                            </td>
                            <td class="fw-medium text-dark">
                                {{ $reservation->user_id }}
                            </td>
                            <td class="fw-medium text-dark">
                                {{ $reservation->table ? $reservation->table->table_number : ($reservation->restaurant_table_id ?? '-') }}
                            </td>
                            <td class="text-secondary">
                                {{ $reservation->created_at ? $reservation->created_at->format('Y-m-d H:i:s') : $reservation->reservation_date->format('Y-m-d') }}
                            </td>
                            <td class="text-dark">
                                {{ $reservation->guest_count }}
                            </td>
                            <td class="text-center">
                                @if(strtolower($reservation->status) === 'confirmed')
                                    <span class="status-badge status-confirmed">Confirmed</span>
                                @elseif(strtolower($reservation->status) === 'pending')
                                    <span class="status-badge status-pending">Pending</span>
                                @elseif(strtolower($reservation->status) === 'cancelled')
                                    <span class="status-badge status-cancelled">Cancelled</span>
                                @else
                                    <span class="status-badge status-other">{{ ucfirst($reservation->status) }}</span>
                                @endif
                            </td>
                            <td class="pe-4 text-center">
                                @if ($reservation->status === 'pending')
                                    <form action="{{ route('admin.reservations.table-status', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-shoku py-1 px-3">
                                            Konfirmasi
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-folder-icon mb-3">
                                    <i class="bi bi-folder2-open"></i>
                                </div>
                                <p class="text-muted mb-0 empty-text">Belum ada data reservasi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($reservations->hasPages())
        <div class="mt-4" id="reservation-pagination">{{ $reservations->links('pagination::bootstrap-5') }}</div>
    @endif

</div>


@endsection
