# Web Admin - Sistem Informasi SDM & Payroll (PT. Sumber Pelita Sukses)

Repositori ini berisi kode sumber untuk Sistem Informasi Manajemen SDM dan Penggajian (_Payroll_) berbasis web pada **PT. Sumber Pelita Sukses**. Dashboard admin ini berfungsi sebagai pusat kendali data karyawan, pemrosesan persetujuan (_approval_) permohonan cuti dan lembur, serta rekapitulasi laporan penggajian perusahaan.

---

## 🚀 Fitur Utama

### 1. Manajemen Data Karyawan

- **CRUD Data Karyawan:** Pengelolaan data identitas lengkap (NIK, No. KTP, No. Rekening, Bagian, Jabatan, Status Kerja, dll.).
- **Import & Search:** Fitur pencarian cepat dan impor data karyawan secara massal menggunakan berkas Excel.
- **Laporan Cetak:** Ekspor rekapitulasi data karyawan lengkap ke format PDF (mode Landscape A4).

### 2. Pengelolaan Pengajuan Cuti & Lembur

- **Panel Approval:** Verifikasi permohonan cuti dan tambahan lembur karyawan dengan status _Pending_, _Diterima_, dan _Ditolak_.
- **Verifikasi Bukti Digital:** Peninjauan berkas bukti surat keterangan (Sakit, Hamil, Haid, Haji/Umrah, dan Cuti Penting) yang diunggah karyawan.
- **Alasan Penolakan:** Form input alasan resmi dari admin jika pengajuan ditolak.
- **Rekap Laporan:** Cetak rekapitulasi pengajuan cuti dan lembur berdasarkan filter status (_Pending_, _Diterima_, _Ditolak_).

### 3. Penggajian & Slip Gaji (Payroll)

- **Komponen Gaji Lengkap:** Kalkulasi Gaji Pokok, Tunjangan (Jabatan, Skill, Bagian, Kehadiran), Uang Makan, serta Potongan (Absensi, BPJS Ketenagakerjaan, BPJS Kesehatan, Pensiun, PPh 21, dan COS).
- **Take Home Pay (THP):** Perhitungan otomatis total gaji bersih yang diterima karyawan.
- **Rekapitulasi Penggajian:** Cetak laporan rekap gaji bulanan per periode (Bulan/Tahun) yang dilengkapi ringkasan total pengeluaran payroll perusahaan.

---

## 🛠️ Stack Teknologi

- **Language:** PHP (Native)
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap, jQuery
- **Reporting:** Native Browser Print-to-PDF Engine

---

## ⚙️ Panduan Instalasi & Konfigurasi

### 1. Persyaratan Sistem

- Web Server (Apache / Nginx / XAMPP / cPanel)
- PHP versi 7.4 atau yang lebih baru
- Database Server MySQL / MariaDB

### 2. Langkah Setup Lokal

1. **Clone Repositori**
   ```bash
   git clone [https://github.com/b1theaven/HR-and-Payroll.git](https://github.com/b1theaven/HR-and-Payroll.git)
   ```

````

2. **Import Database**

- Buat database baru di MySQL (misal: `test_db`).
- Impor berkas database SQL yang tersedia ke dalam phpMyAdmin/MySQL.

3. **Konfigurasi Koneksi Database**
   Buka berkas `koneksi.php` dan sesuaikan kredensial server Anda.

4. **Jalankan Aplikasi**
   Pindahkan folder proyek ke direktori web server Anda (`htdocs` / `www`), lalu akses melalui browser:
   `http://localhost/NAMA-FOLDER/`

---

Tinggal kamu sesuaikan link `git clone` dan nama database SQL-nya di berkas tersebut!

```

```
````
