# [Bug] Fix 'Unknown column nama' Error on Authentication & Profile Tests

## 📝 Background / Konteks
Saat ini kita sedang mengembangkan aplikasi web untuk pengajuan "Perubahan Data PDDIKTI" di PUSTIK Universitas Halu Oleo menggunakan stack **Laravel 12.42 + Vite** [3]. 
Dalam proses integrasi fitur Autentikasi dan Profil pengguna, ditemukan kegagalan masif saat menjalankan pengujian otomatis (19 failed, 6 passed) [2].

## 🐛 Bug Description
Saat mengeksekusi perintah `php artisan test`, muncul error `QueryException` pada hampir seluruh *test case* yang berkaitan dengan Auth (Registration, Login, Email Verification, Password Reset) dan Profile Update [1, 4-6].

**Error log utama:**
`SQLSTATE[42S22]: Column not found: 1054 Unknown column 'nama' in 'field list' (Connection: mysql, SQL: insert into users (nama, email, ...)` [1, 7, 8]

## 🔍 Root Cause Analysis (Asumsi)
Terdapat ketidaksesuaian (*mismatch*) antara penamaan kolom pada tabel `users`. Bawaan otentikasi Laravel secara *default* menggunakan bahasa Inggris yaitu kolom `name`, namun struktur kode atau database sepertinya telah diubah ke bahasa Indonesia yaitu `nama` [1]. Ketidaksinkronan ini terjadi di antara *Migration, Model, Factory,* atau *Controller*.

## ✅ Acceptance Criteria (Definition of Done)
1. Semua 19 *test* yang sebelumnya gagal (Auth & Profile) harus `PASS` saat perintah `php artisan test` dijalankan [2].
2. Sistem dapat melakukan *register*, *login*, dan *update profile* menggunakan kolom `nama` tanpa memunculkan `QueryException`.
3. Skema *database* harus tetap sinkron dengan *Model* dan *Factory* bawaan Laravel.

## 🛠️ Technical Tasks / Checklist untuk Programmer
Tolong lakukan pengecekan dan perbaikan pada file-file berikut agar semuanya menggunakan standar kolom `nama`:

- [ ] **Database Migration:** Buka `database/migrations/xxxx_xx_xx_xxxxxx_create_users_table.php`, ubah `$table->string('name');` menjadi `$table->string('nama');`.
- [ ] **User Model:** Buka `app/Models/User.php`, pada bagian properti `$fillable`, pastikan `'name'` diubah menjadi `'nama'`.
- [ ] **User Factory:** Buka `database/factories/UserFactory.php`, ubah *key* array *dummy data* dari `'name' => fake()->name()` menjadi `'nama' => fake()->name()`.
- [ ] **Auth Controllers & Requests:** 
    - Cek `app/Http/Controllers/Auth/RegisteredUserController.php` (atau file *controller* registrasi sejenis), pastikan validasi dan input *request* menggunakan `nama`.
    - Cek `app/Http/Requests/ProfileUpdateRequest.php` (jika menggunakan Breeze), pastikan validasi menggunakan aturan untuk `nama`.
- [ ] **Views (Opsional):** Pastikan form HTML di *blade files* untuk register dan edit profil (`name="nama"`) sudah sinkron dengan *controller*.
- [ ] **Terminal/CLI:** Jalankan `php artisan migrate:fresh --seed` (atau jalankan ulang database *testing*) dan eksekusi `php artisan test` untuk memastikan semua *error* terselesaikan.

## 💬 Notes for AI Programmer
Mohon periksa seluruh *checklist* di atas dan berikan *snippet* kode perbaikannya untuk masing-masing *file* yang terdampak. Berikan jawaban yang ringkas namun komprehensif.