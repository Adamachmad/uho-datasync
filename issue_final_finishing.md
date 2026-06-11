# [Feature] Implementasi Fitur Inti Pengajuan Perubahan Data PDDIKTI & Finishing UI

## 📝 Background / Konteks
Terima kasih, perbaikan *bug database* sebelumnya sudah berhasil. Saat ini seluruh 25 *test* (Auth & Profile) sudah `PASS` 100%. 
Sekarang kita masuk ke tahap *finishing* proyek aplikasi "Perubahan Data PDDIKTI" untuk PUSTIK Universitas Halu Oleo menggunakan **Laravel 12.42 + Vite**. 
Sistem autentikasi sudah selesai, sehingga kita perlu membangun inti dari aplikasi ini: formulir pengajuan bagi pengguna (mahasiswa/staf) dan *dashboard* untuk memantau status pengajuan.

## 🎯 Objective (Tujuan)
1. Pengguna yang sudah *login* dapat mengisi form perubahan data PDDIKTI dan mengunggah dokumen persyaratan (KTP, Ijazah, dll).
2. Pengguna dapat melihat riwayat dan status pengajuan mereka (Pending, Disetujui, Ditolak).
3. Melakukan *finishing* antarmuka (UI) menggunakan kombinasi TailwindCSS (via Vite) agar sesuai dengan desain modern yang nyaman digunakan (merujuk pada variabel *Tampilan* EUCS kita yang memprioritaskan UI/UX).

## ✅ Acceptance Criteria (Definition of Done)
1. Tabel `pengajuans` berhasil dibuat dan berelasi dengan tabel `users`.
2. Pengguna dapat melakukan aksi *Create* (mengirim pengajuan) dan *Read* (melihat riwayat pengajuan).
3. Sistem dapat menangani *file upload* dengan aman dan menyimpannya di *storage* lokal Laravel.
4. Tampilan aplikasi dirapikan dengan *build* aset Vite.

## 🛠️ Technical Tasks / Checklist untuk Programmer
Tolong buatkan kode lengkap dan instruksi langkah demi langkah untuk menyelesaikan tugas berikut:

- [ ] **Migration & Model:** 
    - Buat *model* dan *migration* `Pengajuan`. 
    - Struktur tabel minimal: `id`, `user_id` (foreign key), `jenis_perubahan` (string), `keterangan_lama` (text), `keterangan_baru` (text), `file_dokumen` (string/path), `status` (enum: pending, approved, rejected, default: pending), dan `timestamps`.
- [ ] **Controller:** 
    - Buat `PengajuanController` yang berisi *method* `index` (menampilkan riwayat pengguna), `create` (menampilkan form), dan `store` (validasi input & proses *upload file* ke `storage/app/public`).
- [ ] **Routing:** 
    - Daftarkan *route resource* atau *manual routes* untuk `pengajuan` di `routes/web.php` yang dibungkus dengan *middleware* `auth`.
- [ ] **Blade Views & UI Finishing (Vite):** 
    - Buatkan *file* *view* `pengajuan/index.blade.php` (tabel riwayat) dan `pengajuan/create.blade.php` (form input dengan `enctype="multipart/form-data"`).
    - Pastikan kelas-kelas Tailwind pada form dirancang dengan rapi.
- [ ] **Storage Link:**
    - Ingatkan saya perintah terminal untuk menautkan *storage* agar dokumen bisa diakses jika diperlukan.

## 💬 Notes for AI Programmer
Fokus pada fungsionalitas pengajuan dasar dan keamanan unggahan dokumen (hanya menerima PDF/JPG, maks 2MB). Berikan *snippet* kode yang rapi dan terstruktur agar bisa langsung saya implementasikan.
