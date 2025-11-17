# LAPORAN TUGAS CI/CD & PENGUJIAN OTOMATIS
Aplikasi CRUD Kontak Sederhana

## 1. Nama Proyek & Fitur yang Diuji
Nama proyek: CRUD Kontak Sederhana  
Fitur yang diuji:
- Create (Tambah kontak)
- Read (Menampilkan kontak)
- Update (Edit kontak)
- Delete (Hapus kontak)
- Search (Pencarian data)

Semua fitur diuji secara otomatis melalui pipeline GitHub Actions.

## 2. Tools & Framework yang Digunakan
- Bahasa: PHP Native
- Database: MySQL
- CI/CD: GitHub Actions
- Automated Testing: PHP script (test_api.php)
- Web server: PHP Built-in Server

## 3. Cara Kerja Pipeline
1. GitHub Actions aktif setiap push ke branch main.
2. Runner menyalakan service MySQL.
3. File database `kontak(2).sql` di-import otomatis.
4. `api.php` dipakai sebagai backend CRUD.
5. PHP built-in server dijalankan pada port 8000.
6. Script `tests/test_api.php` memanggil API dan menguji:
   - GET seluruh data
   - POST tambah data
   - GET memastikan data berhasil dibuat
   - PUT update data
   - DELETE hapus data
   - GET memastikan data terhapus
7. Jika semua langkah berhasil → pipeline berstatus "Passed".

## 4. Perbandingan Pengujian Manual vs Otomatis

### Pengujian Manual:
- Harus membuka browser / Postman
- Perlu mengetik input satu per satu
- Tidak cepat untuk diulang-ulang
- Rawit & mudah salah
- Tidak cocok untuk project besar

### Pengujian Otomatis:
- Langsung dijalankan hanya dengan push ke GitHub
- Langkah CRUD diuji penuh secara otomatis
- Konsisten dan akurat
- Hemat waktu
- Mudah mendeteksi bug setelah modifikasi kode

## 5. Kesimpulan
Pipeline CI/CD berhasil dibuat dan menjalankan pengujian otomatis terhadap seluruh fitur CRUD dan search.  
Hasil pipeline dapat dilihat pada tab Actions di GitHub, dan menunjukkan bahwa fungsionalitas aplikasi berjalan dengan baik.
