@extends('layouts.app', ['title' => 'Histori Reservasi - Shoku'])

@section('content')
<div class="reservation-page">

    {{-- Header --}}
    <div class="reservation-hero d-flex justify-content-between align-items-end gap-3 mb-4">
        <div>
            <span class="reservation-eyebrow">Ruang makan Anda</span>
            <h1 class="dashboard-heading mb-2">Histori reservasi</h1>
            <p class="dashboard-subheading mb-0">Lihat jadwal meja dan status reservasi Anda.</p>
        </div>

        <a href="{{ route('customer.reservations.create') }}" class="btn btn-reservation-primary px-4 py-2">
            <i class="bi bi-calendar-plus me-1"></i> Buat Reservasi
        </a>
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
    <div class="card table-card mb-4">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 70px;">No</th>
                        <th>ID Reservasi</th>
                        <th>Meja</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Jumlah Tamu</th>
                        <th>Status</th>
                        <th class="pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $index => $reservation)
                        <tr>
                            <td class="ps-4 text-muted">
                                {{ $reservations->firstItem() + $loop->index }}
                            </td>
                            <td class="fw-medium text-dark">
                                #RES-{{ $reservation->id }}
                            </td>
                            <td class="fw-semibold text-dark">
                                Meja {{ $reservation->table ? $reservation->table->table_number : ($reservation->restaurant_table_id ?? '-') }}
                            </td>
                            <td class="text-secondary">
                                {{ $reservation->reservation_date->format('d/m/Y') }}
                            </td>
                            <td class="text-secondary">
                                {{ substr($reservation->reservation_time, 0, 5) }}
                            </td>
                            <td class="text-dark">
                                {{ $reservation->guest_count }} Orang
                            </td>
                            <td>
                                @if(in_array(strtolower($reservation->status), ['confirmed', 'reserved']))
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
                                <a href="{{ route('customer.reservations.show', $reservation) }}" class="btn btn-sm btn-outline-secondary px-3">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
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
        <div class="mt-4">{{ $reservations->links('pagination::bootstrap-5') }}</div>
    @endif

</div>


@endsection
