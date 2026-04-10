<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Perubahan Data PDDIKTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f8f9fa; }
        .card-header { font-weight: bold; }
        .required::after { content: " *"; color: red; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-mortarboard-fill"></i> Lapor PDDIKTI
            </a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="text-center mb-4">
            <h2 class="text-primary fw-bold">Formulir Perubahan Data</h2>
            <p class="text-muted">Universitas Halu Oleo</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white text-primary border-bottom-0 pt-3">
                    <i class="bi bi-person-vcard"></i> A. Identitas Mahasiswa & Akun
                </div>
                <div class="card-body">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">NIK (KTP)</label>
                            <input type="number" name="nik" class="form-control" placeholder="16 Digit NIK" value="{{ old('nik') }}" required>
                            <small class="text-muted" style="font-size: 0.8rem">Digunakan untuk validasi data kependudukan.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Password Akun</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                            <small class="text-muted" style="font-size: 0.8rem">Untuk login cek status pengajuan nanti.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Sesuai KTM" value="{{ old('nama_lengkap') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">NIM</label>
                            <input type="text" name="nim" class="form-control" placeholder="Contoh: E1E1..." value="{{ old('nim') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Jurusan / Prodi</label>
                            <input type="text" name="jurusan" class="form-control" placeholder="Contoh: Teknik Informatika" value="{{ old('jurusan') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Email Aktif</label>
                            <input type="email" name="email" class="form-control" placeholder="email@uho.ac.id" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08..." value="{{ old('no_hp') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Alamat Domisili</label>
                            <textarea name="alamat" class="form-control" rows="1" required>{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white text-primary border-bottom-0 pt-3">
                    <i class="bi bi-list-check"></i> B. Jenis Perubahan Data
                </div>
                <div class="card-body">
                    <label class="form-label required">Pilih Jenis Perubahan</label>
                    <select name="jenis_pengajuan_id" id="jenis_pengajuan" class="form-select" required>
                        <option value="">-- Silakan Pilih --</option>
                        @foreach($jenisPengajuan as $jp)
                            <option value="{{ $jp->id }}" data-syarat="{{ json_encode($jp->syarat) }}">
                                {{ $jp->nama_pengajuan }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text mt-2">
                        *Syarat dokumen akan muncul otomatis setelah Anda memilih jenis perubahan.
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4" id="card-syarat" style="display: none;">
                <div class="card-header bg-white text-primary border-bottom-0 pt-3">
                    <i class="bi bi-cloud-upload"></i> C. Upload Berkas Persyaratan
                </div>
                <div class="card-body" id="container-input-dokumen">
                    </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white text-primary border-bottom-0 pt-3">
                    <i class="bi bi-pencil-square"></i> Keterangan Tambahan (Opsional)
                </div>
                <div class="card-body">
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Jelaskan detail kesalahan data Anda di sini...">{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                    <i class="bi bi-send-fill"></i> KIRIM PENGAJUAN
                </button>
            </div>

        </form>
    </div>

    <script>
        document.getElementById('jenis_pengajuan').addEventListener('change', function() {
            const container = document.getElementById('container-input-dokumen');
            const cardSyarat = document.getElementById('card-syarat');
            
            // Bersihkan isi container sebelumnya
            container.innerHTML = '';

            const selectedOption = this.options[this.selectedIndex];
            
            // Jika user memilih "Pilih..", sembunyikan card
            if (selectedOption.value === "") {
                cardSyarat.style.display = 'none';
                return;
            }

            // Ambil data syarat dari atribut data-syarat
            const syaratList = JSON.parse(selectedOption.getAttribute('data-syarat'));

            if (syaratList.length > 0) {
                cardSyarat.style.display = 'block';

                syaratList.forEach(item => {
                    const namaDokumen = item.jenis_dokumen.nama_dokumen;
                    const idJenisDokumen = item.id_jenis_dokumen;
                    const isWajib = item.is_wajib ? '<span class="text-danger">*</span>' : '(Opsional)';
                    const requiredAttr = item.is_wajib ? 'required' : '';
                    const allowedTypes = item.allowed_types.split(',').map(t => '.'+t).join(',');

                    // Buat elemen HTML input file
                    const html = `
                        <div class="mb-3 border-bottom pb-3">
                            <label class="form-label fw-bold">${namaDokumen} ${isWajib}</label>
                            <input type="file" name="berkas[${idJenisDokumen}]" class="form-control" accept="${allowedTypes}" ${requiredAttr}>
                            <div class="form-text">
                                Format: ${item.allowed_types.toUpperCase()} (Max: ${item.max_size_kb/1024} MB)
                            </div>
                        </div>
                    `;
                    container.innerHTML += html;
                });
            } else {
                cardSyarat.style.display = 'none';
                alert('Tidak ada syarat dokumen khusus untuk pilihan ini.');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>