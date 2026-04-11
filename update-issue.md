# TASK: Proyek UHO-Datasync Rebranding & Peningkatan Spesifikasi Fungsional

## Metadata
- **Prioritas:** Kritis / Tinggi
- **Assignee:** Junior Programmer AI (Agent)
- **Proyek:** Laravel 11.x (Berbasis dari 'Sistem Lapor PDDIKTI')

## Deskripsi Masalah
AI Agent yang sebelumnya bekerja telah membangun fondasi aplikasi, tetapi implementasinya terlalu generic (masih menggunakan nama bawaan Laravel) dan deskripsi tentang latar belakang masalah serta solusi yang ditawarkan (misalnya di landing page) kurang tegas dan mendalam. Selain itu, logo Universitas Halu Oleo (UHO) belum diintegrasikan ke dalam sistem.

## Perintah Kerja & Checklist Implementasi

Harap jalankan instruksi ini dengan teliti dan tegas. Jangan melewatkan satu item pun.

### PHASE 1: Rebranding & Ganti Nama Aplikasi (Kritis)

Instruksi: Ubah semua referensi nama aplikasi dari yang lama menjadi nama baru: `UHO-Datasync`.

- [ ] Ganti `APP_NAME` di file `.env` menjadi: `APP_NAME="UHO-Datasync"`.
- [ ] Ganti nama aplikasi di file konfigurasi `config/app.php` jika ada teks yang di-hardcode.
- [ ] Lakukan scan di semua file Blade (`resources/views/`) dan ganti teks "Sistem Lapor PDDIKTI" atau sejenisnya menjadi "UHO-Datasync".

### PHASE 2: Integrasi Logo UHO & Visual Branding

Instruksi: Logo UHO harus digunakan di seluruh sistem (Landing Page, Halaman Login, Dashboard Header) menggantikan logo default Laravel atau teks standar.

**Referensi File Logo:**
- Path Asal: `F:\uho-datasync\storage\app\public\Logo-UHO-Normal-1.png`

- [ ] **Langkah Konfigurasi Utama:**
    - Pastikan file logo `Logo-UHO-Normal-1.png` benar-benar ada di `storage/app/public/`.
    - Jalankan perintah terminal: `php artisan storage:link` (jika belum dilakukan) untuk memastikan logo tersebut dapat diakses secara publik melalui URL.

- [ ] **Halaman Landing (`resources/views/welcome.blade.php` atau sejenisnya):**
    - Cari bagian header/navbar, ganti logo default dengan tag `<img>` yang mengarah ke `{{ asset('storage/Logo-UHO-Normal-1.png') }}`. Atur ukuran (`height`) agar proporsional.

- [ ] **Halaman Login & Register:**
    - Ganti **gambar logo besar** yang muncul saat login menggunakan file logo UHO tersebut. Jangan biarkan logo default Laravel muncul di halaman ini.

- [ ] **Halaman Dashboard (`resources/views/dashboard.blade.php` atau master layout-nya):**
    - Ganti logo/teks di pojok kiri atas header dashboard dengan logo UHO.

### PHASE 3: Penegasan Deskripsi Latar Belakang & Solusi

Instruksi: Deskripsi di landing page (misalnya pada section "Tentang Sistem") harus diperbarui menjadi jauh lebih formal, tegas, dan mendalam untuk mencerminkan urgensi aplikasi ini. Ganti deskripsi lama dengan teks di bawah ini secara verbatim (kata per kata).

- [ ] **Update Konten Latar Belakang (Section "Tentang Sistem"):**
    - Temukan elemen deskripsi untuk "Tentang Sistem" di landing page, lalu ganti total dengan teks berikut:

---
> Era transformasi digital menuntut institusi pendidikan tinggi untuk terus berinovasi dalam mengelola administrasi akademik yang efisien, transparan, dan akuntabel. Pangkalan Data Pendidikan Tinggi (PDDIKTI) pusat merupakan pusat rujukan data nasional yang memegang peranan vital dalam memastikan keabsahan status akademik seorang mahasiswa. Validitas data di PDDIKTI sangat menentukan berbagai aspek krusial dalam siklus kehidupan akademik mahasiswa, mulai dari pendaftaran beasiswa, validasi ijazah, pendaftaran program Kampus Merdeka, hingga persyaratan seleksi Calon Pegawai Negeri Sipil (CPNS). Oleh karena itu, ketidaksesuaian data akademik yang disebabkan oleh kesalahan proses manual konvensional dapat berdampak fatal bagi mahasiswa.
>
> Di Universitas Halu Oleo (UHO), Unit Penunjang Akademik Teknologi Informasi dan Komunikasi (UPA TIK) adalah muara dari seluruh proses perbaikan data mahasiswa sebelum disinkronisasikan ke PDDIKTI pusat. UHO-Datasync hadir sebagai platform terintegrasi untuk mendigitalisasi proses pelayanan ini secara 'end-to-end'. Melalui implementasi fitur manajemen dokumen dinamis yang menyeleksi kelengkapan berkas prasyarat secara otomatis sesuai kategori permohonan, serta dilengkapi dengan dasbor pemantauan real-time bagi mahasiswa, UHO-Datasync mentransformasi birokrasi manual menjadi alur kerja digital yang terukur dan akuntabel. Kehadiran aplikasi ini mempercepat proses sinkronisasi data kementerian guna mendukung perwujudan visi smart campus di Universitas Halu Oleo.
---

### PHASE 4: Finalisasi & Pengujian

- [ ] Jalankan `php artisan cache:clear`, `php artisan view:clear`, dan `php artisan config:clear` untuk memastikan perubahan nama aplikasi terlihat.
- [ ] Jalankan server (`php artisan serve`) dan verifikasi secara visual:
    - Apakah nama tab browser sudah berubah menjadi "UHO-Datasync"?
    - Apakah logo UHO sudah muncul di landing page, login, dan dashboard header?
    - Apakah deskripsi tentang sistem sudah diperbarui dengan teks yang baru?

## Penutup
Laksanakan task ini dengan presisi. Perubahan nama dan logo adalah identitas utama proyek ini. Kembalikan log/status setelah task selesai dijalankan.