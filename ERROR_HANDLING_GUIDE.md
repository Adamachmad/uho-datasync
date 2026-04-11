# User-Friendly Error Handling System

## Overview
Semua kesalahan input pengguna sekarang ditampilkan dengan pesan notifikasi yang user-friendly dalam Bahasa Indonesia, bukan error teknis Laravel. Sistem ini mencakup:

1. **Input Validation Errors** - Pesan yang jelas tentang apa yang salah
2. **Authentication Errors** - Pesan ramah untuk kesalahan login
3. **File Upload Errors** - Petunjuk tentang format dan ukuran file
4. **Rate Limiting** - Pesan tentang terlalu banyak percobaan login

## Komponen dan Fitur

### 1. Alert Notification Component
**File**: `resources/views/components/alert-notification.blade.php`

Component ini menampilkan:
- **Error Alerts** (Merah) - Kesalahan validasi form
- **Session Errors** (Merah) - Error dari session flash
- **Success Messages** (Hijau) - Pesan sukses
- **Close Button** - Tombol untuk menutup notifikasi

Ditampilkan di:
- Login form (`resources/views/auth/login.blade.php`)
- Register form (`resources/views/register.blade.php`)
- App layout (`resources/views/layouts/app.blade.php`) - untuk semua halaman terautentikasi
- Homepage (`resources/views/halaman_depan.blade.php`)

### 2. Login Error Messages
**File**: `app/Http/Requests/Auth/LoginRequest.php`

Pesan-pesan yang telah dikustomisasi:

| Situasi | Pesan |
|---------|-------|
| Email kosong | "Email harus diisi" |
| Password kosong | "Password harus diisi" |
| Email format tidak valid | "Format email tidak valid" |
| Email/Password tidak cocok | "Email atau password yang Anda masukkan tidak sesuai dengan data kami. Silahkan coba kembali." |
| Terlalu banyak percobaan (>5x) | "Terlalu banyak percobaan login. Silahkan coba kembali dalam X menit." |

### 3. Registration Error Messages
**File**: `app/Http/Controllers/PengajuanController.php` - method `storeIdentitas()`

Pesan-pesan validasi untuk setiap field:

| Field | Pesan Error |
|-------|------------|
| NIK | "NIK harus terdiri dari 16 angka" |
| NIM | "NIM hanya boleh berisi huruf dan angka" |
| Email | "Email harus format yang valid (contoh: user@email.com)" |
| No. HP | "Nomor HP harus dimulai dengan +62, 62, atau 0 dilanjutkan 9-12 angka" |
| Password | "Password harus mengandung kombinasi huruf besar, huruf kecil, dan angka" |
| Nama Lengkap, Alamat, Jurusan | "Field harus diisi" dan "Maksimal X karakter" |

Database constraint errors akan ditampilkan sebagai:
- "NIM, Email, atau No HP ini sudah digunakan oleh akun lain (berbeda NIK). Silakan periksa kembali data Anda."

### 4. File Upload Error Messages
**File**: `app/Http/Controllers/PengajuanController.php` - method `uploadDokumen()`

| Error | Pesan |
|-------|-------|
| File tidak diunggah | "File harus diunggah." |
| Format file salah | "Format file hanya boleh PDF atau JPG/JPEG." |
| Ukuran file > 2MB | "Ukuran file maksimal 2 MB." |
| Jenis dokumen tidak dipilih | "Jenis dokumen harus dipilih." |
| Status pengajuan tidak draft | "Tidak bisa mengupload dokumen setelah pengajuan dikirim. Status saat ini: [status_name]" |

### 5. Navigation Auth Guards
**File**: `resources/views/layouts/navigation.blade.php`

Diperbaiki menggunakan `@auth('pengaju')` directive untuk:
- Mencegah error "Attempt to read property on null"
- Menampilkan menu yang berbeda untuk user terautentikasi vs guest
- Menggunakan nama lengkap dari `Auth::guard('pengaju')->user()->nama_lengkap`

## Alur Kerja

### Flow Secara Umum:

```
User Input
    ↓
Validation (Laravel)
    ↓
Custom Error Messages (defined in controller/request)
    ↓
Redirect with errors
    ↓
Flash message di session
    ↓
Alert Notification Component menampilkan pesan user-friendly
```

### Contoh: Login Gagal

```
1. User klik login dengan email/password salah
2. LoginRequest::authenticate() throw ValidationException dengan message user-friendly
3. Request redirect ke login page dengan error
4. alert-notification component menampilkan error di red alert box
5. User melihat pesan: "Email atau password yang Anda masukkan tidak sesuai dengan data kami. Silahkan coba kembali."
```

### Contoh: Registrasi Gagal

```
1. User submit register dengan password "abc123" (tanpa huruf besar)
2. Validation gagal dengan custom message
3. Request redirect ke register page dengan error
4. alert-notification component menampilkan list error
5. User melihat: "Password harus mengandung kombinasi huruf besar, huruf kecil, dan angka"
```

## Styling

Notifikasi menggunakan **Bootstrap 5** dan **custom Tailwind** styling:

### Error Alert (Merah)
- Background: `#fee2e2` (red-50)
- Border: `#fca5a5` (red-200)
- Text: `#7f1d1d` (red-800)
- Icon: Error/X symbol

### Success Alert (Hijau)
- Background: `#dcfce7` (green-50)
- Border: `#bbf7d0` (green-200)
- Text: `#166534` (green-800)
- Icon: Checkmark symbol

### Features:
- Closable (tombol X di kanan)
- Responsive design
- Auto-dismiss after user interaction
- Clear visual hierarchy

## Implementasi untuk Developer

### Untuk menambah error baru di controller:

```php
return back()->withErrors([
    'field_name' => 'Pesan error yang user-friendly dalam Bahasa Indonesia'
])->withInput();
```

### Untuk menambah success message:

```php
return redirect()->route('target')->with('success', 'Operasi berhasil dilakukan');
```

### Untuk menambah error dari session flash:

```php
return redirect()->route('target')->with('error', 'Terjadi kesalahan saat memproses data');
```

## Testing Checklist

- [ ] Login dengan email kosong → Muncul "Email harus diisi"
- [ ] Login dengan password kosong → Muncul "Password harus diisi"
- [ ] Login dengan email/password salah → Muncul pesan ramah
- [ ] Login 6+ kali gagal → Muncul "Terlalu banyak percobaan..."
- [ ] Register dengan NIK tidak 16 digit → Muncul error khusus NIK
- [ ] Register dengan password tanpa huruf besar → Muncul error khusus password
- [ ] Register dengan email duplikat → Muncul pesan tentang email sudah digunakan
- [ ] Upload file bukan PDF/JPG → Muncul "Format file hanya boleh..."
- [ ] Upload file > 2MB → Muncul "Ukuran file maksimal..."
- [ ] Close button di alert → Alert hilang

## Files Modified

1. `resources/views/components/alert-notification.blade.php` - **Created** (New component)
2. `resources/views/auth/login.blade.php` - Updated (Added alert component)
3. `resources/views/register.blade.php` - Updated (Added alert component)
4. `resources/views/layouts/app.blade.php` - Updated (Added alert component and styling)
5. `resources/views/layouts/navigation.blade.php` - Updated (Fixed @auth guards)
6. `resources/views/halaman_depan.blade.php` - Updated (Added alert component)
7. `app/Http/Requests/Auth/LoginRequest.php` - Updated (Custom error messages)
8. `app/Http/Controllers/PengajuanController.php` - Updated (Custom error messages)

## Future Enhancements

1. Multi-language support (English/Indonesia toggle)
2. Auto-dismiss alerts after X seconds
3. Toast notifications (non-blocking)
4. Inline field error highlighting
5. Client-side validation messages
