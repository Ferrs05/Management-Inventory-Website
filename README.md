# Organizational Inventory System

Website inventaris organisasi berbasis Laravel 10, MySQL, Blade, Bootstrap 5, dan Laravel Socialite Google Auth.

## Fitur

- Public home page dan katalog barang dengan status ketersediaan.
- Register/login manual atau Google OAuth.
- Dashboard user untuk riwayat request dan notifikasi.
- Staff dashboard untuk edit barang, approve/reject request, dan mark as returned.
- Super admin dapat tambah/hapus barang dan mengubah role pengguna.
- State machine peminjaman:
  - `pending`: stok belum berubah.
  - `approved`: stok dikurangi.
  - `rejected`: stok tidak berubah.
  - `returned`: stok dipulihkan.
- Database notifications untuk user dan staff/admin.

## Setup

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Jika memakai asset pipeline:

```bash
npm install
npm run build
```

## Google Auth

Isi `.env`:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

Callback URL di Google Cloud Console harus sama dengan `GOOGLE_REDIRECT_URI`.

## Catatan Composer

Pada percobaan setup otomatis, koneksi Packagist/GitHub sempat gagal dan vendor Laravel tidak berhasil terunduh. Source aplikasi sudah disiapkan penuh; jalankan `composer install` saat koneksi stabil.
