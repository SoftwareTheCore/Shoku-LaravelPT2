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
                        <i class="bi bi-calendar-plus me-2"></i>
                        Reservasi Meja
                    </h5>

                </div>


                <div class="card-body p-4">

                    @if (session('error'))

                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>

                    @endif


                    @if ($tables->isEmpty())

                        <div class="alert alert-warning">

                            <i class="bi bi-exclamation-triangle me-1"></i>

                            Saat ini belum ada meja yang tersedia.

                        </div>

                    @else

                        <form
                            action="{{ route('customer.reservations.store') }}"
                            method="POST"
                        >

                            @csrf


                            {{-- Meja --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Pilih Meja
                                </label>

                                <select
                                    name="restaurant_table_id"
                                    id="restaurant_table_id"
                                    class="form-select @error('restaurant_table_id') is-invalid @enderror"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Meja --
                                    </option>

                                    @foreach ($tables as $table)

                                        <option
                                            value="{{ $table->id }}"
                                            data-capacity="{{ $table->capacity }}"
                                            {{ old('restaurant_table_id') == $table->id ? 'selected' : '' }}
                                        >
                                            {{ $table->table_number }}
                                            — {{ $table->capacity }} orang
                                        </option>

                                    @endforeach

                                </select>

                                    <small
                                        id="tableAvailabilityInfo"
                                        class="d-block mt-1 text-muted"
                                    >
                                        Pilih tanggal dan jam untuk melihat meja yang tersedia.
                                    </small>

                                    <div
                                        id="tableAvailabilityWarning"
                                        class="alert alert-warning border-0 border-start border-4 border-warning shadow-sm d-flex align-items-center gap-2 py-2 mt-2 mb-0 d-none"
                                        role="alert"
                                        aria-live="polite"
                                    >
                                        <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                                        <span></span>
                                    </div>

                                @error('restaurant_table_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Tanggal --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Tanggal Reservasi
                                </label>

                                <input
                                    type="date"
                                    name="reservation_date"
                                    id="reservation_date"
                                    class="form-control @error('reservation_date') is-invalid @enderror"
                                    value="{{ old('reservation_date') }}"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                >

                                @error('reservation_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Jam --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Jam Reservasi
                                </label>

                                <input
                                    type="time"
                                    name="reservation_time"
                                    id="reservation_time"
                                    class="form-control @error('reservation_time') is-invalid @enderror"
                                    value="{{ old('reservation_time') }}"
                                    required
                                >

                                @error('reservation_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Jumlah Orang --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Jumlah Orang
                                </label>

                                <input
                                    type="number"
                                    name="guest_count"
                                    id="guest_count"
                                    class="form-control @error('guest_count') is-invalid @enderror"
                                    value="{{ old('guest_count') }}"
                                    min="1"
                                    max="50"
                                    placeholder="Contoh: 4"
                                    required
                                >

                                <small
                                    id="capacityInfo"
                                    class="text-muted"
                                >
                                    Pilih meja terlebih dahulu.
                                </small>

                                <div
                                    id="capacityWarning"
                                    class="alert alert-warning d-flex align-items-center gap-2 py-2 mt-2 mb-0 d-none"
                                    role="alert"
                                    aria-live="polite"
                                >
                                    <i class="bi bi-exclamation-triangle-fill" aria-hidden="true"></i>
                                    <span></span>
                                </div>

                                @error('guest_count')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Catatan --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">
                                    Catatan
                                </label>

                                <textarea
                                    name="notes"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    rows="4"
                                    placeholder="Contoh: ingin meja dekat jendela."
                                >{{ old('notes') }}</textarea>

                                @error('notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <div class="d-flex justify-content-end gap-2">

                                <a
                                    href="{{ route('customer.reservations.index') }}"
                                    class="btn btn-secondary"
                                >
                                    Batal
                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-shoku"
                                >
                                    <i class="bi bi-calendar-check me-1"></i>
                                    Kirim Reservasi
                                </button>

                            </div>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>


@push('scripts')

<script>

    const tableSelect = document.getElementById('restaurant_table_id');
    const guestInput = document.getElementById('guest_count');
    const capacityInfo = document.getElementById('capacityInfo');
    const capacityWarning = document.getElementById('capacityWarning');
    const reservationDateInput = document.getElementById('reservation_date');
    const reservationTimeInput = document.getElementById('reservation_time');
    const tableAvailabilityInfo = document.getElementById('tableAvailabilityInfo');
    const tableAvailabilityWarning = document.getElementById('tableAvailabilityWarning');
    const tableOptions = Array.from(tableSelect.options).slice(1).map(option => ({
        option,
        label: option.textContent.trim(),
    }));
    let availabilityRequest = 0;

    function validateGuestCount() {

        const capacity = Number(guestInput.max);
        const guestCount = Number(guestInput.value);
        const exceedsCapacity =
            guestInput.value !== '' &&
            capacity > 0 &&
            guestCount > capacity;

        capacityWarning.classList.toggle('d-none', !exceedsCapacity);
        capacityWarning.querySelector('span').textContent =
            `Jumlah tamu melebihi kapasitas meja (${capacity} orang).`;
    }

    function updateCapacity() {

        const selectedOption =
            tableSelect.options[tableSelect.selectedIndex];

        const capacity =
            selectedOption.dataset.capacity;

        if (capacity) {

            guestInput.max = capacity;

            capacityInfo.textContent =
                `Kapasitas meja: ${capacity} orang`;

            validateGuestCount();

        } else {

            guestInput.removeAttribute('max');

            capacityInfo.textContent =
                'Pilih meja terlebih dahulu.';

        }
    }

    async function updateTableAvailability() {

        const requestId = ++availabilityRequest;
        const reservationDate = reservationDateInput.value;
        const reservationTime = reservationTimeInput.value;

        tableSelect.disabled = false;
        tableAvailabilityInfo.classList.remove('text-danger');

        if (!reservationDate || !reservationTime) {
            tableOptions.forEach(({ option, label }) => {
                option.disabled = false;
                option.textContent = label;
            });
            tableAvailabilityWarning.classList.add('d-none');
            tableAvailabilityInfo.textContent =
                'Pilih tanggal dan jam untuk melihat meja yang tersedia.';
            return;
        }

        tableSelect.disabled = true;
        tableAvailabilityInfo.textContent = 'Memeriksa ketersediaan meja...';

        const query = new URLSearchParams({
            reservation_date: reservationDate,
            reservation_time: reservationTime,
        });

        try {
            const response = await fetch(
                `{{ route('customer.reservations.availability') }}?${query}`,
                { headers: { Accept: 'application/json' } }
            );

            if (!response.ok) {
                throw new Error('Availability request failed');
            }

            const data = await response.json();

            if (requestId !== availabilityRequest) {
                return;
            }

            const unavailableTableIds = new Set(
                data.unavailable_table_ids.map(String)
            );
            const unavailableTableLabels = tableOptions
                .filter(({ option }) => unavailableTableIds.has(option.value))
                .map(({ label }) => label.split(' — ')[0]);

            tableOptions.forEach(({ option, label }) => {
                const isBooked = unavailableTableIds.has(option.value);
                option.disabled = isBooked;
                option.textContent = isBooked
                    ? `${label} (Sudah dipesan)`
                    : label;
            });

            if (tableSelect.selectedOptions[0]?.disabled) {
                tableSelect.value = '';
                updateCapacity();
            }

            tableSelect.disabled = false;
            tableAvailabilityInfo.textContent = unavailableTableLabels.length > 0
                ? 'Meja yang bertanda sudah dipesan tidak bisa dipilih pada waktu ini.'
                : 'Semua meja tersedia pada tanggal dan jam yang dipilih.';
            tableAvailabilityWarning.classList.toggle(
                'd-none',
                unavailableTableLabels.length === 0
            );
            tableAvailabilityWarning.querySelector('span').textContent =
                `Meja ${unavailableTableLabels.join(', ')} sudah dipesan pada waktu ini dan tidak bisa dipilih.`;
        } catch (error) {
            if (requestId !== availabilityRequest) {
                return;
            }

            tableAvailabilityInfo.textContent =
                'Ketersediaan meja gagal diperiksa. Ubah tanggal atau jam untuk mencoba lagi.';
            tableAvailabilityInfo.classList.add('text-danger');
            tableAvailabilityWarning.classList.add('d-none');
        }
    }

    tableSelect.addEventListener(
        'change',
        updateCapacity
    );

    guestInput.addEventListener(
        'input',
        validateGuestCount
    );

    reservationDateInput.addEventListener(
        'change',
        updateTableAvailability
    );

    reservationTimeInput.addEventListener(
        'change',
        updateTableAvailability
    );

    updateCapacity();
    updateTableAvailability();

</script>

@endpush

@endsection