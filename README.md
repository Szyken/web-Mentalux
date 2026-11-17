# MentalUX

Platform Konsultasi Psikologi dan Kesehatan Mental Berbasis Web, dibuat untuk proyek mata kuliah IS513-B E-Business Program Studi Sistem Informasi, Universitas Multimedia Nusantara.

> **Support for You & Your Loved Ones.** Mewujudkan Kesehatan Mental untuk Semua — menggabungkan empati manusia dengan kemudahan teknologi untuk menciptakan ruang aman bagi siapa saja.

Repo ini berisi seluruh kode sumber aplikasi web **MentalUX** yang telah dimigrasi dari native PHP ke framework **Laravel** dengan sistem autentikasi multi-role (`Customer`, `Psychologist`, `Admin`), manajemen jadwal konsultasi, simulasi pembayaran QRIS/Transfer Bank, ruang chat sesi konsultasi, serta verifikasi dokumen sertifikat psikolog (PDF).

## Preview

![Hero Section dan Paket Sesi Konsultasi MentalUX](docs/preview/01-home.png)

| Tentang Kami (Our Story) | Direktori & Pencarian Psikolog |
| --- | --- |
| ![Visi misi MentalUX dan metrik layanan](docs/preview/02-about.png) | ![Pencarian nama psikolog dan kartu profil spesialis](docs/preview/03-psychologist.png) |

| Pusat Edukasi (Knowledge Hub) | Artikel & Tips Kesehatan Mental |
| --- | --- |
| ![Video edukasi YouTube tersemat mengenai kesehatan mental](docs/preview/04-education-video.png) | ![Daftar artikel berdasarkan kategori Work Life, Mindfulness, dan Relationship](docs/preview/05-education-articles.png) |

| Halaman Login | Halaman Sign Up (Multi-Role) |
| --- | --- |
| ![Form login email dan password dengan Remember Me](docs/preview/06-login.png) | ![Form registrasi akun dengan pilihan role Customer/Psikolog](docs/preview/07-signup.png) |

| Customer Dashboard | Pemilihan Jadwal & Slot Jam Konsultasi |
| --- | --- |
| ![Dashboard pelanggan menampilkan profil, sesi aktif, dan tombol Find Expert](docs/preview/08-customer-dashboard.png) | ![Pemilihan tanggal dan 4 slot jam konsultasi WIB](docs/preview/09-booking-schedule.png) |

| Pembayaran QRIS & Transfer Bank | Ruang Chat Konsultasi Real-Time |
| --- | --- |
| ![Halaman checkout dengan Order ID, countdown timer, dan QRIS](docs/preview/10-payment-qris.png) | ![Ruang percakapan antara pasien dan psikolog beserta tombol End Session](docs/preview/11-chat-room.png) |

| Psychologist Dashboard | Upload Sertifikat Praktik Psikolog |
| --- | --- |
| ![Dashboard psikolog menampilkan pendapatan bulanan dan antrean pasien](docs/preview/12-psychologist-dashboard.png) | ![Form unggah file sertifikat praktik berformat PDF maks 10 MB](docs/preview/13-upload-certificate.png) |

| Admin Dashboard | Verifikasi Sertifikat Psikolog (Admin) |
| --- | --- |
| ![Panel admin menampilkan total user, psikolog, sesi, dan menu manajemen](docs/preview/14-admin-dashboard.png) | ![Tabel persetujuan sertifikat PDF psikolog dengan aksi Approve/Reject](docs/preview/15-admin-verify.png) |

## Halaman & Route

Aplikasi menggunakan pembagian hak akses (*role-based access control*) untuk memisahkan alur pengguna umum, pelanggan, psikolog, dan administrator.

| Route | Role / Akses | Isi & Fungsi |
| --- | --- | --- |
| `/` | Publik | Hero section, nilai utama layanan, dan 3 paket sesi (*Starter*, *Progress*, *Complete*) |
| `/about` | Publik | Penjelasan *Our Story*, metrik dampak (500+ sesi, 50+ psikolog), dan *Why Choose MentalUX* |
| `/psychologists` | Publik | Pencarian nama psikolog secara langsung dan katalog kartu profil psikolog terverifikasi |
| `/education` | Publik | *Knowledge Hub* berisi embed video edukasi YouTube dan daftar artikel kesehatan mental |
| `/education/{slug}` | Publik | Halaman baca artikel lengkap beserta fitur *Share This Article* |
| `/login` | Guest | Autentikasi pengguna dengan email, password, *Remember Me*, dan *Forgot Password* |
| `/register` | Guest | Pendaftaran akun baru dengan pemilihan *Role* (`Customer`, `Psychologist`, `Admin`) |
| `/customer/dashboard` | Customer | Ringkasan profil aktif, status *Active/Upcoming Session*, dan pintasan *Find Expert* |
| `/booking/{psychologist_id}` | Customer | Pemilihan tanggal kalender dan slot waktu konsultasi (10.00–21.00 WIB) |
| `/payment/{order_id}` | Customer | Halaman *checkout* dengan *Order ID* (`#TRX-xxxx`), *countdown timer* 15 menit, tab QRIS & Transfer Bank |
| `/chat/{session_id}` | Customer & Psychologist | Ruang konsultasi dua arah dengan indikator *Online*, lampiran file, dan tombol *End Session* |
| `/psychologist/dashboard` | Psychologist | Informasi pendapatan bulanan, *banner* status verifikasi, dan daftar *Upcoming Appointments* |
| `/psychologist/certificate` | Psychologist | Form manajemen dan unggah dokumen sertifikat izin praktik (PDF, maks. 10 MB) |
| `/admin/dashboard` | Admin | Statistik *Total Users*, *Psychologists*, *Total Sessions*, dan navigasi *Management Tools* |
| `/admin/verifications` | Admin | Tabel verifikasi sertifikat psikolog (pratinjau PDF, tanggal unggah, status *Pending/Verified*, tombol aksi) |

## Teknologi

| Bagian | Spesifikasi |
| --- | --- |
| Framework | Laravel (MVC Architecture) |
| Bahasa Pemrograman | PHP 8.2+ |
| UI & Styling | Bootstrap 5, Custom CSS, Blade Templating Engine |
| Interaktivitas & Ikon | Vanilla JavaScript, Bootstrap Icons / FontAwesome |
| Database | MySQL / MariaDB |
| Autentikasi & Keamanan | Laravel Auth, Session & Cookie Management, Role Middleware, Password Hashing (Bcrypt) |
| File Storage | Laravel Local/Public Storage (`storage:link` untuk berkas PDF sertifikat psikolog) |
| Web Server | Apache / Nginx / PHP Built-in Development Server |

## Setup lokal

Yang dibutuhkan: PHP >= 8.2, Composer, MySQL, dan Git.

```bash
git clone [https://github.com/Szyken/MentalUX.git](https://github.com/Szyken/MentalUX.git)
```

```bash
cd MentalUX
```

```bash
composer install
```

```bash
cp .env.example .env
```

Sesuaikan konfigurasi database MySQL di dalam file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mentalux
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan perintah inisialisasi aplikasi dan migrasi tabel:

```bash
php artisan key:generate
```

```bash
php artisan migrate --seed
```

```bash
php artisan storage:link
```

```bash
php artisan serve
```

Buka <http://localhost:8000>. Perintah `php artisan storage:link` wajib dijalankan agar file PDF sertifikat yang diunggah psikolog dapat dibuka oleh Admin melalui tombol **Lihat PDF**.

| Perintah | Fungsi |
| --- | --- |
| `php artisan serve` | Menjalankan server pengembangan lokal di port 8000 |
| `php artisan migrate:fresh --seed` | Mereset ulang seluruh tabel database dan mengisi data *dummy* awal |
| `php artisan storage:link` | Membuat *symbolic link* dari `storage/app/public` ke `public/storage` |
| `php artisan route:list` | Menampilkan daftar lengkap seluruh *endpoint* dan *middleware* |

## Struktur project

```text
MentalUX/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php           Login, Register multi-role, dan Logout
│   │   │   ├── HomeController.php           Beranda, About, Direktori Psikolog, dan Edukasi
│   │   │   ├── CustomerController.php       Dashboard pelanggan, Booking jadwal, dan Pembayaran
│   │   │   ├── PsychologistController.php   Dashboard psikolog dan Upload sertifikat PDF
│   │   │   ├── AdminController.php          Dashboard admin, Verifikasi PDF, dan Kelola Artikel
│   │   │   └── ChatController.php           Ruang konsultasi chat dan pengakhiran sesi
│   │   └── Middleware/
│   │       └── RoleMiddleware.php           Proteksi halaman berdasarkan role pengguna
│   └── Models/
│       ├── User.php                         Data akun dan relasi role (customer/psychologist/admin)
│       ├── PsychologistProfile.php          Spesialisasi, tarif per sesi, dan path file sertifikat
│       ├── Appointment.php                  Data jadwal konsultasi, slot jam, dan status sesi
│       ├── Transaction.php                  Order ID (#TRX), metode bayar (QRIS/Bank), dan status
│       ├── Message.php                      Riwayat percakapan di ruang chat konsultasi
│       └── Article.php                      Konten artikel edukasi dan embed video kesehatan mental
├── database/
│   ├── migrations/                          Skema tabel database MySQL
│   └── seeders/                             Data awal psikolog, artikel edukasi, dan akun testing
├── public/
│   ├── assets/                              Logo MentalUX, foto profil psikolog, gambar artikel, QRIS
│   └── css/                                 Kustomisasi gaya Bootstrap 5
├── resources/
│   └── views/
│       ├── layouts/                         Header (Navbar), Footer, dan template utama Blade
│       ├── auth/                            Halaman Login dan Sign Up
│       ├── pages/                           Home, About, Psychologist, dan Education
│       ├── customer/                        Dashboard, Booking, Payment, dan Chat Room
│       ├── psychologist/                    Dashboard psikolog dan form Manajemen Sertifikat
│       └── admin/                           Admin Dashboard dan tabel Verifikasi Sertifikat
└── routes/
    └── web.php                              Definisi seluruh routing web dan grup middleware
```

## Mengubah konten & konfigurasi

| Yang ingin diubah | File | Catatan |
| --- | --- | --- |
| Paket harga sesi beranda | `resources/views/pages/home.blade.php` | Bagian *Our Session Packages* (*Starter*, *Progress*, *Complete*) |
| Slot jam konsultasi | `app/Http/Controllers/CustomerController.php` | Empat slot default: `10.00-12.00`, `13.00-15.00`, `16.00-18.00`, `19.00-21.00` WIB |
| Batas ukuran file sertifikat | `app/Http/Controllers/PsychologistController.php` | Validasi aturan upload: `mimes:pdf|max:10240` (maksimal 10 MB) |
| Data awal psikolog & artikel | `database/seeders/DatabaseSeeder.php` | Jalankan `php artisan db:seed` setelah mengubah isi data |
| Gambar QRIS & nomor rekening | `resources/views/customer/payment.blade.php` | Mengatur tampilan tab QRIS (`NMID`) dan rekening Transfer Bank |
| Link navigasi atas & bawah | `resources/views/layouts/app.blade.php` | Navbar (`About`, `Psychologist`, `Education`) dan *Quick Navigation* footer |

## Panduan tampilan

Gaya visual **MentalUX** dirancang bersih dan menenangkan (*calming interface*) menggunakan kombinasi warna biru medis dan latar belakang netral agar nyaman diakses oleh pengguna dengan berbagai tingkat literasi digital.

| Elemen | Kode Warna | Pemakaian |
| --- | --- | --- |
| Primary Blue | `#2563EB` / `#0D6EFD` | Banner utama (*Hero*), tombol CTA utama (*Get Started*, *Book Now*, *Login*), dan teks sorotan |
| Soft Ice Blue | `#CFE2FF` / `#F0F5FF` | Latar belakang halaman autentikasi (*Login* & *Sign Up*) serta kartu informasi jadwal |
| Dark Navy | `#1E2433` | Latar kartu pembayaran QRIS dan area *Footer* |
| Status Badges | `#198754` (Hijau), `#FFC107` (Kuning), `#DC3545` (Merah) | Indikator status *Verified / Confirmed*, *Pending*, dan tombol *End Session* / *Reject* |

## Tim pengembang (Kelompok 2 — IS513-B)

| Nama | NIM | Peran Utama |
| --- | --- | --- |
| **Ferdy Nugraha Oey** | 00000122523 | Web Developer (Laravel Migration & Backend), UI/UX Design, System Requirements & Deployment |
| **Ahmad Fikram Salman** | 00000117731 | System Architecture, Wireframing & Market Development Analysis |
| **Hanif Afan Harits** | 00000117698 | System Implementation, Business Process & Financial Modeling |
| **Carla Ophelia Tioho** | 00000122090 | SDLC Methodology, Business Flow Chart & Problem Identification |
| **Michaela Eleonora** | 00000130277 | System Testing, Risk Assessment, Security Policy (WAF) & Competitor Analysis |
