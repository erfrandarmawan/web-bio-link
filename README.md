# Web Bio Link

Product Requirements Document : https://docs.google.com/document/d/1mp4S8aExsG5AID9NOd6aBIHBu1RXWITSCcdNxigQU7E/edit?usp=sharing

Aplikasi web untuk **membuat halaman bio link** (seperti Linktree/Bio.link) yang dapat dikelola sendiri. Setiap pengguna mendapatkan halaman publik dengan tautan personal (link.develobe.id/{username}) untuk membagikan semua tautan penting dalam satu tempat, lengkap dengan dashboard analitik dan manajemen profil.

Dibangun dengan **Laravel 13**, **PHP 8.5**, **MySQL**, **Tailwind CSS 4**, **Liquid Glass UI**, dan **Vite**.

---

## ✨ Fitur Utama

- **Autentikasi lengkap** — register, login, logout, lupa password, dan reset password.
- **Username unik & permanen** — username dipilih saat pendaftaran dan tidak bisa diubah (digunakan untuk `link.develobe.id/{username}`).
- **Halaman link publik** — setiap user memiliki halaman publik yang menampilkan foto profil, nama website, dan daftar tautan dengan fitur pencarian serta pengurutan (Abjad, Terbaru, Terlama).
- **Konfirmasi link** — sebelum membuka tautan, pengunjung wajib melihat URL tujuan dan memberikan persetujuan eksplisit (melindungi platform dari konten buatan pengguna).
- **Pelacakan klik** — setiap klik pada tautan dicatat (user agent + timestamp) untuk kebutuhan analitik.
- **Dashboard analitik** — total klik, total tautan, dan grafik klik per hari dengan filter periode: Hari Ini, 7 Hari Terakhir, 30 Hari Terakhir, dan Bulan Ini (gabungan menu Dasbor & Analitik).
- **CRUD tautan** — tambah, ubah, dan hapus tautan (soft delete).
- **Manajemen profil** — ubah foto profil (dengan preview), nama website, dan ganti password.
- **Liquid Glass UI** — antarmuka modern dengan efek glassmorphism bertema `#38b6ff`.

---

## 🧱 Teknologi

| Kategori | Teknologi |
| --- | --- |
| Backend | Laravel 13, PHP 8.5 |
| Database | MySQL |
| Frontend | Blade, Tailwind CSS 4, Liquid Glass UI, Vite 8 |
| Testing | Pest 5, PHPUnit |
| Tooling | Laravel Pint, Laravel Boost, Laravel Pail |

---

## ✅ Persyaratan

Pastikan sudah terpasang:

- PHP **8.3+** (disarankan 8.5) dengan ekstensi standar Laravel (`pdo_mysql`, `mysqli`)
- Composer
- Node.js **18+** dan npm
- MySQL (server berjalan)

---

## 🚀 Langkah Menjalankan Proyek

### 1. Clone repositori

```bash
git clone https://github.com/erfrandarmawan/web-bio-link.git web-bio-link
cd web-bio-link
```

### 2. Install dependensi PHP & JavaScript

```bash
composer install
npm install
```

### 3. Siapkan environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Buat database MySQL

Buat database bernama `web_link_in_bio` (atau sesuaikan dengan `DB_DATABASE` di `.env`).

```sql
CREATE DATABASE web_link_in_bio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Sesuaikan kredensial database pada `.env` bila perlu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_link_in_bio
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan pula session driver dan lainnya:

```env
SESSION_DRIVER=database
```

### 5. Buat symbolic link storage

```bash
php artisan storage:link
```

### 6. Jalankan migrasi

```bash
php artisan migrate
```

### 7. Jalankan aplikasi

Cara cepat (menjalankan server dan Vite sekaligus):

```bash
composer run dev
```

Atau jalankan secara terpisah:

```bash
php artisan serve
npm run dev
```

Buka **http://localhost:8000** di browser.

> Untuk mode produksi, jalankan `npm run build` agar aset frontend dikompilasi.

---

## 🧪 Menjalankan Test

```bash
php artisan test --compact
```

Test menggunakan database SQLite in-memory (lihat `phpunit.xml`), jadi tidak mengganggu data MySQL.

---

## 🗂️ Struktur Proyek

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                      # Login, Register, Forgot/Reset Password, Logout
│   │   ├── DashboardController.php    # Ringkasan & grafik analitik
│   │   ├── HomeController.php         # Halaman landing
│   │   ├── LinkController.php         # CRUD tautan + pelacakan klik
│   │   ├── ProfileController.php      # Manajemen profil & ganti password
│   │   └── UserLinkController.php     # Halaman link publik per username
│   └── (Controllers lainnya)
├── Models/
│   ├── Analytic.php                   # Catatan klik per tautan
│   ├── Link.php                       # Tautan dengan soft delete
│   └── User.php                       # UUID + relasi ke tautan
└── (Providers, dll)

database/
├── migrations/                        # Skema: users (UUID), links, analytics, cache, jobs, sessions
├── factories/                         # UserFactory
└── seeders/                           # DatabaseSeeder

resources/views/
├── layouts/
│   ├── app.blade.php                  # Layout utama (navbar glass, liquid background)
│   └── guest.blade.php                # Layout halaman publik/auth (liquid background)
├── auth/                              # Halaman autentikasi (login, register, forgot, reset)
├── dashboard/index.blade.php          # Dashboard + grafik analitik
├── landing.blade.php                  # Halaman depan
├── links/                             # Daftar & form tautan
├── profile/
│   ├── edit.blade.php                 # Edit profil + preview avatar
│   └── change-password.blade.php      # Ganti password
└── user-link.blade.php                # Halaman link publik (setiap user)
```

---

## 🧭 Routing

| Method | URI | Keterangan |
| --- | --- | --- |
| `GET` | `/` | Halaman landing |
| `GET` | `/{username}` | Halaman link publik user |
| `POST` | `/links/{link}/click` | Catat klik tautan (publik) |
| `GET` | `/login` | Form login |
| `POST` | `/login` | Proses login |
| `GET` | `/register` | Form register |
| `POST` | `/register` | Proses register |
| `GET` | `/forgot-password` | Form lupa password |
| `POST` | `/forgot-password` | Kirim link reset |
| `GET` | `/reset-password/{token}` | Form reset password |
| `POST` | `/reset-password` | Proses reset password |
| `GET` | `/dashboard` | Dashboard analitik (dengan filter periode) |
| `GET` | `/analytics` | Redirect ke dashboard (digabung) |
| `GET` | `/links` | Daftar tautan saya |
| `GET` | `/links/create` | Form tambah tautan |
| `POST` | `/links` | Simpan tautan baru |
| `GET` | `/links/{link}/edit` | Form ubah tautan |
| `PUT` | `/links/{link}` | Perbarui tautan |
| `DELETE` | `/links/{link}` | Hapus tautan (soft delete) |
| `GET` | `/profile` | Edit profil |
| `PUT` | `/profile` | Perbarui profil |
| `GET` | `/profile/password` | Form ganti password |
| `PUT` | `/profile/password` | Proses ganti password |
| `POST` | `/logout` | Logout |

Lihat semua rute dengan:

```bash
php artisan route:list --except-vendor
```

---

## 🖌️ Tema & Desain

Aplikasi menggunakan tema **Liquid Glass (Glassmorphism)** dengan palet warna utama `#38b6ff`.

### Komponen desain

- **Background**: gradien cair dengan gumpalan warna biru/cyan/purple yang bergerak secara animasi
- **Kartu**: efek kaca patri dengan `backdrop-filter: blur(20px)` dan batas semi-transparan
- **Navigasi**: navbar lengket dengan efek buram di bagian bawah
- **Tombol aksi**: gradien dari `#38b6ff` ke biru muda dengan bayangan
- **Input**: bidang transparan dengan efek kaca

Lihat `resources/css/app.css` untuk detail kelas utilitas kustom (`glass-card`, `glass-input`, `glass-nav`, `bg-liquid`, `blob`).

---

## 🔒 Keamanan & Perlindungan Platform

Karena tautan yang dibagikan adalah **konten buatan pengguna (user-generated content)**, platform menerapkan langkah-langkah berikut:

1. **Konfirmasi eksplisit** — setiap pengunjung yang akan membuka tautan diwajibkan:
   - Melihat URL tujuan yang ditampilkan dengan jelas
   - Membaca pernyataan bahwa link dibuat oleh pemilik halaman, bukan oleh platform
   - Mencentang persetujuan bahwa mereka memahami dan bertanggung jawab atas tautan yang dibuka

2. **Soft delete** — tautan yang dihapus tidak langsung hilang, memungkinkan pemulihan data jika diperlukan.

3. **Validasi input** — URL divalidasi sebagai format URL yang benar, username dibatasi karakter tertentu, nama website hanya huruf/angka/spasi.

---

## 🛠️ Command List

```bash
php artisan migrate:fresh            # Reset database
php artisan route:list               # Lihat daftar rute
vendor/bin/pint                      # Rapikan format kode PHP
php artisan pail                     # Lihat log aplikasi secara real-time
npm run build                        # Build aset untuk produksi
php artisan storage:link             # Tautkan storage untuk akses publik
php artisan view:cache               # Cache template Blade
php artisan view:clear               # Hapus cache template Blade
```

---

## 💖 Dukungan & Kontak

Kamu dapat mendukung saya di https://saweria.co/erfrandarmawan

Collab via erfrandarmawan@develobe.id

Social Media Channel :
- https://www.youtube.com/@develobe_id
- https://tiktok.com/@erfrandarmawan
- https://instagram.com/erfrandarmawan

---

## 📄 Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).