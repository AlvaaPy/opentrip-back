# OpenTrip Back (Backend)

OpenTrip Back adalah backend API untuk aplikasi OpenTrip — sebuah platform manajemen perjalanan (trips, bookings, user management) yang dibangun menggunakan PHP (Laravel) dengan tampilan Blade untuk beberapa halaman administrasi. README ini menjelaskan fitur utama, teknologi yang digunakan, prasyarat instalasi, struktur proyek, contoh penggunaan, fungsi API, serta panduan kontribusi dan lisensi (MIT).

## Fitur Utama
- Autentikasi pengguna (registrasi, login, refresh token)
- Manajemen user (profil, peran / role dasar)
- CRUD Trip (buat, baca, ubah, hapus)
- Pencarian dan filtrasi trip (lokasi, tanggal, harga)
- Booking / pemesanan trip
- Manajemen pembayaran (hook untuk integrasi gateway)
- Endpoint untuk review/rating trip
- Admin dashboard minimal menggunakan Blade untuk manajemen konten
- Seeder dan migrasi database untuk data awal

## Teknologi yang Digunakan
- Bahasa: PHP
- Framework: Laravel (backend API + Blade untuk view admin)
- Templating: Blade
- Frontend statis: HTML, CSS, SCSS, JavaScript
- Dependency: Composer (PHP) dan NPM/Yarn (assets)
- Database: MySQL / MariaDB (dapat diganti ke PostgreSQL)
- Opsional: Redis (cache/session), Laravel Queue untuk antrian

## Prasyarat
- PHP >= 8.1 (sesuaikan dengan versi Laravel di repo)
- Composer 2.x
- Node.js >= 16.x dan NPM / Yarn
- MySQL 5.7 / 8.0 atau PostgreSQL
- Ekstensi PHP umum: mbstring, pdo, tokenizer, xml, ctype, json, openssl
- (Opsional) Redis untuk cache/session

## Instalasi (lokal)
1. Clone repo:
   git clone https://github.com/AlvaaPy/opentrip-back.git
   cd opentrip-back

2. Install dependency PHP:
   composer install

3. Install dependency frontend:
   npm install
   # atau
   yarn install

4. Salin file environment dan atur konfigurasi:
   cp .env.example .env
   - Atur DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
   - Atur konfigurasi mail, queue, dan service pihak ketiga jika perlu

5. Generate app key:
   php artisan key:generate

6. Migrasi dan (opsional) seed database:
   php artisan migrate
   php artisan db:seed

7. Build asset frontend (jika ada):
   npm run dev
   # atau
   npm run build

8. Jalankan server lokal:
   php artisan serve
   # biasanya tersedia di http://127.0.0.1:8000

## Konfigurasi Tambahan
- Jika menggunakan queue: set up queue driver (database/redis) dan jalankan:
  php artisan queue:work
- Untuk storage (file upload), jalankan:
  php artisan storage:link

## Susunan Proyek (struktur umum)
- app/                - kode aplikasi (Models, Controllers, Policies, Jobs)
- bootstrap/          - bootstrap aplikasi
- config/             - konfigurasi aplikasi
- database/
  - migrations/       - migrasi database
  - seeders/          - data awal
- public/             - entry point web, asset publik
- resources/
  - views/            - Blade templates (admin, email)
  - css/, js/         - asset frontend (SCSS, JS)
- routes/
  - api.php           - route API
  - web.php           - route web (Blade)
- tests/              - unit / feature tests
- .env.example        - contoh konfigurasi lingkungan

> Catatan: Struktur aktual di repo Anda mungkin sedikit berbeda—sesuaikan panduan ini dengan file dan folder di proyek.

## Contoh Penggunaan (API)
Berikut contoh request dasar (asumsi base URL: http://localhost:8000/api).

1. Registrasi
   curl -X POST http://localhost:8000/api/auth/register \
     -H "Content-Type: application/json" \
     -d '{"name":"Nama","email":"user@example.com","password":"secret","password_confirmation":"secret"}'

   Response (contoh):
   {
     "user": { "id": 1, "name": "Nama", "email": "user@example.com" },
     "token": "eyJ0eXAiOiJKV1QiLCJhbGciOi..."
   }

2. Login
   curl -X POST http://localhost:8000/api/auth/login \
     -H "Content-Type: application/json" \
     -d '{"email":"user@example.com","password":"secret"}'

3. Daftar Trip
   curl -X GET http://localhost:8000/api/trips \
     -H "Accept: application/json"

4. Detail Trip
   curl -X GET http://localhost:8000/api/trips/{id}

5. Membuat Booking (authed)
   curl -X POST http://localhost:8000/api/bookings \
     -H "Authorization: Bearer {token}" \
     -H "Content-Type: application/json" \
     -d '{"trip_id": 12, "seats": 2, "user_notes": "Request khusus..."}'

6. Membayar Booking
   - Biasanya disediakan endpoint untuk membuat payment intent atau redirect ke gateway
   - Endpoint callback / webhook untuk menerima notifikasi status pembayaran

## Penjelasan Fungsi API
API pada backend ini umumnya berfungsi untuk:
- Autentikasi dan otorisasi:
  - Register, login, logout, refresh token, reset password (opsional)
- Manajemen user:
  - Mendapatkan / memperbarui profil user, daftar user (admin)
- Manajemen trip:
  - CRUD untuk resources trip (judul, deskripsi, lokasi, tanggal, harga, kuota)
  - Endpoint publik untuk mencari dan memfilter trip berdasarkan parameter (lokasi, tanggal, price_range)
- Booking dan pembayaran:
  - Membuat booking, melihat status booking, membatalkan booking
  - Integrasi dengan payment gateway (membuat transaksi, callback webhook untuk konfirmasi pembayaran)
- Review dan rating:
  - Menambahkan dan menampilkan review untuk trip
- Admin endpoints:
  - Halaman Blade sederhana untuk manajemen konten (opsional)
- Webhook / background jobs:
  - Menangani event asynchronous (mis. notifikasi, update status pembayaran)

Semua endpoint API diharapkan mengikuti konvensi RESTful dan mengembalikan JSON. Gunakan HTTP status code sesuai standar (200/201/204/400/401/403/404/422/500).

Contoh respon sukses list trips (JSON):
{
  "data": [
    {
      "id": 12,
      "title": "OpenTrip Bali",
      "location": "Bali",
      "price": 1500000,
      "start_date": "2026-02-10",
      "end_date": "2026-02-15",
      "available_seats": 10
    }
  ],
  "meta": { "page": 1, "per_page": 10, "total": 5 }
}

## Testing
- Jalankan unit/feature tests:
  php artisan test
  # atau
  vendor/bin/phpunit

## Kontribusi
Terima kasih atas minat Anda berkontribusi! Berikut panduan singkat:
1. Fork repository ini.
2. Buat branch fitur/bugfix dari branch `main`:
   git checkout -b feature/nama-fitur
3. Tulis code dan test yang sesuai.
4. Pastikan semua test lulus:
   php artisan test
5. Commit perubahan dan push ke fork Anda:
   git push origin feature/nama-fitur
6. Buat Pull Request (PR) ke repository utama dengan deskripsi perubahan.

Rules kontribusi singkat:
- Ikuti coding style Laravel/PHP (PSR-12)
- Sertakan test untuk bugfix/fitur baru bila memungkinkan
- Jelaskan perubahan dan alasan pada deskripsi PR

## Lisensi
Project ini dilisensikan di bawah MIT License — lihat bagian bawah untuk teks lisensi.

---

MIT License

Copyright (c) 2026 AlvaaPy

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

---

Jika Anda ingin, saya bisa:
- Mengadaptasi README ini agar sesuai persis dengan struktur file dan endpoint di repo (butuh akses atau daftar route/file),
- Membuat file README.md langsung di repository dan membuka PR untuk Anda.

Beritahu langkah selanjutnya yang Anda inginkan.
