@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="mb-4">

        <a
            href="{{ route('customer.reservations.index') }}"
            class="text-decoration-none"
        >
            <i class="bi bi-arrow-left"></i>
            Kembali ke Reservasi
        </a>

    </div>


    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-dark text-white py-3">

                    <h5 class="mb-0">
                        Detail Reservasi
                    </h5>

                </div>


                <div class="card-body p-4">

                    <div class="text-center mb-4">

                        <i class="bi bi-calendar-check fs-1 shoku-orange"></i>

                        <h3 class="fw-bold mt-2">
                            {{ $reservation->table->table_number }}
                        </h3>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Tanggal
                        </div>

                        <div class="col-sm-7 fw-semibold">
                            {{ $reservation->reservation_date->format('d F Y') }}
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Jam
                        </div>

                        <div class="col-sm-7">
                            {{ substr($reservation->reservation_time, 0, 5) }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Meja
                        </div>

                        <div class="col-sm-7">
                            {{ $reservation->table->table_number }}
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Kapasitas Meja
                        </div>

                        <div class="col-sm-7">
                            {{ $reservation->table->capacity }} orang
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Jumlah Tamu
                        </div>

                        <div class="col-sm-7">
                            {{ $reservation->guest_count }} orang
                        </div>

                    </div>

                    @if (in_array($reservation->status, ['pending', 'confirmed', 'checked_in'], true))
                        <div class="text-center mt-4">
                            <a
                                href="{{ route('customer.orders.create', ['reservation' => $reservation->id]) }}"
                                class="btn btn-shoku"
                            >
                                <i class="bi bi-bag-plus me-1"></i>Pesan untuk Reservasi Ini
                            </a>
                        </div>
                    @endif


                    <div class="row mb-3">

                        <div class="col-sm-5 text-muted">
                            Status
                        </div>

                        <div class="col-sm-7">

                            @if ($reservation->status === 'pending')

                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>

                            @elseif ($reservation->status === 'confirmed')

                                <span class="badge bg-primary">
                                    Reserved
                                </span>

                            @elseif ($reservation->status === 'checked_in')

                                <span class="badge bg-info text-dark">
                                    Checked In
                                </span>

                            @elseif ($reservation->status === 'completed')

                                <span class="badge bg-success">
                                    Completed
                                </span>

                            @elseif ($reservation->status === 'cancelled')

                                <span class="badge bg-danger">
                                    Cancelled
                                </span>

                            @elseif ($reservation->status === 'no_show')

                                <span class="badge bg-secondary">
                                    No Show
                                </span>

                            @endif

                        </div>

                    </div>


                    @if ($reservation->notes)

                        <div class="row mb-4">

                            <div class="col-sm-5 text-muted">
                                Catatan
                            </div>

                            <div class="col-sm-7">
                                {{ $reservation->notes }}
                            </div>

                        </div>

                    @endif


                    @if (in_array($reservation->status, [
                        'pending',
                        'confirmed'
                    ]))

                        <form
                            action="{{ route('customer.reservations.destroy', $reservation) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan reservasi ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <div class="d-flex justify-content-end">

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                >
                                    <i class="bi bi-x-circle me-1"></i>
                                    Batalkan Reservasi
                                </button>

                            </div>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection