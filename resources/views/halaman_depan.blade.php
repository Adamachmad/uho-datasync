<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor PDDIKTI - Data Diri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f0f2f5; }
        .card-header { background: linear-gradient(45deg, #0d6efd, #0a58ca); color: white; }
        .required::after { content: " *"; color: red; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-primary shadow-sm mb-5">
        <div class="container">
            <span class="navbar-brand mb-0 h1"><i class="bi bi-mortarboard-fill"></i> Sistem Lapor PDDIKTI</span>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header py-3 text-center">
                        <h4 class="mb-0">Identitas Pengaju</h4>
                        <small>Silakan lengkapi data diri dan password untuk akses dashboard.</small>
                    </div>
                    
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('identitas.store') }}" method="POST">
                            @csrf

                            <h6 class="text-primary mb-3"><i class="bi bi-person-lock"></i> Akun & Validasi</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required">NIK (KTP)</label>
                                    <input type="text" name="nik" class="form-control" 
                                           placeholder="16 Digit Angka" 
                                           required 
                                           maxlength="16" 
                                           minlength="16"
                                           inputmode="numeric" 
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <small class="text-muted" style="font-size: 11px">Wajib 16 digit angka.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Buat password login" required>
                                </div>
                            </div>

                            <hr>

                            <h6 class="text-primary mb-3"><i class="bi bi-mortarboard"></i> Data Akademik</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" placeholder="Sesuai KTM" required maxlength="100">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">NIM</label>
                                    <input type="text" name="nim" class="form-control" placeholder="Contoh: F1G1..." required maxlength="20">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">Jurusan / Program Studi</label>
                                <input type="text" name="jurusan" class="form-control" placeholder="Contoh: Teknik Informatika" required maxlength="50">
                            </div>

                            <hr>

                            <h6 class="text-primary mb-3"><i class="bi bi-telephone"></i> Kontak & Domisili</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label required">Email Aktif</label>
                                    <input type="email" name="email" class="form-control" placeholder="email@uho.ac.id" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label required">No. HP / WhatsApp</label>
                                    <input type="text" name="no_hp" class="form-control" 
                                           placeholder="08..." 
                                           required 
                                           maxlength="15"
                                           inputmode="numeric"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label required">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="2" placeholder="Jalan, Kelurahan, Kecamatan..." required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    Simpan & Lanjut <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>