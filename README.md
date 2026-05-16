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


