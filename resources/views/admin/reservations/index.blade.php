@extends('layouts.app', ['title' => 'Histori Booking - Shoku'])

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Histori Booking</h2>
        <p class="text-muted mb-0">Seluruh booking customer dan status terkininya.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Customer</th>
                        <th>Meja</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Tamu</th>
                        <th>Status Reservasi</th>
                        <th>Status Meja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="reservation-rows">
                    @forelse ($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->table->table_number }}</td>
                            <td>{{ $reservation->reservation_date->format('d/m/Y') }}</td>
                            <td>{{ substr($reservation->reservation_time, 0, 5) }}</td>
                            <td>{{ $reservation->guest_count }} orang</td>
                            <td>
                                <span class="badge {{ $reservation->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary' }}">
                                    {{ ucwords(str_replace('_', ' ', $reservation->status)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $reservation->table->status === 'reserved' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ ucfirst($reservation->table->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($reservation->status === 'pending')
                                    <form action="{{ route('admin.reservations.table-status', $reservation) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $reservation->table->status === 'reserved' ? 'btn-primary' : 'btn-warning' }}">
                                            @if ($reservation->table->status === 'reserved')
                                                <i class="bi bi-check-lg me-1"></i>Konfirmasi Reservasi
                                            @else
                                                <i class="bi bi-grid-3x3-gap me-1"></i>Tandai Reserved
                                            @endif
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                Belum ada reservasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3" id="reservation-pagination">
        {{ $reservations->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let isRefreshing = false;

        window.setInterval(async () => {
            if (isRefreshing || document.hidden) {
                return;
            }

            isRefreshing = true;

            try {
                const response = await fetch(window.location.href, {
                    cache: 'no-store',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });

                if (!response.ok) {
                    return;
                }

                const page = new DOMParser().parseFromString(
                    await response.text(),
                    'text/html'
                );
                const rows = page.querySelector('#reservation-rows');
                const pagination = page.querySelector('#reservation-pagination');

                if (rows) {
                    document.querySelector('#reservation-rows').innerHTML = rows.innerHTML;
                }

                if (pagination) {
                    document.querySelector('#reservation-pagination').innerHTML = pagination.innerHTML;
                }
            } catch {
            } finally {
                isRefreshing = false;
            }
        }, 5000);
    });
</script>
@endpush