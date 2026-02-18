# SARAH (Sahabat Ramadhan)

**SARAH (Sahabat Ramadhan)** adalah Aplikasi Monitoring Kegiatan Ramadhan berbasis Web yang dirancang untuk membantu sekolah dalam memantau kegiatan ibadah siswa selama bulan suci Ramadhan. Aplikasi ini memudahkan siswa dalam melaporkan kegiatan harian mereka dan memudahkan guru serta wali kelas dalam melakukan validasi dan rekapitulasi nilai.

---

## Fitur Utama

### 1. 🎓 Siswa
*   **Input Kegiatan Harian**: Melaporkan kegiatan shalat 5 waktu, shalat tarawih, puasa, tadarus Al-Qur'an, dan ringkasan kultum/ceramah.
*   **Upload Bukti Foto**: Fitur upload foto kegiatan (misal: saat tarawih atau sahur/buka) sebagai bukti kehadiran.
*   **Riwayat Kegiatan**: Melihat daftar kegiatan yang sudah diinput beserta status validasinya.
*   **Edit Laporan**: Dapat memperbaiki laporan jika belum divalidasi oleh guru (khusus hari yang sama).
*   **Lihat Nilai**: Memantau persentase kelengkapan ibadah harian.

### 2. Guru PAI / Admin
*   **Validasi Kegiatan**: Memeriksa laporan siswa yang masuk (Pending) dan memberikan status **Valid** (Disetujui) atau **Ditolak**.
*   **Daftar Nilai**: Melihat rekapitulasi nilai harian siswa berdasarkan kelengkapan pengisian kegiatan.
*   **Filter Data**: Filter laporan berdasarkan Kelas dan Tanggal.
*   **Cetak Laporan**: Mencetak rekap nilai harian.

### 3. Wali Kelas
*   **Monitoring Kelas**: Memantau grafik perkembangan kegiatan siswa di kelasnya.
*   **Rekap Kelas**: Melihat ringkasan keaktifan siswa per kelas.

### 4. Administrator
*   **Manajemen User**: Tambah, Edit, Hapus data user (Siswa, Guru, Walas).
*   **Import Data Siswa**: Fitur import data siswa secara massal menggunakan file CSV.
*   **Manajemen Kelas**: Mengelola data kelas dan wali kelas.
*   **Profil Sekolah**: Mengatur data instansi (Nama Sekolah, Logo, Kepala Sekolah) untuk keperluan kop surat laporan.

---

## Persyaratan Sistem (Requirements)

Agar aplikasi dapat berjalan dengan baik, pastikan komputer Anda memenuhi syarat berikut:

*   **Web Server**: XAMPP (Direkomendasikan) atau Apache/Nginx.
*   **PHP Version**: Minimal PHP 7.4 atau PHP 8.0+.
*   **Database**: MySQL / MariaDB.
*   **Browser**: Google Chrome, Mozilla Firefox, atau Microsoft Edge terbaru.

---

## Panduan Instalasi

Ikuti langkah-langkah berikut untuk menginstall aplikasi di komputer Anda (Windows dengan XAMPP):

### Langkah 1: Download & Ekstrak
1.  Download source code aplikasi ini (ZIP) atau clone menggunakan Git:
    ```bash
    git clone https://github.com/karira212/sarah.git
    ```
2.  Ekstrak folder (jika ZIP) dan letakkan di dalam folder `htdocs` pada instalasi XAMPP Anda (biasanya di `C:\xampp\htdocs\`).
3.  Ubah nama folder menjadi `sarah` (opsional, tapi disarankan agar sesuai panduan ini).

### Langkah 2: Persiapan Database
1.  Buka **XAMPP Control Panel** dan nyalakan **Apache** dan **MySQL**.
2.  Buka browser dan akses `http://localhost/phpmyadmin`.
3.  Buat database baru dengan nama `sarah_db`.

### Langkah 3: Konfigurasi Aplikasi
1.  Buka folder aplikasi `sarah` di Text Editor (VS Code, Notepad++, dll).
2.  Cari file bernama `.env.example`, lalu copy dan rename menjadi `.env`.
3.  Buka file `.env` tersebut dan sesuaikan konfigurasi database:
    ```env
    # Konfigurasi Environment (development / production)
    CI_ENVIRONMENT = development

    # Base URL (Sesuaikan dengan folder Anda)
    app.baseURL = 'http://localhost/sarah/'

    # Konfigurasi Database
    database.default.hostname = localhost
    database.default.database = sarah_db
    database.default.username = root
    database.default.password = 
    database.default.DBDriver = MySQLi
    ```

### Langkah 4: Install Dependencies & Setup Database
Buka terminal (Command Prompt/PowerShell), arahkan ke folder project (`cd C:\xampp\htdocs\sarah`), lalu jalankan perintah berikut secara berurutan:

1.  **Install Library (Jika menggunakan Composer)**:
    ```bash
    composer install
    ```
    *(Jika Anda mendownload versi full vendor, langkah ini bisa dilewati)*

2.  **Migrasi Database (Membuat Tabel)**:
    ```bash
    php spark migrate
    ```

3.  **Isi Data Awal (Seeding)**:
    ```bash
    php spark db:seed MainSeeder
    ```
    *Perintah ini akan membuat akun default untuk Admin, Guru, Walas, dan Siswa.*

### Langkah 5: Jalankan Aplikasi
1.  Pastikan Apache & MySQL di XAMPP sudah berjalan.
2.  Buka browser dan akses:
    **`http://localhost/sarah/`**

---

## Akun Default (Login)

Gunakan akun berikut untuk mencoba aplikasi setelah instalasi (password sama untuk semua: `password`):

| Role | Username | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | `password` | Akses penuh sistem |
| **Guru Agama** | `guru` | `password` | Validasi kegiatan & lihat nilai |
| **Wali Kelas** | `walas` | `password` | Monitoring kelas |
| **Siswa** | `siswa` | `password` | Input kegiatan harian |

> **Penting:** Segera ganti password atau buat user baru setelah berhasil login demi keamanan.

---

## Struktur Folder Penting

*   `app/` : Kode utama aplikasi (Controller, Model, View).
*   `public/` : File aset publik (namun di konfigurasi ini sudah di-tweak agar root project bisa diakses langsung).
*   `uploads/` : Tempat penyimpanan foto bukti kegiatan siswa.
    *   *Pastikan folder `uploads` memiliki izin tulis (write permission) agar siswa bisa upload foto.*

---

## Troubleshooting (Masalah Umum)

*   **Error "Whoops!"**:
    *   Pastikan file `.env` sudah di-rename dari `.env.example` dan konfigurasi database benar.
    *   Pastikan mode `CI_ENVIRONMENT` di `.env` adalah `development` untuk melihat pesan error yang lebih jelas.
*   **Gambar/Style Tidak Muncul**:
    *   Cek pengaturan `app.baseURL` di file `.env`. Pastikan diakhiri dengan garis miring `/` (contoh: `http://localhost/sarah/`).
*   **Tidak Bisa Upload Foto**:
    *   Cek folder `uploads` di root project. Jika belum ada, buat folder `uploads` dan di dalamnya buat folder `activities`.

---

**Dibuat dengan ❤️ untuk kemudahan Ibadah Ramadhan. -->> 081287172216 untuk aplikasi pendidikan lainnya : LMS, CBT Sinta, Mansur, Sikap (Sistem Kesiswaan) **
*Semoga bermanfaat dan menjadi amal jariyah.*
