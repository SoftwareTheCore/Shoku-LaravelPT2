@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Reservasi Saya
            </h2>

            <p class="text-muted mb-0">
                Lihat dan kelola reservasi meja Anda.
            </p>

        </div>

        <a
            href="{{ route('customer.reservations.create') }}"
            class="btn btn-shque"
        >
            <i class="bi bi-calendar-plus me-1"></i>
            Buat Reservasi
        </a>

    </div>


    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    @if (session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle me-1"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>
                            <th>No</th>
                            <th>Meja</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Tamu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($reservations as $reservation)

                            <tr>

                                <td>
                                    {{ $reservations->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $reservation->table->table_number }}
                                </td>

                                <td>
                                    {{ $reservation->reservation_date->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ substr($reservation->reservation_time, 0, 5) }}
                                </td>

                                <td>
                                    {{ $reservation->guest_count }} orang
                                </td>

                                <td>

                                    @if ($reservation->status === 'pending')
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                    @elseif ($reservation->status === 'confirmed')
                                        <span class="badge bg-primary">
                                            Confirmed
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

                                </td>

                                <td>

                                    <a
                                        href="{{ route('customer.reservations.show', $reservation) }}"
                                        class="btn btn-sm btn-info text-white"
                                    >
                                        Detail
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <i class="bi bi-calendar-x fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada reservasi.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    @if ($reservations->hasPages())

        <div class="mt-4">
            {{ $reservations->links('pagination::bootstrap-5') }}
        </div>

    @endif

</div>

@endsection