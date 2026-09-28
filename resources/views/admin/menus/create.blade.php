@extends('layouts.app', ['title' => 'Tambah Menu - Shque'])

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="mb-4">

                <h2 class="fw-bold mb-1">
                    Tambah Menu
                </h2>

                <p class="text-muted">
                    Tambahkan menu baru ke dalam daftar menu Shque.
                </p>

            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <form
                        action="{{ route('admin.menus.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        data-stock-validation-form
                        novalidate
                    >

                        @csrf

                        {{-- Kategori --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Kategori Menu
                            </label>

                            <select
                                name="menu_category_id"
                                class="form-select @error('menu_category_id') is-invalid @enderror"
                            >

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                @foreach ($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        @selected(old('menu_category_id') == $category->id)
                                    >
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

                            @error('menu_category_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Nama --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Menu
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Contoh: Shoyu Ramen"
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Deskripsi menu..."
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="row">

                            {{-- Harga --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">
                                    Harga
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        name="price"
                                        value="{{ old('price') }}"
                                        min="0"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="25000"
                                    >

                                </div>

                                @error('price')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- Stok --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-semibold">
                                    Stok
                                </label>

                                <div
                                    class="alert alert-warning py-2 mb-2 @error('stock') d-flex @else d-none @enderror"
                                    role="alert"
                                    data-stock-alert
                                >
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    Jika menu tersedia dicentang, stok harus lebih dari 0. Untuk stok 0, hilangkan centang.
                                </div>

                                <input
                                    type="number"
                                    name="stock"
                                    value="{{ old('stock') }}"
                                    min="0"
                                    step="1"
                                    required
                                    class="form-control @error('stock') is-invalid @enderror"
                                >

                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        {{-- Foto --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Foto Menu
                            </label>

                            <input
                                type="file"
                                name="image"
                                accept=".jpg,.jpeg,.png,.webp"
                                class="form-control @error('image') is-invalid @enderror"
                            >

                            <div class="form-text">
                                Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                            </div>

                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Status --}}
                        <div class="mb-4">

                            <div class="form-check">

                                <input
                                    type="checkbox"
                                    name="is_available"
                                    value="1"
                                    class="form-check-input"
                                    id="is_available"
                                    data-availability-checkbox
                                    @checked(old('is_available', true))
                                >

                                <label
                                    class="form-check-label"
                                    for="is_available"
                                >
                                    Menu tersedia
                                </label>

                            </div>

                        </div>

                        {{-- Button --}}
                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('admin.menus.index') }}"
                                class="btn btn-secondary"
                            >
                                Kembali
                            </a>

                            <button
                                type="submit"
                                class="btn btn-shque"
                            >
                                <i class="bi bi-check-lg me-1"></i>
                                Simpan Menu
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-stock-validation-form]').forEach((form) => {
            const stockInput = form.querySelector('[name="stock"]');
            const stockAlert = form.querySelector('[data-stock-alert]');
            const availabilityCheckbox = form.querySelector('[data-availability-checkbox]');

            const updateStockValidation = (showAlert = false) => {
                const stockValue = stockInput.value.trim();
                const stock = Number(stockValue);
                const minimumStock = availabilityCheckbox.checked ? 1 : 0;
                const invalidStock = stockValue === '' || !Number.isInteger(stock) || stock < minimumStock;

                stockInput.min = minimumStock;
                stockAlert.classList.toggle('d-none', !invalidStock || !showAlert);
                stockAlert.classList.toggle('d-flex', invalidStock && showAlert);
                stockInput.classList.toggle('is-invalid', invalidStock && showAlert);

                return invalidStock;
            };

            form.addEventListener('submit', (event) => {
                if (updateStockValidation(true)) {
                    event.preventDefault();
                    stockInput.focus();
                }
            });

            stockInput.addEventListener('input', () => updateStockValidation(true));
            availabilityCheckbox.addEventListener('change', () => updateStockValidation(true));
        });
    </script>
@endpush