# Title: [TASK-01] Implementasi Migrasi & Eloquent Model: Sistem Pengajuan Perubahan Data PDDIKTI

## Description/Background
Sebagai bagian dari proyek magang di PUSTIK Universitas Halu Oleo (UHO), kita sedang mendigitalisasi proses "Perubahan Data PDDIKTI". Aplikasi ini dibangun menggunakan tech stack Laravel 12.42 + Vite dan database MySQL.

Saat ini kita sudah memiliki rancangan struktur database mentah (berupa file SQL dump `pustik_pddikti_db.sql`). Sebelum kita melanjutkan perbaikan tampilan (UI), melengkapi fitur, atau membuat halaman Login, tugas pertama dan paling krusial adalah mengimplementasikan skema SQL tersebut ke dalam standar Laravel menggunakan file Migrations, Eloquent Models, dan Seeders.

## Acceptance Criteria (DoD)
- [ ] Seluruh tabel yang ada di `pustik_pddikti_db.sql` telah dikonversi menjadi file Laravel Migration yang valid.
- [ ] *Constraint Foreign Key* (termasuk referensi dan aksi `ON DELETE CASCADE`) terdefinisi dengan tepat di file migrasi.
- [ ] File Class Eloquent Model telah dibuat untuk masing-masing tabel dengan mendefinisikan relasi antar-model secara eksplisit (seperti `hasMany`, `belongsTo`).
- [ ] Terdapat file Seeder (`DatabaseSeeder.php` dkk) untuk memasukkan *dummy data* master (seperti data `jenis_dokumen`, `jenis_pengajuan`, `status_pengajuan`, dan `syarat_pengajuan`).

## Technical Tasks/Checklist
- [ ] **Analisis SQL File**: Pelajari struktur dari `pustik_pddikti_db.sql`. 
  - **Tabel Master**: `jenis_dokumen`, `jenis_pengajuan`, `status_pengajuan`, `syarat_pengajuan`.
  - **Tabel Transaksi/User**: `pengaju`, `pengajuan`, `pengajuan_has_dokumen`, `riwayat_pengajuan`.
- [ ] **Generate Class Migration Laravel**: Buat file migrasi dengan urutan yang benar berdasarkan hierarki dependensi tabel (Tabel master harus di-migrate lebih dulu sebelum tabel transaksi yang membutuhkan *Foreign Key*).
  - Gunakan nama tabel secara spesifik agar sesuai dengan SQL dump yang ada (karena di SQL namanya singular).
  - Contoh penulisan FK: `$table->foreignId('id_pengaju')->constrained('pengaju')->onDelete('cascade');`
- [ ] **Buat Eloquent Models**: 
  - Generate model (contoh: `Pengaju`, `Pengajuan`, `JenisDokumen`, dll).
  - Di dalam Model, pastikan untuk menimpa nama tabel default Laravel yang *plural* menjadi nama singular yang ada di database menggunakan properti `protected $table = 'nama_tabel';`.
  - Tentukan properti `$fillable` atau `$guarded`.
  - Definisikan *relationship methods* (misal di model `Pengajuan` ada method `pengaju()`, `jenisPengajuan()`, dll).
- [ ] **Generate Seeder**: Implementasikan query `INSERT INTO` yang ada di dalam SQL dump menjadi sintaks Laravel Seeder (atau gunakan Model Factory jika diperlukan nanti).

## Notes for Junior
- **Standar Penamaan (Convention) Pengecualian**: Karena kita melakukan *reverse-engineering* dari SQL yang sudah ada, tabel di database menggunakan bahasa Indonesia dan format *singular* (seperti `pengaju`, bukan `pengajus`). Oleh karena itu:
  - Di Migration, tulis eksplisit nama tabelnya: `Schema::create('pengaju', function (Blueprint $table) { ... });`
  - Di Eloquent Model, deklarasikan nama tabel: `protected $table = 'pengaju';`
  - Kolom *Foreign Key* di file SQL tidak mengikuti standar Laravel `namatabel_id` melainkan `id_namatabel` (contoh: `id_pengaju`). Di file migrasi, Anda bisa menggunakan constraint manual: `$table->unsignedBigInteger('id_pengaju'); $table->foreign('id_pengaju')->references('id')->on('pengaju');`
- **Tipe Data**:
  - Perhatikan kolom `nim` di tabel `pengaju` bertipe `varchar(20)`. Gunakan tipe `string` di Laravel, jangan gunakan `integer`.
- **Persiapan Autentikasi (Login Page)**: Sistem ini nantinya membutuhkan halaman *Login*. Mahasiswa kemungkinan akan login menggunakan data di tabel `pengaju`. Namun perhatikan juga apakah admin Pustik menggunakan tabel `users` bawaan Laravel. Pastikan kedua tabel tersebut (`users` dan `pengaju`) dipersiapkan migration-nya dengan benar agar bisa disesuaikan dengan fitur Laravel Authentication/Guards nanti.

## Instruksi untuk AI Junior Programmer
Tolong kerjakan semua checklist di atas (Technical Tasks & Acceptance Criteria). Lakukan perbaikan pada file-file migrasi, model, dan seeder yang ada agar strukturnya sesuai dengan `pustik_pddikti_db.sql` dan ikuti semua konvensi yang sudah dijelaskan di bagian "Notes for Junior". Jangan ragu untuk membuat atau memperbarui file yang diperlukan.