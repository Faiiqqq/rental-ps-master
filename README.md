# Aplikasi Rental PlayStation (Laravel 12)

Aplikasi manajemen rental PS dengan fitur advanced database.

## Fitur Unggulan 🚀
- **Manajemen Stok Otomatis** (Menggunakan Database Trigger)
- **Perhitungan Denda Akurat** (Menggunakan MySQL Stored Function)
- **Keamanan Transaksi** (Menggunakan DB Transaction & Row Locking)
- **Log Aktivitas** (Audit Trail User)
- **Laporan Keuangan** (Cetak PDF)
- **Stored Procedures** untuk penyelesaian transaksi.

## Cara Install
1. Clone repo
2. `composer install` kalau error `composer dump-autoload`
3. `cp .env.example .env` (Setting database)
4. `php artisan key:generate`
5. `php artisan migrate` (Otomatis install Trigger & Procedure)
