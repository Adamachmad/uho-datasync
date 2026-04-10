<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor PDDIKTI - Data Diri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0">Langkah 1: Lengkapi Data Diri</h4>
            <small>Sebelum mengajukan perubahan, isi data identitas Anda.</small>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('pengaju.store') }}" method="POST">
                @csrf
                
                <h5 class="text-primary mb-3">A. Identitas Kependudukan & Akun</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control" placeholder="16 Digit NIK" required maxlength="16">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password (Untuk Login Nanti) <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <h5 class="text-primary mb-3 mt-4">B. Data Mahasiswa</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Sesuai KTM" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIM <span class="text-danger">*</span></label>
                        <input type="text" name="nim" class="form-control" placeholder="Contoh: E1E1..." required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jurusan / Prodi <span class="text-danger">*</span></label>
                        <input type="text" name="jurusan" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Aktif <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="email@uho.ac.id" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">No. HP / WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat domisili saat ini..." required></textarea>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan & Lanjut ke Dashboard</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>