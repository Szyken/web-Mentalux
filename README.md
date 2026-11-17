# MentalUX

Platform Konsultasi Psikologi dan Kesehatan Mental Berbasis Web, dibuat untuk proyek mata kuliah IS513-B E-Business Program Studi Sistem Informasi, Universitas Multimedia Nusantara.

> **Support for You & Your Loved Ones.** Mewujudkan Kesehatan Mental untuk Semua — menggabungkan empati manusia dengan kemudahan teknologi untuk menciptakan ruang aman bagi siapa saja.

Repo ini berisi seluruh kode sumber aplikasi web **MentalUX** yang telah dimigrasi dari native PHP ke framework **Laravel** dengan sistem autentikasi multi-role (`Customer`, `Psychologist`, `Admin`), manajemen jadwal konsultasi, simulasi pembayaran QRIS/Transfer Bank, ruang chat sesi konsultasi, serta verifikasi dokumen sertifikat psikolog (PDF).

## Preview

<img width="1917" height="907" alt="Screenshot 2026-11-17 113333" src="https://github.com/user-attachments/assets/f2830c30-a5be-4b39-887e-80fe3070e9a5" />

| Tentang Kami (Our Story) | Direktori & Pencarian Psikolog |
| --- | --- |
| <img width="1917" height="910" alt="Screenshot 2026-11-17 113355" src="https://github.com/user-attachments/assets/d676faa1-05ee-4b6c-b6b3-b20828f46332" /> | <img width="1917" height="910" alt="Screenshot 2026-11-17 113408" src="https://github.com/user-attachments/assets/e306237d-208c-441f-a9af-f88976e6fa75" /> |

| Pusat Edukasi (Knowledge Hub) | Artikel & Tips Kesehatan Mental |
| --- | --- |
| <img width="1917" height="901" alt="Screenshot 2026-11-17 115813" src="https://github.com/user-attachments/assets/7260f12a-4248-4fee-949e-ade712218e32" /> | <img width="1917" height="911" alt="Screenshot 2026-11-17 113441" src="https://github.com/user-attachments/assets/5e150156-18ab-4da5-95fa-94ff5333d119" /> |

| Halaman Login | Halaman Sign Up (Multi-Role) |
| --- | --- |
| <img width="1917" height="898" alt="Screenshot 2026-11-17 113449" src="https://github.com/user-attachments/assets/6078c7e2-c1c4-431b-b45e-64a1aa11b12b" /> | <img width="1917" height="896" alt="Screenshot 2026-11-17 113505" src="https://github.com/user-attachments/assets/da7ac491-0be4-4ee2-afac-4dc09bedcfce" /> |

| Customer Dashboard | Pemilihan Jadwal & Slot Jam Konsultasi |
| --- | --- |
| <img width="1917" height="912" alt="Screenshot 2026-11-17 113846" src="https://github.com/user-attachments/assets/de007135-8c19-4506-b16f-0284a5cb073d" /> | <img width="1917" height="902" alt="Screenshot 2026-11-17 113904" src="https://github.com/user-attachments/assets/13d19054-8442-46b7-ba2a-893005adbf3f" /> |

| Pembayaran QRIS & Transfer Bank | Ruang Chat Konsultasi Real-Time |
| --- | --- |
| <img width="1917" height="912" alt="Screenshot 2026-11-17 113929" src="https://github.com/user-attachments/assets/01ee914b-0ee8-44b1-b5d6-8dc27f393794" /> | !<img width="1917" height="913" alt="Screenshot 2026-11-17 113940" src="https://github.com/user-attachments/assets/137e7d7c-b780-4693-b0d6-d37782e3168d" /> |

| Psychologist Dashboard | Upload Sertifikat Praktik Psikolog |
| --- | --- |
| <img width="1917" height="917" alt="Screenshot 2026-11-17 120026" src="https://github.com/user-attachments/assets/2b17b36c-de81-44cf-b6f8-1e200b45d3ae" /> | <img width="1917" height="912" alt="Screenshot 2026-11-17 120053" src="https://github.com/user-attachments/assets/c7eaf604-7f66-40ed-84d8-3b37165d160b" /> |

| Admin Dashboard | Verifikasi Sertifikat Psikolog (Admin) |
| --- | --- |
| <img width="1917" height="913" alt="Screenshot 2026-11-17 120140" src="https://github.com/user-attachments/assets/b527d533-093c-46eb-99b2-7ee1d9de3962" /> | <img width="1917" height="906" alt="Screenshot 2026-11-17 120204" src="https://github.com/user-attachments/assets/da39cc25-c193-4d04-bbe9-b7a6e5e0b361" /> |

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


| Nama | NIM | Peran Utama |
| --- | --- | --- |
| **Ferdy Nugraha Oey** | Web Developer (Laravel Migration & Backend), UI/UX Design, System Requirements & Deployment |
| **Ahmad Fikram Salman** | System Architecture, Wireframing & Market Development Analysis |
| **Hanif Afan Harits** | System Implementation, Business Process & Financial Modeling |
| **Carla Ophelia Tioho** | SDLC Methodology, Business Flow Chart & Problem Identification |
| **Michaela Eleonora** | System Testing, Risk Assessment, Security Policy (WAF) & Competitor Analysis |
