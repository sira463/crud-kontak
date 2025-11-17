# Dokumentasi CI/CD - CRUD Kontak

## File Penting
- api.php
- index.html
- kontak(2).sql
- tests/test_api.php
- .github/workflows/ci.yml

## Cara Menjalankan CI di GitHub
1. Upload semua file ke repository GitHub (public).
2. Buka tab Actions.
3. Workflow "CI - PHP API tests" dijalankan otomatis.
4. Pastikan status hijau (Passed).

## Cara Jalankan Tes Lokal
1. Import database:
   mysql -u root -p db_kontak_sederhana < "kontak(2).sql"
2. Jalankan server:
   php -S 127.0.0.1:8000
3. Jalankan test:
   php tests/test_api.php
