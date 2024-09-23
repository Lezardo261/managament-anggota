# Aplikasi Kehadiran Ekstrakurikuler

## Deskripsi
Aplikasi Kehadiran Ekstrakurikuler adalah solusi komprehensif untuk manajemen absensi dan tugas yang dirancang khusus untuk kegiatan ekstrakurikuler (eskul). Aplikasi ini menawarkan fitur lengkap untuk admin dan anggota eskul, termasuk pengaturan pengguna, jadwal absensi, dan penyerahan tugas. Tujuannya adalah untuk meningkatkan efisiensi dan kemudahan dalam manajemen kehadiran dan tugas ekstrakurikuler.

### Versi Aplikasi
- **v1.0 (Versi Lama)**: Mendukung manajemen untuk satu eskul.
- **v2.0 (Versi Saat Ini)**: Mendukung manajemen multi-eskul.

#### Perbedaan Utama v1.0 dan v2.0:
1. **Dukungan Multi-Eskul**: v2.0 memungkinkan pengelolaan beberapa ekstrakurikuler dalam satu aplikasi.
2. **Peningkatan Manajemen User**: Penambahan fitur untuk mengatur peran user di berbagai eskul.
3. **Dashboard Terpadu**: Tampilan dashboard yang lebih komprehensif untuk melihat informasi dari berbagai eskul.
4. **Laporan Terintegrasi**: Kemampuan untuk menghasilkan laporan yang mencakup data dari beberapa eskul.
5. **Peningkatan Performa**: Optimisasi untuk menangani data dari multiple eskul secara efisien.

## Fitur

### Untuk Admin:
1. **Manajemen User**: 
   - Mengatur daftar pengguna, termasuk penambahan, pengeditan, dan penghapusan user.
   - Mengassign user ke satu atau lebih eskul.
   - Mengatur peran user dalam setiap eskul (misalnya: admin eskul, anggota).
2. **Jadwal Absensi**: Membuat dan mengelola jadwal absensi untuk setiap eskul.
3. **Pembuatan Tugas**: Membuat dan mengelola tugas untuk penyerahan oleh anggota, termasuk penjadwalan tugas per eskul.
4. **Monitoring Absensi dan Izin**: 
   - Melihat data absensi, izin sakit, dan izin lainnya dari anggota, termasuk laporan detail.
   - Filter dan tampilan data berdasarkan eskul.
5. **Penyerahan Tugas**: Memantau anggota yang telah menyerahkan tugas dan statusnya untuk setiap eskul.
6. **Ekspor Data**: 
   - Menyediakan fitur ekspor data absensi ke dalam format Excel (.xlsx).
   - Data yang diekspor mencakup: nama anggota, kehadiran, sakit, dan izin.
   - Memungkinkan admin untuk menganalisis data absensi secara lebih mendalam menggunakan fitur-fitur Excel.
   - Opsi untuk mengekspor data dari satu eskul atau multiple eskul sekaligus.

### Untuk Anggota:
1. **Penyerahan Tugas**: Menyerahkan tugas sesuai dengan jadwal yang ditetapkan untuk setiap eskul yang diikuti.
2. **Absensi dengan Wajah**: Melakukan absensi dengan menggunakan foto wajah untuk autentikasi kehadiran di setiap eskul.
3. **Pengajuan Sakit atau Izin**: Mengajukan permohonan sakit atau izin dengan mudah, dengan opsi untuk mengaplikasikan ke satu atau semua eskul yang diikuti.
4. **Edit Profil**: Mengubah informasi profil pribadi seperti nama, email, dan lainnya.
5. **Tampilan Multi-Eskul**: Melihat jadwal, tugas, dan informasi lain untuk semua eskul yang diikuti dalam satu tampilan terpadu.

## Manfaat
Dengan Aplikasi Kehadiran Ekstrakurikuler v2.0, administrasi kehadiran dan manajemen tugas menjadi lebih efisien, terutama untuk sekolah atau organisasi yang mengelola beberapa kegiatan ekstrakurikuler. Aplikasi ini membantu administrator untuk memantau kehadiran dan status tugas di berbagai eskul dengan lebih baik, serta memberikan kemudahan kepada anggota dalam mengelola absensi dan tugas mereka di semua eskul yang diikuti. Fitur ekspor data ke Excel memungkinkan analisis mendalam dan pelaporan yang lebih fleksibel, sangat bermanfaat untuk evaluasi dan pengambilan keputusan terkait kegiatan ekstrakurikuler secara keseluruhan.

## Teknologi
- **Backend**: Laravel 11
- **Frontend**: Inertia.js dengan Vue.js
- **Autentikasi**: Laravel Breeze
- **Database**: MySQL
- **Ekspor Data**: Menggunakan library Laravel Excel untuk menghasilkan file Excel

## Instalasi
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

6. **symlink storage**:
   ```bash
    php artisan storage:link
   ```

7. **Start Server**:
   ```bash
   php artisan serve
   ```

## Penggunaan
Untuk mulai menggunakan aplikasi, buka browser Anda dan akses `http://127.0.0.1:8000`. Anda akan melihat halaman login yang diatur oleh Laravel Breeze. Setelah login, Anda akan diarahkan ke dashboard sesuai dengan peran Anda (admin atau anggota) dan eskul yang Anda ikuti atau kelola, untuk mengatur peran anda bisa mengaturnya melalui Database sekaligus juga untuk menambahkan nama-nama eskulnya bisa anda lakukan didatabase

## Rencana Pengembangan
1. **Sistem Kelas Terpisah**:
   - Membuat tabel terpisah untuk kelas.
   - Implementasi sistem yang memungkinkan perubahan kelas tanpa mempengaruhi data historis.
   - Menyimpan riwayat kelas siswa, sehingga data lama tetap akurat (misalnya, data kelas 10 akan tetap tercatat sebagai kelas 10 meski siswa sudah naik kelas).

2. **Tahun Ajaran**:
   - Menambahkan fitur tahun ajaran untuk mengorganisir data berdasarkan periode akademik.
   - Memungkinkan pembuatan laporan dan analisis berdasarkan tahun ajaran.

3. **Detail Eskul**:
   - Menambahkan fitur untuk menyimpan informasi detail tentang setiap eskul, termasuk:
     - Data pembina eskul
     - Informasi ketua eskul
     - Deskripsi dan tujuan eskul


![UML](https://github.com/user-attachments/assets/815d6f66-6fee-402a-bcc9-c0d880b11e37)
![ERD](https://github.com/user-attachments/assets/6ca8148f-f235-48d8-bd18-a27dfb6db81b)

## Kontribusi
Jika Anda ingin berkontribusi pada proyek ini, ikuti langkah-langkah berikut:
1. Fork repository ini.
2. Buat branch baru untuk fitur atau perbaikan yang ingin Anda tambahkan.
3. Lakukan perubahan dan commit.
4. Kirim pull request dengan deskripsi perubahan yang telah Anda buat.

## Kontak
Jika Anda memiliki pertanyaan atau umpan balik, silakan hubungi kami di [lezardo261@gmail.com](mailto:lezardo261@gmail.com)

## Lisensi
Aplikasi ini dilisensikan di bawah [MIT License](LICENSE).
