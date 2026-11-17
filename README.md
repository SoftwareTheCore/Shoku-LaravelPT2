# Shoku — Restaurant Reservation & Pre-Order System

Shoku adalah platform berbasis web untuk manajemen reservasi meja restoran dan pemesanan makanan/minuman (*pre-order*). Sistem ini dirancang untuk mencegah terjadinya *double booking*, mempercepat alur kedatangan pelanggan, serta memudahkan operasional pengelola restoran (Admin dan Staf Karyawan).

---

## 🌟 Fitur Utama

### 1. Pelanggan (Customer)
* **Katalog Menu:** Melihat daftar hidangan lengkap dengan foto, deskripsi, harga, kategori, dan sisa stok.
* **Cek Ketersediaan Meja Dinamis:** Pengecekan ketersediaan meja secara *real-time* berdasarkan tanggal dan jam yang dipilih.
* **Reservasi Meja:** Pemesanan meja dengan kapasitas sesuai jumlah tamu dan pencegahan bentrok waktu reservasi (*overlapping reservations*).
* **Pemesanan Menu (*Pre-order*):** Pelanggan dapat memesan makanan/minuman yang langsung tertaut dengan reservasi aktif mereka.
* **Riwayat & Status:** Memantau status reservasi (`pending`, `confirmed`, `cancelled`) dan status pesanan.

### 2. Admin (Pengelola Restoran)
* **Dashboard Operasional:** Ringkasan metrik harian, meja aktif, reservasi masuk, dan pesanan terbaru.
* **Manajemen Meja:** Pengaturan nomor meja, kapasitas tempat duduk, dan status meja (`available`, `reserved`, `occupied`, `maintenance`).
* **Manajemen Menu & Kategori:** CRUD kategori hidangan, menu makanan/minuman, unggah foto, harga, penyesuaian stok, dan status ketersediaan.
* **Manajemen Staf Karyawan:** Menambahkan akun karyawan dan mengaktifkan/menonaktifkan akses staf.
* **Konfirmasi Reservasi:** Menyetujui reservasi yang berstatus `pending` menjadi `confirmed` serta memperbarui status meja fisik menjadi `reserved`.
* **Penyelesaian Pesanan & Laporan:** Menandai pesanan selesai, menambahkan catatan admin, dan melihat laporan rekap pendapatan dengan filter harian, mingguan, serta bulanan.

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

* **Backend:** PHP 8.1+, Laravel 10
* **Database:** MySQL / MariaDB (Eloquent ORM dengan *pessimistic locking* untuk pencegahan *race conditions*)
* **Frontend:** Laravel Blade, Bootstrap 5, Custom CSS ([`app.css`](resources/css/app.css))
* **Identitas Brand:** 
  * Warna Utama: `--shoku-primary` (`rgb(255, 82, 50)`)
  * Warna Sekunder: `--shoku-secondary` (`#ffffff`)

---

## 🚀 Panduan Instalasi Lokal

### 1. Prasyarat
* PHP >= 8.1
* Composer
* Node.js & NPM
* Database MySQL / MariaDB (misal via XAMPP)

### 2. Langkah Pengaturan

1. **Clone repositori:**
   ```bash
   git clone <url-repository-anda>
   cd ShokuPT2
   ```

2. **Pasang dependensi PHP & Node.js:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan koneksi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=shoku_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi Database:**
   ```bash
   php artisan migrate
   ```

6. **Build Asset Frontend:**
   ```bash
   npm run build
   # atau untuk mode pengembangan:
   # npm run dev
   ```

7. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Buka browser pada alamat `http://127.0.0.1:8000`.

---

## 🧪 Menjalankan Pengujian (Testing)

Aplikasi dilengkapi dengan pengujian fitur (*feature tests*) untuk integritas reservasi meja, pencegahan konflik waktu, dan pemesanan menu:

```bash
php artisan test
```

---

## 📄 Dokumentasi Tambahan

Detail spesifikasi kebutuhan sistem dan alur fungsional dapat dibaca pada dokumen [PRD.md](PRD.md).
