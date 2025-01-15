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
   DB_DATABASE=your_database
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
   Akses aplikasi di [http://localhost:8000](http://localhost:8000) | [viewadmin](https://be.permata.tifpsdku.com/).

## Struktur Direktori
```
- app/
  - Http/
    - Controllers/  // Logika aplikasi
  - Mail            // Untuk Send Email Custom trip dan OTP
  - Models/         // Model untuk database
- config/
  - auth.php        // Untuk Konfigurasi JWT token admin dan user
  - mail.php        // Untuk Konfigurasi Email 
- database/
  - migrations/     // File migrasi database 
  ```bash
  php artisan migrate
  ```
  or
  ```bash
  php artisan migrate --path=/database/migrations/nama_file_migration
  ```
  - seeders/        // Seeder data awal
- public/           // Untuk view admin
  - examples/       // template admin
  - uploads/        // Sebuah directory yang menyimpan assets yang di upload dari halaman admin "Foto/Vidio"
  - resources/
    - css/          // Template Css
    - js/           // Template interaski JS
    - views/        // Berisi halaman yang di tampilkan untuk tampilan admin
        - component // 
        - emails    // View Kirim Email
        - pages/    // Berisi halaman admin 
- routes/
  - api.php         // Routes untuk API ke mobile FLutter 
  - web.php         // Routes untuk halaman admin

- public/
  - index.php       // Entry point aplikasi
```

# Dokumentasi API Open Trip

Dokumentasi API ini menjelaskan berbagai endpoint yang tersedia dalam aplikasi Open Trip. Semua endpoint yang tertera di bawah ini membutuhkan autentikasi kecuali disebutkan sebaliknya.

## Autentikasi
- **Ya**: Endpoint ini memerlukan autentikasi menggunakan token Bearer.
- **Tidak**: Endpoint ini tidak memerlukan autentikasi.

## Endpoint API

### User Routes
| Method | Endpoint                    | Deskripsi                               | Autentikasi |
|--------|-----------------------------|-----------------------------------------|-------------|
| POST   | /auth/v1/register            | Mendaftar akun baru                     | Tidak       |
| POST   | /auth/v1/login               | Login menggunakan kredensial pengguna   | Tidak       |
| POST   | /auth/v1/verify-otp          | Verifikasi OTP setelah login           | Ya          |
| POST   | /auth/v1/complete-profile    | Mengisi data profil pengguna           | Ya          |
| POST   | /auth/v1/logout              | Keluar dari akun pengguna              | Ya          |
| GET    | /auth/v1/user                | Mendapatkan informasi pengguna saat ini| Ya          |
| PUT    | /auth/v1/user                | Mengupdate profil pengguna             | Ya          |
| PUT    | /auth/v1/user/profile/{id}   | Mengupdate foto profil pengguna        | Ya          |
| POST   | /auth/v1/custom-trips        | Meminta trip kustom                    | Ya          |
| POST   | /auth/v1/reservasi           | Membuat reservasi                      | Ya          |

### Admin Routes
| Method | Endpoint                    | Deskripsi                               | Autentikasi |
|--------|-----------------------------|-----------------------------------------|-------------|
| POST   | /auth/v1/loginadmin          | Login sebagai admin                     | Tidak       |
| POST   | /auth/v1/create              | Membuat akun admin baru                 | Ya          |
| GET    | /auth/v1/admin               | Mendapatkan informasi admin saat ini    | Ya          |
| POST   | /auth/v1/logout-admin        | Keluar dari akun admin                  | Ya          |
| PUT    | /auth/v1/admin               | Mengupdate profil admin                 | Ya          |
| POST   | /auth/v1/voucher             | Membuat voucher untuk diskon            | Ya          |

### Package Trip Routes
| Method | Endpoint                    | Deskripsi                               | Autentikasi |
|--------|-----------------------------|-----------------------------------------|-------------|
| GET    | /v1/package-trip             | Mendapatkan daftar paket trip           | Ya          |
| POST   | /v1/package-trip             | Menambah paket trip baru                | Ya          |
| GET    | /v1/package-trip/{id}        | Mendapatkan detail paket trip berdasarkan ID | Ya     |
| PUT    | /v1/package-trip/{id}        | Mengedit paket trip berdasarkan ID       | Ya          |
| DELETE | /v1/package-trip/{id}        | Menghapus paket trip berdasarkan ID      | Ya          |

### Itinerary Trip Routes
| Method | Endpoint                    | Deskripsi                               | Autentikasi |
|--------|-----------------------------|-----------------------------------------|-------------|
| POST   | /v1/itenary-trip             | Menambah itinerary trip                 | Ya          |
| GET    | /v1/itenary-trip             | Mendapatkan daftar itinerary trip       | Ya          |
| PUT    | /v1/itenary-trip/{id}        | Mengedit itinerary trip berdasarkan ID   | Ya          |

### Rental Routes
| Method | Endpoint                    | Deskripsi                               | Autentikasi |
|--------|-----------------------------|-----------------------------------------|-------------|
| GET    | /v1/rental                   | Mendapatkan daftar rental               | Ya          |
| GET    | /v1/rental/{id}              | Mendapatkan detail rental berdasarkan ID | Ya          |
| POST   | /v1/rental                   | Menambah rental kendaraan               | Ya          |
| PUT    | /v1/rental/{id}              | Mengedit rental kendaraan berdasarkan ID | Ya          |
| DELETE | /v1/rental/{id}              | Menghapus rental kendaraan berdasarkan ID | Ya          |

### Image Rental Routes
| Method | Endpoint                    | Deskripsi                               | Autentikasi |
|--------|-----------------------------|-----------------------------------------|-------------|
| GET    | /v1/rental/images            | Mendapatkan gambar rental               | Ya          |
| GET    | /v1/rental/images/{id}       | Mendapatkan gambar rental berdasarkan ID| Ya          |
| POST   | /v1/rental/images            | Menambah gambar rental                  | Ya          |
| PUT    | /v1/rental/images/{id}       | Mengedit gambar rental berdasarkan ID   | Ya          |
| DELETE | /v1/rental/images/{id}       | Menghapus gambar rental berdasarkan ID  | Ya          |

### Miscellaneous Routes
| Method | Endpoint                    | Deskripsi                               | Autentikasi |
|--------|-----------------------------|-----------------------------------------|-------------|
| GET    | /v1/banner                   | Mendapatkan daftar banner ads           | Ya          |
| PUT    | /v1/banner/{id}              | Mengedit banner ads berdasarkan ID      | Ya          |
| GET    | /v1/analytic                 | Mendapatkan data analitik Open Trip    | Ya          |

## Response Format
Semua respons API akan dikembalikan dalam format JSON. Setiap respons akan memiliki format umum seperti berikut:

```json
{
    "status": "success",
    "data": {...},
    "message": "Operasi berhasil"
}

## Dokumentasi Web Routes

| Method  | Endpoint                      | Deskripsi                                         | Autentikasi |
|---------|-------------------------------|---------------------------------------------------|-------------|
| GET     | /pengguna                      | Menampilkan daftar pengguna                       | Ya          |
| GET     | /pengguna/update/{id}          | Menampilkan halaman edit pengguna                 | Ya          |
| PUT     | /pengguna/update/{id}          | Mengupdate profil pengguna berdasarkan ID          | Ya          |
| DELETE  | /pengguna/delete/{id}          | Menghapus pengguna berdasarkan ID                  | Ya          |
| GET     | /admin                         | Menampilkan daftar admin                          | Ya          |
| GET     | /Login                         | Menampilkan halaman login                         | Tidak       |
| POST    | /Login                         | Memproses login                                   | Tidak       |
| POST    | /logout                        | Memproses logout                                  | Ya          |
| GET     | /trip                          | Menampilkan daftar paket trip                     | Ya          |
| POST    | /add-trip                      | Menambah paket trip baru                          | Ya          |
| DELETE  | /trip/delete/{id}              | Menghapus paket trip berdasarkan ID                | Ya          |
| GET     | /trip/edit/{id}                | Menampilkan halaman edit paket trip               | Ya          |
| PUT     | /trip/update/{id}              | Mengupdate paket trip berdasarkan ID               | Ya          |
| GET     | /itenaryTrip                   | Menampilkan daftar itinerary trip                  | Ya          |
| POST    | /add-itenary                   | Menambah itinerary trip baru                       | Ya          |
| DELETE  | /itenary/delete/{id}           | Menghapus itinerary trip berdasarkan ID            | Ya          |
| GET     | /galery                        | Menampilkan galeri paket trip                      | Ya          |
| POST    | /add-galery                    | Menambah galeri paket trip baru                    | Ya          |
| DELETE  | /galery/delete/{id}            | Menghapus galeri berdasarkan ID                    | Ya          |
| GET     | /banner                        | Menampilkan daftar banner iklan                    | Ya          |
| POST    | /add-banner                    | Menambah banner iklan baru                         | Ya          |
| DELETE  | /banner/delete/{id}            | Menghapus banner iklan berdasarkan ID              | Ya          |
| GET     | /request-custom                | Menampilkan daftar custom trip request             | Ya          |
| PATCH   | /admin/custom-trip/{id}/accept | Menerima permintaan custom trip berdasarkan ID     | Ya          |
| PATCH   | /admin/custom-trip/{id}/reject | Menolak permintaan custom trip berdasarkan ID      | Ya          |
| DELETE  | /request/delete/{id}           | Menghapus permintaan custom trip berdasarkan ID    | Ya          |
| GET     | /Voucher                       | Menampilkan daftar voucher                         | Ya          |
| POST    | /Add-Voucher                   | Menambah voucher baru                              | Ya          |
| DELETE  | /voucher/delete/{id}           | Menghapus voucher berdasarkan ID                   | Ya          |
| GET     | /Reservasi                     | Menampilkan daftar reservasi                       | Ya          |
| DELETE  | /reservasi/delete/{id}         | Menghapus reservasi berdasarkan ID                 | Ya          |
| GET     | /Rental                        | Menampilkan daftar rental                          | Ya          |
| POST    | /Add-Rental                    | Menambah rental baru                               | Ya          |
| PUT     | /Rental/update/{id}            | Mengupdate rental berdasarkan ID                   | Ya          |
| DELETE  | /Rental/delete/{id}            | Menghapus rental berdasarkan ID                    | Ya          |
| GET     | /image-rental                  | Menampilkan daftar galeri image rental             | Ya          |
| POST    | /add-galery-rental             | Menambah galeri image rental baru                  | Ya          |
| GET     | /add-country                   | Menampilkan halaman tambah negara                 | Ya          |
| GET     | /Country                       | Menampilkan daftar negara                          | Ya          |
| POST    | /add-country                   | Menambah negara baru                               | Ya          |
| DELETE  | /country/delete/{id}           | Menghapus negara berdasarkan ID                    | Ya          |
| GET     | /add-province                  | Menampilkan halaman tambah provinsi               | Ya          |
| GET     | /Province                      | Menampilkan daftar provinsi                        | Ya          |
| POST    | /add-province                  | Menambah provinsi baru                              | Ya          |
| DELETE  | /province/delete/{id}          | Menghapus provinsi berdasarkan ID                  | Ya          |
| GET     | /add-city                      | Menampilkan halaman tambah kota                    | Ya          |
| GET     | /City                          | Menampilkan daftar kota                            | Ya          |
| POST    | /add-city                      | Menambah kota baru                                 | Ya          |
| DELETE  | /city/delete/{id}              | Menghapus kota berdasarkan ID                      | Ya          |




## Testing
Untuk menjalankan pengujian, gunakan perintah berikut:
```bash
php artisan test
```
Dokumentasi di atas dapat kamu modifikasi lebih lanjut sesuai dengan kebutuhan, atau menambah penjelasan tambahan jika diperlukan.
Jika ada yang perlu ditanyakan silahkan hubungi [Instagram](https://www.instagram.com/asroralva/)

## Kontribusi
Kontribusi sangat dihargai! Silakan buat Pull Request atau buka Issue untuk perbaikan.

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## Penulis
**Muhammad Asrort Alva 'Izzi**  
[GitHub](https://github.com/AlvaaPy) | [LinkedIn](https://www.linkedin.com/in/asroralva/)

