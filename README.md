# GIDI Mission Aviation

**PT. Sayap Kasih Injili** — Website resmi penerbangan misi Gereja Injili di Indonesia (GIDI) dengan sistem donasi, blog, dan admin dashboard.

> *"Be The Light"*

---

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Database:** SQLite
- **Frontend:** Tailwind CSS 4 (via Vite), Alpine.js 3
- **Icons:** Font Awesome 6
- **Editor:** TinyMCE 6 Free (jsDelivr CDN, tanpa API key)
- **Chart:** Chart.js 4 — grafik pengunjung
- **Image Processing:** PHP GD — auto convert ke WebP + kompresi
- **Bahasa:** Bahasa Indonesia sebagai bahasa dasar sistem

---

## Database Schema

| Tabel | Deskripsi |
|---|---|
| `users` | id, name, email, password, **role** (admin/guest), avatar, timestamps |
| `categories` | id, name, slug, timestamps |
| `posts` | id, user_id (FK), title, slug, excerpt, content, featured_image, is_published, published_at, timestamps, **deleted_at** |
| `category_post` | category_id, post_id — pivot many-to-many |
| `donations` | id, donor_name, donor_phone, donor_email, package (level_01/level_02/level_03/custom), custom_amount, commitment_type (pledge/paid), payment_method (transfer/cash), transfer_proof, admin_proof, status (pending/confirmed/rejected), notes, confirmed_by (FK), confirmed_at, timestamps, **deleted_at** |
| `testimonials` | id, donation_id (FK nullable), name, role_title, content, visibility (public/anonymous), is_approved, is_featured, timestamps, **deleted_at** |
| `visitor_logs` | id, ip_address, user_agent, page, visited_at |
| `site_settings` | id, key, value, type (text/image/json), timestamps |
| `sliders` | id, title, subtitle, description, button_text, button_link, image, sort_order, is_active, timestamps, **deleted_at** |
| `services` | id, title, description, icon, color, sort_order, timestamps, **deleted_at** |
| `partners` | id, name, full_name, logo, url, sort_order, timestamps, **deleted_at** |
| `pages` | id, slug, title, content, timestamps |

---

## Fase 1: Foundation & Auth

- Install Laravel 12 dengan SQLite database
- Setup Vite + Tailwind CSS 4 + Alpine.js 3 + Font Awesome 6
- Semua migrations & models dengan relationships (User, Category, Post, Donation, Testimonial, VisitorLog, SiteSetting, Slider, Service, Partner, Page)
- Sistem autentikasi login-only (tanpa register) dengan role middleware
  - **Admin** — akses penuh ke semua fitur dashboard
  - **Guest** — hanya bisa melihat dashboard dan rekap data
- Seeder berisi data default: admin user, konten dari template, testimoni, layanan, mitra kerja, pengaturan situs, halaman statis

## Fase 2: Visitor Frontend (Publik)

- **Layout utama** — Navbar sticky dengan scroll behavior, footer dengan link halaman statis
- **Homepage one-page** — Semua section dalam satu halaman:
  - Slider/Banner (auto-rotate dengan progress bar)
  - Tentang Kami (dengan background image & ayat Alkitab)
  - Yang Kami Lakukan (5 layanan penerbangan)
  - Penggalangan Dana (program pembelian pesawat)
  - Pernyataan Presiden GIDI
  - Info Pesawat Cessna Grand Caravan C208B
  - Paket Donasi (4 pilihan)
  - Info Rekening Bank (dengan tombol salin)
  - Formulir Donasi (transfer/cash, upload bukti, testimoni)
  - Kontak (2 contact person + info kantor + sosial media)
  - Testimoni Mitra
  - Mitra Kerja (6 logo partner)
- **Blog** — Halaman listing, detail artikel, pencarian, filter dropdown (kategori, A-Z, rentang tanggal)
- **Halaman Statis** — Kebijakan Privasi, FAQ, Peta Situs
- **Visitor Tracking** — Middleware otomatis mencatat IP, user agent, halaman, waktu kunjungan
- **Loading Screen** — Spin logo animasi saat halaman dimuat
- **Responsive Design** — Mobile, tablet, desktop mengikuti gaya template asli

## Fase 3: Admin Dashboard

- **Layout Admin** — Sidebar navigation (collapsible di mobile), topbar dengan info user
- **Dashboard** — Rekap data (total donasi, pending, terkonfirmasi, total artikel) + grafik pengunjung (harian/mingguan/bulanan/tahunan) via Chart.js
- **Blog Management** — CRUD artikel dengan TinyMCE editor, upload featured image, multi-kategori
- **Kategori Management** — CRUD kategori dengan inline edit
- **Donasi Management** — List/filter/search donasi, konfirmasi/tolak, admin upload bukti transfer, detail view
- **Testimoni Management** — List testimoni, toggle approve/reject, toggle unggulan, edit konten
- **Slider Management** — CRUD slider/banner
- **Service Management** — CRUD layanan "Yang Kami Lakukan"
- **Partner Management** — CRUD mitra kerja dengan upload logo
- **Pengaturan Situs** — Edit informasi kontak, rekening bank, sosial media, kutipan presiden
- **Halaman Statis** — Edit Kebijakan Privasi, FAQ, Sitemap via TinyMCE
- **User Management** — List user, dropdown ubah role, tambah user baru, hapus user
- **Soft Delete / Tempat Sampah** — Semua data (artikel, donasi, testimoni, slider, layanan, mitra) memiliki fitur tempat sampah dengan pulihkan & hapus permanen
- **Upload Gambar** — Drag & drop dengan preview, auto convert ke WebP, kompresi file besar
- **Logo & Favicon** — Upload logo dan favicon situs melalui pengaturan admin
- **Modal Konfirmasi** — Custom modal Tailwind + Alpine.js menggantikan `confirm()` browser

## Fase 4: Guest Role

- Guest hanya bisa akses: Dashboard (view only) — rekap data & grafik pengunjung
- Tidak bisa mengakses menu admin (blog, donasi, testimoni, pengaturan, dll)
- Middleware restriction per route group

## Fase 5: Polish & Enhancement

- **SEO Optimization** — Meta tags (Open Graph, Twitter Card), canonical URL, robots meta di setiap halaman publik
- **Social Media Sharing** — Tombol share ke Facebook, Twitter/X, WhatsApp, Telegram, dan copy link di halaman blog
- **Jumlah Pembaca Blog** — Counter views per artikel dengan increment otomatis saat dikunjungi
- **Visitor Counter di Beranda** — Menampilkan total pengunjung website di homepage
- **Error Pages** — Halaman error kustom (401, 403, 404, 419, 429, 500, 503) dengan desain konsisten
- **TinyMCE CSS Fix** — Perbaikan styling konten TinyMCE di halaman publik dan blog agar tampil konsisten
- **Footer Login/Dashboard** — Link login di footer untuk pengunjung, link Dashboard + nama user untuk yang sudah login
- **Admin Donasi** — Form tambah donasi manual oleh admin dengan upload bukti transfer

---

## Instalasi (Development)

### Prasyarat

- PHP >= 8.2 (dengan ekstensi GD untuk konversi WebP)
- Composer
- Node.js >= 18 & npm

### Langkah-langkah

```bash
# 1. Clone repository
git clone <repo-url>
cd 199-gidi-mission-aviation

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Buat database SQLite
touch database/database.sqlite

# 5. Jalankan migrasi & seeder
php artisan migrate:fresh --seed

# 6. Buat storage link
php artisan storage:link

# 7. Build assets
npm run build

# 8. Jalankan server
php artisan serve
```

Buka `http://localhost:8000` di browser.

---

## Deploy ke Production

### Prasyarat Server

- PHP >= 8.2 (dengan ekstensi: GD, SQLite3, mbstring, openssl, tokenizer, xml, ctype, json, bcmath)
- Composer
- Node.js >= 18 & npm (untuk build assets)
- Web server (Nginx atau Apache)

### Langkah Deploy

```bash
# 1. Clone & masuk ke direktori
git clone <repo-url> /var/www/gidi-mission-aviation
cd /var/www/gidi-mission-aviation

# 2. Install dependencies (production)
composer install --optimize-autoloader --no-dev
npm install

# 3. Setup environment production
cp .env.example .env
php artisan key:generate

# 4. Edit .env untuk production
# Ubah nilai berikut di file .env:
#   APP_ENV=production
#   APP_DEBUG=false
#   APP_URL=https://domain-anda.com

# 5. Buat database SQLite
touch database/database.sqlite

# 6. Jalankan migrasi & seeder
php artisan migrate --seed

# 7. Buat storage link
php artisan storage:link

# 8. Build assets untuk production
npm run build

# 9. Optimasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 10. Set permission
chmod -R 775 storage bootstrap/cache database
chown -R www-data:www-data storage bootstrap/cache database
```

### Konfigurasi Nginx

```nginx
server {
    listen 80;
    server_name domain-anda.com;
    root /var/www/gidi-mission-aviation/public;

    index index.php;
    charset utf-8;
    client_max_body_size 20M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known) {
        deny all;
    }
}
```

### Update di Production (saat pengembangan berlanjut)

```bash
cd /var/www/gidi-mission-aviation

# Pull perubahan code terbaru
git pull origin main

# Install dependencies baru (jika ada)
composer install --optimize-autoloader --no-dev
npm install

# Jalankan migrasi TANPA fresh (agar data production aman)
php artisan migrate

# JANGAN gunakan migrate:fresh di production!
# migrate:fresh akan MENGHAPUS semua data!

# Build ulang assets
npm run build

# Clear & rebuild cache
php artisan optimize:clear
php artisan optimize
```

### Catatan Penting Production

- **Database SQLite** (`database/database.sqlite`) sudah di-`.gitignore` — tidak akan tertimpa saat `git pull`
- **Folder uploads** (`public/uploads/`) juga di-`.gitignore` — file yang diupload admin aman saat deploy
- **Jangan gunakan `migrate:fresh`** di production — ini akan menghapus semua data. Gunakan `migrate` saja
- **Seeder menggunakan `updateOrCreate`** — aman di-re-run tanpa membuat data duplikat
- **Visitor logs** tersimpan di database lokal, tidak terpengaruh git push/pull
- **Backup database** secara berkala: `cp database/database.sqlite database/backup-$(date +%Y%m%d).sqlite`

---

## Akun Default

| Role | Email | Password |
|---|---|---|
| Admin | `admin@gidimissionaviation.com` | `password` |
| Guest | `guest@gidimissionaviation.com` | `password` |

---

## Struktur Route

### Publik

| URL | Deskripsi |
|---|---|
| `/` | Homepage (one-page) |
| `/blog` | Blog listing (pencarian, filter kategori, sort, rentang tanggal) |
| `/blog/{slug}` | Detail artikel |
| `/halaman/{slug}` | Halaman statis (kebijakan-privasi, faq, sitemap) |
| `/login` | Halaman login |

### Admin

| URL | Deskripsi |
|---|---|
| `/admin` | Dashboard (rekap data + grafik pengunjung) |
| `/admin/posts` | Manajemen blog |
| `/admin/posts/trash` | Tempat sampah blog |
| `/admin/categories` | Manajemen kategori |
| `/admin/donations` | Manajemen donasi |
| `/admin/donations/trash` | Tempat sampah donasi |
| `/admin/testimonials` | Manajemen testimoni |
| `/admin/testimonials/trash` | Tempat sampah testimoni |
| `/admin/sliders` | Manajemen slider |
| `/admin/sliders/trash` | Tempat sampah slider |
| `/admin/services` | Manajemen layanan |
| `/admin/services/trash` | Tempat sampah layanan |
| `/admin/partners` | Manajemen mitra kerja |
| `/admin/partners/trash` | Tempat sampah mitra |
| `/admin/settings` | Pengaturan situs (umum + logo/favicon) |
| `/admin/settings/pages` | Edit halaman statis |
| `/admin/users` | Manajemen pengguna |

---

## Konten dari Template

Semua konten berikut dari `_template/index.html` telah di-seed ke database:

- Teks dan informasi organisasi GIDI Mission Aviation / PT. Sayap Kasih Injili
- 5 layanan penerbangan (Penginjilan, Layanan Gerejawi, Misi Kemanusiaan, Distribusi Logistik, Rekanan Misi)
- Informasi kontak (Capt. Buce Sub, Capt. Yotam Pahabol)
- Rekening bank (Mandiri Kcp Sentani - PT. Sayap Kasih Injili)
- Pernyataan Presiden GIDI (Pdt. Usman Kobak, S.Th, MA.)
- 4 testimoni (Capt. Buce Sub, Janzen Faidiban, Natalia Rumbewas, Demianus Wasage)
- 6 mitra kerja (GIDI, YAPELIN, STT GIDI, STAKIN GIDI, OKMC, YASUMAT)
- Ayat Alkitab (Kisah Para Rasul 1:8)
- Informasi pesawat Cessna Grand Caravan (C208B)
- 5 artikel contoh terkait organisasi
- 4 donasi contoh terintegrasi dengan testimoni

---

## Fitur Tambahan

- **Auto WebP** — Semua gambar yang diupload otomatis dikonversi ke format WebP dengan kompresi
- **Drag & Drop Upload** — Upload gambar dengan drag & drop + preview instan (blog, slider, pengaturan)
- **Soft Delete** — Tempat sampah di 6 module (blog, donasi, testimoni, slider, layanan, mitra) dengan pulihkan & hapus permanen
- **Custom Modal** — Konfirmasi hapus menggunakan modal Tailwind + Alpine.js
- **Loading Screen** — Animasi spin logo saat halaman dimuat
- **Visitor Counter** — Grafik pengunjung harian/mingguan/bulanan/tahunan via Chart.js + counter di beranda
- **Responsive** — Semua halaman (visitor + admin) dioptimasi untuk mobile, tablet, dan desktop
- **Dynamic Logo/Favicon** — Logo dan favicon situs bisa diubah dari admin pengaturan
- **SEO** — Meta tags lengkap (Open Graph, Twitter Card, canonical URL) di semua halaman publik
- **Social Sharing** — Tombol share artikel ke media sosial (Facebook, X, WhatsApp, Telegram)
- **Blog View Counter** — Jumlah pembaca per artikel blog
- **Error Pages** — Halaman error kustom (401, 403, 404, 419, 429, 500, 503)
- **Footer Auth Link** — Link login/dashboard di footer berdasarkan status autentikasi user

---

## Lisensi

Proyek ini dikembangkan untuk GIDI Mission Aviation.

Powered by [Nokensoft.com](https://nokensoft.com)
