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

@push('styles')
<style>
    .reservation-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 48px 32px 64px;
    }

    .dashboard-heading {
        font-size: clamp(1.75rem, 3vw, 2.35rem);
        font-weight: 700;
        color: var(--shoku-primary-dark);
        letter-spacing: -0.01em;
    }

    .dashboard-subheading {
        font-size: 0.94rem;
        color: #746b66;
    }

    .reservation-eyebrow {
        display: block;
        color: var(--shoku-primary-dark);
        font-size: 0.76rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .btn-reservation-primary {
        background-color: var(--shoku-primary);
        border: 1px solid var(--shoku-primary);
        color: #ffffff;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .btn-reservation-primary:hover,
    .btn-reservation-primary:focus-visible {
        background-color: var(--shoku-primary-dark);
        border-color: var(--shoku-primary-dark);
        color: #ffffff;
    }

    .alert-shoku-success {
        background-color: #effaf3;
        border: 1px solid #c7f0d8;
        color: #27884d;
        border-radius: 12px;
        padding: 16px 24px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 28px;
    }

    .table-card {
        background: #ffffff;
        border: 1px solid #f0e2da;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(123, 41, 29, 0.06);
    }

    .table-card table thead th {
        background-color: var(--shoku-primary);
        color: #ffffff;
        font-size: 0.85rem;
        font-weight: 600;
        padding-top: 16px;
        padding-bottom: 16px;
        padding-left: 20px;
        padding-right: 20px;
        border: none;
        letter-spacing: 0.02em;
    }

    .table-card table tbody td {
        padding-top: 16px;
        padding-bottom: 16px;
        padding-left: 20px;
        padding-right: 20px;
        font-size: 0.88rem;
        border-bottom: 1px solid #f3ece6;
    }

    .table-card table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 0.78rem;
        font-weight: 600;
    }

    .status-confirmed {
        background-color: #e5f8ee;
        color: #218751;
        border: 1px solid #c4eed6;
    }

    .status-pending {
        background-color: #fdf5e6;
        color: #b58330;
        border: 1px solid #f9e7c3;
    }

    .status-cancelled {
        background-color: #fdeeee;
        color: #c93b3b;
        border: 1px solid #facfcf;
    }

    .status-other {
        background-color: #f1f1f1;
        color: #666666;
    }

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
        .reservation-page {
            padding: 28px 16px 44px;
        }

        .reservation-hero {
            align-items: flex-start !important;
            flex-direction: column;
        }

        .btn-reservation-primary {
            width: 100%;
        }
    }
</style>
@endpush
@endsection