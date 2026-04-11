# TASK: Implementasi Alur Status Pengajuan & Fitur Penolakan (UHO-Datasync)

## Metadata
- **Prioritas:** Kritis / Tinggi
- **Assignee:** Junior Programmer AI (Agent)
- **Konteks:** Sistem UHO-Datasync (Laravel 11.x). Implementasi State Machine / Alur status pengajuan mahasiswa dari pengiriman hingga selesai/ditolak.

## Deskripsi Masalah & Tujuan
Saat ini alur pengajuan dokumen mahasiswa perlu didefinisikan secara ketat. Sistem harus mampu melacak posisi dokumen mahasiswa secara real-time. Jika dokumen bermasalah atau data tidak valid, Admin PUSTIK UHO harus bisa menolak pengajuan tersebut dan memberikan "Pesan Alasan" yang spesifik agar mahasiswa tahu apa yang harus diperbaiki.

## Definisi Status Pengajuan (Wajib Diikuti)
Berikut adalah daftar urutan status resmi yang harus diimplementasikan di database dan UI:

1. **`TERKIRIM_PUSTIK`**: Teks Tampilan -> *"Pengajuan perubahan data terkirim ke pustik UHO"* (Status awal saat mahasiswa menekan tombol kirim).
2. **`VERIFIKASI_PUSTIK`**: Teks Tampilan -> *"Telah diverifikasi oleh admin pustik"* (Admin sedang mengecek keabsahan dokumen).
3. **`TERKIRIM_PDDIKTI`**: Teks Tampilan -> *"Terkirim ke pusat pangkalan data di PDDIKTI"* (Data valid, dikirim ke kementerian).
4. **`SELESAI`**: Teks Tampilan -> *"Pengajuan data telah berhasil, perubahan sudah dilakukan"* (Final).
5. **`DITOLAK`**: Teks Tampilan -> *"Pengajuan Ditolak"* (Bisa karena ditolak PUSTIK atau PDDIKTI, wajib disertai alasan).

---

## Perintah Kerja & Checklist Implementasi

### PHASE 1: Pembaruan Database & Model
- [ ] Buat file migrasi baru (atau edit migrasi yang sudah ada jika belum di-migrate) untuk tabel `pengajuan` dan `riwayat_pengajuan`.
- [ ] Pastikan kolom `status` pada tabel `pengajuan` mendukung daftar status di atas (bisa menggunakan ENUM atau String biasa).
- [ ] **PENTING:** Tambahkan kolom baru `keterangan_penolakan` (tipe teks, `nullable`) pada tabel `pengajuan` atau tabel `riwayat_pengajuan`. Kolom ini berguna untuk menampung pesan alasan dari Admin.
- [ ] Perbarui file Model terkait (misal: `Pengajuan.php` dan `RiwayatPengajuan.php`) dan tambahkan `keterangan_penolakan` ke dalam property `$fillable`.

### PHASE 2: Pembaruan Logika Controller (Sisi Admin)
- [ ] Buat/Perbarui fungsi di Controller Admin untuk mengubah status pengajuan.
- [ ] Jika Admin memilih untuk menolak (mengubah status menjadi `DITOLAK`), Controller **WAJIB** memvalidasi adanya input teks `keterangan_penolakan` dari Admin. Pesan ini tidak boleh kosong jika statusnya ditolak.
- [ ] Simpan riwayat perubahan status ini ke dalam tabel `riwayat_pengajuan`.

### PHASE 3: Pembaruan Tampilan UI (Sisi Admin & Mahasiswa)
- [ ] **UI Admin:** Pada halaman detail verifikasi pengajuan, tambahkan sebuah form/modal untuk "Update Status". Jika admin memilih opsi "Tolak", tampilkan `<textarea>` wajib isi untuk menuliskan "Alasan Penolakan (Dari PUSTIK/PDDIKTI)".
- [ ] **UI Mahasiswa (Dashboard):** Pada halaman *tracking* status/riwayat mahasiswa:
    - Ubah label status sesuai dengan teks bahasa Indonesia pada bagian 'Definisi Status' di atas.
    - Berikan indikator warna yang jelas (Misal: Kuning untuk diproses, Hijau untuk Selesai, Merah untuk Ditolak).
    - **Jika status Ditolak**, tampilkan sebuah alert berwarna merah (`alert-danger`) yang berisi teks: **"Pengajuan Anda ditolak dengan alasan: [Tampilkan isi dari keterangan_penolakan]"**.

### PHASE 4: Pengujian & Validasi
- [ ] Simulasikan alur kerja dari mahasiswa membuat pengajuan baru.
- [ ] Simulasikan admin menolak pengajuan dengan mengisi pesan error.
- [ ] Pastikan pesan error muncul di dashboard mahasiswa bersangkutan.
- [ ] Lanjutkan simulasi hingga pengajuan berstatus Selesai ("Pengajuan data telah berhasil, perubahan sudah dilakukan").

## Penutup
Laksanakan task ini dengan teliti. Pastikan relasi database untuk pencatatan riwayat aman dan teks alasan penolakan dapat dirender di halaman view mahasiswa tanpa error `null constraint`.