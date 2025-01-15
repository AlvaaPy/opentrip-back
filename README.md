# Laravel Backend for Open Trip Application

## Deskripsi
Backend Laravel untuk aplikasi Open Trip yang menyediakan fitur:
- Pengelolaan paket trip (Open Trip, Private Trip, Custom Trip).
- Sistem voucher untuk diskon.
- Penyewaan kendaraan.
- Manajemen pengguna dan admin.

Proyek ini dirancang untuk mempermudah pengelolaan perjalanan wisata berbasis Android.

## Fitur
- **Manajemen Paket Trip:** CRUD untuk paket trip.
- **Sistem Voucher:** Dukungan untuk diskon tetap dan persentase.
- **Autentikasi:** JWT untuk otorisasi pengguna.
- **Manajemen Pengguna:** Admin dapat mengelola pengguna.

## Prasyarat
- PHP >= 8.1
- Composer >= 2.0
- Laravel >= 10
- MySQL >= 5.7
- Node.js >= 16 (untuk front-end opsional)

## Instalasi
1. Clone repository ini:
   ```bash
   git clone https://github.com/username/repository-name.git
   cd repository-name
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy file `.env` dan konfigurasi:
   ```bash
   cp .env.example .env
   ```

4. Generate key aplikasi:
   ```bash
   php artisan key:generate
   ```

5. Konfigurasi database di file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_db
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. Migrasi dan seed database:
   ```bash
   php artisan migrate --seed
   ```

7. Jalankan server:
   ```bash
   php artisan serve
   ```
   Akses aplikasi di [http://localhost:8000](http://localhost:8000).

## Struktur Direktori
```
- app/
  - Http/
    - Controllers/  // Logika aplikasi
  - Models/         // Model untuk database
- database/
  - migrations/     // File migrasi database
  - seeders/        // Seeder data awal
- routes/
  - api.php         // Routes untuk API
- public/
  - index.php       // Entry point aplikasi
```

## Dokumentasi API
| Method | Endpoint           | Deskripsi                         | Autentikasi |
|--------|--------------------|-----------------------------------|-------------|
| GET    | /api/v1/packages   | Mendapatkan daftar paket trip     | Ya          |
| POST   | /api/v1/packages   | Menambah paket trip baru          | Ya          |
| PUT    | /api/v1/packages/{id} | Mengedit paket trip berdasarkan ID | Ya          |
| DELETE | /api/v1/packages/{id} | Menghapus paket trip berdasarkan ID | Ya          |

Dokumentasi API lebih lengkap dapat ditemukan di [Postman Documentation](https://example.com).

## Testing
Untuk menjalankan pengujian, gunakan perintah berikut:
```bash
php artisan test
```

## Kontribusi
Kontribusi sangat dihargai! Silakan buat Pull Request atau buka Issue untuk perbaikan.

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## Penulis
**Muhammad Asrort Alva 'Izzi**  
[GitHub](https://github.com/username) | [LinkedIn](https://linkedin.com/in/username)

