@extends('layouts.app')

@section('content')

<div class="reservation-detail-page container py-5">

    <div class="mb-4">

        <a
            href="{{ route('customer.reservations.index') }}"
            class="reservation-back text-decoration-none"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Reservasi
        </a>

    </div>


    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card reservation-detail-card border-0">

                <div class="reservation-detail-header">

                    <h5 class="mb-0">
                        <i class="bi bi-calendar-check me-2"></i>Detail reservasi
                    </h5>
                    <span>#RES-{{ $reservation->id }}</span>

                </div>


                <div class="card-body p-4">

                    <div class="text-center mb-4">

                        <div class="reservation-detail-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>

                        <h3 class="fw-bold mt-3 mb-1">
                            Meja {{ $reservation->table->table_number }}
                        </h3>
                        <p class="text-muted mb-0">Informasi kunjungan Anda di Shoku</p>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 reservation-detail-label">
                            Tanggal
                        </div>

                        <div class="col-sm-7 reservation-detail-value fw-semibold">
                            {{ $reservation->reservation_date->format('d F Y') }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-sm-5 reservation-detail-label">
                            Jam
                        </div>

                        <div class="col-sm-7 reservation-detail-value">
                            {{ substr($reservation->reservation_time, 0, 5) }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 reservation-detail-label">
                            Meja
                        </div>

                        <div class="col-sm-7 reservation-detail-value">
                            {{ $reservation->table->table_number }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 reservation-detail-label">
                            Kapasitas Meja
                        </div>

                        <div class="col-sm-7 reservation-detail-value">
                            {{ $reservation->table->capacity }} orang
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 reservation-detail-label">
                            Jumlah Tamu
                        </div>

                        <div class="col-sm-7 reservation-detail-value">
                            {{ $reservation->guest_count }} orang
                        </div>

                    </div>

                    @if (in_array($reservation->status, ['pending', 'confirmed', 'checked_in'], true))
                        <div class="text-center mt-4">
                            {{-- ini kenapa ada disini bjir apa karena gw? --}}
                            {{-- <a
                                href="{{ route('customer.orders.create', ['reservation' => $reservation->id]) }}"
                                class="btn btn-reservation-primary"
                            >
                                <i class="bi bi-bag-plus me-1"></i>Pesan untuk Reservasi Ini
                            </a> --}}
                        </div>
                    @endif


                    <div class="row mb-3">

                        <div class="col-sm-5 reservation-detail-label">
                            Status
                        </div>

                        <div class="col-sm-7 reservation-detail-value">

                            @if ($reservation->status === 'pending')

                                <span class="reservation-status status-pending">
                                    Pending
                                </span>

                            @elseif ($reservation->status === 'confirmed')

                                <span class="reservation-status status-confirmed">
                                    Reserved
                                </span>

                            @elseif ($reservation->status === 'checked_in')

                                <span class="reservation-status status-info">
                                    Checked In
                                </span>

                            @elseif ($reservation->status === 'completed')

                                <span class="reservation-status status-success">
                                    Completed
                                </span>

                            @elseif ($reservation->status === 'cancelled')

                                <span class="reservation-status status-danger">
                                    Cancelled
                                </span>

                            @elseif ($reservation->status === 'no_show')

                                <span class="reservation-status status-muted">
                                    No Show
                                </span>

                            @endif

                        </div>

                    </div>


                    @if ($reservation->notes)

                        <div class="row mb-4">

                            <div class="col-sm-5 reservation-detail-label">
                                Catatan
                            </div>

                            <div class="col-sm-7 reservation-detail-value">
                                {{ $reservation->notes }}
                            </div>

                        </div>

                    @endif


                    @if (in_array($reservation->status, [
                        'pending',
                        'confirmed'
                    ]))

                        <div class="d-flex justify-content-end">

                            <button
                                type="button"
                                class="btn btn-outline-danger reservation-cancel"
                                data-bs-toggle="modal"
                                data-bs-target="#cancelReservationModal"
                            >
                                <i class="bi bi-x-circle me-1"></i>
                                Batalkan Reservasi
                            </button>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@if (in_array($reservation->status, ['pending', 'confirmed']))
    <div
        class="modal fade"
        id="cancelReservationModal"
        tabindex="-1"
        aria-labelledby="cancelReservationModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <button
                        type="button"
                        class="btn-close ms-auto"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"
                    ></button>
                </div>

                <div class="modal-body px-4 pt-2 pb-4 text-center">
                    <div class="delete-icon-wrapper mb-3 text-danger">
                        <i class="bi bi-exclamation-circle fs-1"></i>
                    </div>

                    <h5 class="fw-bold mb-2" id="cancelReservationModalLabel">
                        Batalkan reservasi?
                    </h5>

                    <p class="text-muted small mb-0">
                        Reservasi meja {{ $reservation->table->table_number }}
                        akan dibatalkan.
                    </p>
                </div>

                <div class="modal-footer border-0 justify-content-center gap-2 px-4 pt-0 pb-4">
                    <form
                        action="{{ route('customer.reservations.destroy', $reservation) }}"
                        method="POST"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger rounded-pill px-3">
                            <i class="bi bi-x-circle me-1"></i>
                            Batalkan
                        </button>
                    </form>
                    <button
                        type="button"
                        class="btn btn-light rounded-pill px-3"
                        data-bs-dismiss="modal"
                    >
                        Tidak
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

@push('styles')
<style>
    .reservation-detail-page {
        max-width: 900px;
    }

    .reservation-back {
        color: var(--shoku-primary-dark);
        font-weight: 600;
    }

    .reservation-back:hover,
    .reservation-back:focus-visible {
        color: var(--shoku-primary);
    }

    .reservation-detail-card {
        overflow: hidden;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(123, 41, 29, 0.08);
    }

    .reservation-detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 22px 28px;
        background: var(--shoku-primary);
        color: #ffffff;
    }

    .reservation-detail-header h5 {
        font-size: 1.2rem;
        font-weight: 700;
    }

    .reservation-detail-header span {
        color: rgba(255, 255, 255, 0.86);
        font-size: 0.85rem;
    }

    .reservation-detail-card .card-body {
        padding: 30px !important;
    }

    .reservation-detail-icon {
        width: 58px;
        height: 58px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff1ed;
        color: var(--shoku-primary);
        font-size: 1.7rem;
    }

    .reservation-detail-label,
    .reservation-detail-value {
        padding-top: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1e8e3;
    }

    .reservation-detail-label {
        color: #81766f;
    }

    .reservation-detail-value {
        color: #3d3632;
    }

    .reservation-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .status-pending { background: #fff5dd; color: #976b17; }
    .status-confirmed { background: #eaf8ef; color: #237747; }
    .status-info { background: #e8f5fb; color: #1d6b87; }
    .status-success { background: #eaf8ef; color: #237747; }
    .status-danger { background: #fdeceb; color: #ae3932; }
    .status-muted { background: #f0efee; color: #6d6661; }

    .btn-reservation-primary {
        background: var(--shoku-primary);
        border: 1px solid var(--shoku-primary);
        border-radius: 10px;
        color: #ffffff;
        font-weight: 600;
        padding: 10px 18px;
    }

    .btn-reservation-primary:hover,
    .btn-reservation-primary:focus-visible {
        background: var(--shoku-primary-dark);
        border-color: var(--shoku-primary-dark);
        color: #ffffff;
    }

    .reservation-cancel {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 18px;
    }

    @media (max-width: 575.98px) {
        .reservation-detail-page {
            padding: 28px 16px !important;
        }

        .reservation-detail-header,
        .reservation-detail-card .card-body {
            padding: 22px !important;
        }

        .reservation-detail-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@endsection
