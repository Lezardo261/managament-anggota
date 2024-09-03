# Aplikasi Kehadiran 

## Deskripsi

Aplikasi Kehadiran ini adalah solusi komprehensif untuk manajemen absensi dan tugas yang dirancang untuk mempermudah administrasi serta pemantauan kehadiran dan tugas. Aplikasi ini menawarkan fitur lengkap untuk admin dan pengguna, termasuk pengaturan pengguna, jadwal absensi, dan penyerahan tugas. Tujuannya adalah untuk meningkatkan efisiensi dan kemudahan dalam manajemen kehadiran dan tugas.

Aplikasi ini dirancang khusus untuk kegiatan ekstrakurikuler (eskul). Saat ini, aplikasi ini hanya mendukung manajemen untuk satu eskul saja dan belum mendukung fitur multi-eskul. Pengembangan untuk mendukung multi-eskul sedang dipertimbangkan.


## Fitur

### Untuk Admin:
1. **Manajemen User**: Mengatur daftar pengguna, termasuk penambahan, pengeditan, dan penghapusan user.
2. **Jadwal Absensi**: Membuat dan mengelola jadwal absensi sehingga pengguna dapat melakukan absensi sesuai waktu yang ditentukan.
3. **Pembuatan Tugas**: Membuat dan mengelola tugas untuk penyerahan oleh pengguna, termasuk penjadwalan tugas.
4. **Monitoring Absensi dan Sakit**: Melihat data absensi dan izin sakit dari pengguna, termasuk laporan detail.
5. **Penyerahan Tugas**: Memantau pengguna yang telah menyerahkan tugas dan statusnya.
6. **Ekspor Data**: Menyediakan fitur ekspor data absensi ke dalam format yang dapat diunduh untuk analisis lebih lanjut, termasuk nama, kehadiran, sakit, dan izin.

### Untuk Pengguna:
1. **Penyerahan Tugas**: Menyerahkan tugas sesuai dengan jadwal yang ditetapkan.
2. **Absensi dengan Wajah**: Melakukan absensi dengan menggunakan foto wajah untuk autentikasi kehadiran.
3. **Pengajuan Sakit atau Izin**: Mengajukan permohonan sakit atau izin dengan mudah.
4. **Edit Profil**: Mengubah informasi profil pribadi seperti nama, email, dan lainnya.

## Manfaat

Dengan Aplikasi Kehadiran, administrasi kehadiran dan manajemen tugas menjadi lebih efisien. Aplikasi ini membantu administrator untuk memantau kehadiran dan status tugas dengan lebih baik, serta memberikan kemudahan kepada pengguna dalam mengelola absensi dan tugas mereka. Ini sangat cocok untuk organisasi yang membutuhkan solusi terintegrasi untuk manajemen kehadiran dan tugas.

## Teknologi

- **Backend**: Laravel 11
- **Frontend**: Inertia.js
- **Autentikasi**: Laravel Breeze
- **Database**: MySQL

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan aplikasi ini di lingkungan lokal Anda:

1. **Clone Repository**:
    ```bash
    git clone https://github.com/Lezardo261/managament-anggota.git
    ```

2. **Install Dependencies**:
    ```bash
    cd managament-anggota
    composer install
    npm install
    ```

3. **Konfigurasi Environment**:
    Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database dan lainnya:
    ```bash
    cp .env.example .env
    ```

4. **Generate Key**:
    ```bash
    php artisan key:generate
    ```

5. **Run Migrations**:
    ```bash
    php artisan migrate
    ```

6. **Install Laravel Breeze**:
    ```bash
    php artisan breeze:install
    npm install && npm run dev
    ```

7. **Start Server**:
    ```bash
    php artisan serve
    ```

## Penggunaan

Untuk mulai menggunakan aplikasi, buka browser Anda dan akses ` http://127.0.0.1:8000.`. Anda akan melihat halaman login yang diatur oleh Laravel Breeze. Setelah login, Anda akan diarahkan ke dashboard sesuai dengan peran Anda (admin atau pengguna).

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, ikuti langkah-langkah berikut:

1. Fork repository ini.
2. Buat branch baru untuk fitur atau perbaikan yang ingin Anda tambahkan.
3. Lakukan perubahan dan commit.
4. Kirim pull request dengan deskripsi perubahan yang telah Anda buat.

## Kontak

Jika Anda memiliki pertanyaan atau umpan balik, silakan hubungi saya di [lezardo261@gmail.com]
