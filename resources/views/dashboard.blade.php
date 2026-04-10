<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - PDDIKTI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f6f9; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); margin-bottom: 20px; }
        .card-header { background-color: #fff; border-bottom: 1px solid #eee; font-weight: 600; }
        /* Warna Status */
        .badge-status-1 { background-color: #6c757d; } /* Draft */
        .badge-status-2 { background-color: #ffc107; color: #000; } /* Diajukan */
        .badge-status-3 { background-color: #17a2b8; } /* Proses */
        .badge-status-5 { background-color: #28a745; } /* Selesai */
        .badge-status-99 { background-color: #dc3545; } /* Ditolak */
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="bi bi-mortarboard-fill"></i> Dashboard PDDIKTI</a>
            <span class="text-white">Halo, {{ $pengaju->nama_lengkap }}</span>
        </div>
    </nav>

    <div class="container pb-5">
        
        <div class="card mb-4 border-start border-5 border-primary">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3"><strong>NIK:</strong> <br> {{ $pengaju->nik }}</div>
                    <div class="col-md-3"><strong>NIM:</strong> <br> {{ $pengaju->nim }}</div>
                    <div class="col-md-3"><strong>Jurusan:</strong> <br> {{ $pengaju->jurusan }}</div>
                    <div class="col-md-3"><strong>Status:</strong> <br>
                        @if($pengajuanAktif)
                            <span class="badge badge-status-{{ $pengajuanAktif->id_status_pengajuan }}">
                                {{ $pengajuanAktif->status_pengajuan->nama_status }}
                            </span>
                        @else
                            <span class="badge bg-secondary">Belum Ada Pengajuan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-header bg-white text-primary">
                        <i class="bi bi-folder-fill"></i> Kelengkapan Dokumen
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Dokumen</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jenisDokumen as $jenis)
                                    @php
                                        $uploaded = $pengajuanAktif ? $pengajuanAktif->dokumens->where('id_jenis_dokumen', $jenis->id)->first() : null;
                                        // Dikunci jika status > 1 (Sudah diajukan)
                                        $isLocked = ($pengajuanAktif && $pengajuanAktif->id_status_pengajuan > 1); 
                                    @endphp
                                    <tr>
                                        <td>{{ $jenis->nama_dokumen }}</td>
                                        
                                        <td class="text-center">
                                            @if($uploaded)
                                                <span class="badge bg-success"><i class="bi bi-check-lg"></i> Ada</span>
                                            @else
                                                <span class="badge bg-secondary">Kosong</span>
                                            @endif
                                        </td>
                                        
                                        <td class="text-center">
                                            @if($uploaded)
                                                <a href="{{ asset('storage/'.$uploaded->path_file) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                @if(!$isLocked)
                                                <form action="{{ route('dokumen.hapus', $uploaded->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus file ini?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            @else
                                                @if(!$isLocked)
                                                    <button type="button" class="btn btn-sm btn-primary" 
                                                        onclick="bukaModalUpload({{ $jenis->id }}, '{{ $jenis->nama_dokumen }}')">
                                                        <i class="bi bi-upload"></i> Upload
                                                    </button>
                                                @else
                                                    <span class="text-muted small"><i class="bi bi-lock"></i> Terkunci</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-send"></i> Finalisasi Pengajuan
                    </div>
                    <div class="card-body">
                        @if(!$pengajuanAktif || $pengajuanAktif->id_status_pengajuan == 1)
                            
                            <form action="{{ route('pengajuan.submit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_pengajuan" value="{{ $pengajuanAktif ? $pengajuanAktif->id : '' }}">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis Perubahan Data</label>
                                    <select name="id_jenis_pengajuan" id="pilihan_jenis" class="form-select" required>
                                        <option value="" data-syarat='[]'>-- Pilih Jenis Perubahan --</option>
                                        @foreach($jenisPengajuan as $jp)
                                            <option value="{{ $jp->id }}" data-syarat="{{ json_encode($jp->syarat) }}">
                                                {{ $jp->nama_pengajuan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="alert alert-info mt-2" id="info_syarat" style="display: none; font-size: 0.9rem;">
                                    <strong><i class="bi bi-info-circle"></i> Dokumen Wajib:</strong>
                                    <ul class="mb-0 ps-3 mt-1" id="list_syarat"></ul>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Keterangan / Alasan</label>
                                    <textarea name="keterangan_user" class="form-control" rows="3" placeholder="Jelaskan detail kesalahan data Anda..."></textarea>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success" {{ (!$pengajuanAktif || $pengajuanAktif->dokumens->isEmpty()) ? 'disabled' : '' }}>
                                        <i class="bi bi-paperplane"></i> Kirim ke UPA TIK
                                    </button>
                                    @if(!$pengajuanAktif || $pengajuanAktif->dokumens->isEmpty())
                                        <small class="text-danger text-center mt-2">Upload dokumen dulu sebelum mengirim.</small>
                                    @endif
                                </div>
                            </form>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-clock-history text-warning display-4"></i>
                                <h5 class="mt-3">Sedang Diproses</h5>
                                <p class="text-muted">Pengajuan Anda sedang diperiksa petugas.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-dark text-white"><i class="bi bi-clock-history"></i> Riwayat Status</div>
            <div class="card-body">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $log->status_pengajuan->nama_status }}</td>
                            <td>{{ $log->catatan ?? '-' }}</td>
                            <td>{{ $log->created_by }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada aktivitas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpload" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dokumen.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_pengaju" value="{{ $pengaju->id }}">
                    <input type="hidden" name="id_jenis_dokumen" id="modal_id_jenis">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Upload Dokumen</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Dokumen</label>
                            <input type="text" class="form-control" id="modal_nama_jenis" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih File</label>
                            <input type="file" name="file" class="form-control" required accept=".pdf,.jpg,.jpeg">
                            <div class="form-text">Format PDF/JPG, Maksimal 2MB.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. Script Buka Modal Upload (Dipanggil dari tombol Upload di Tabel)
        function bukaModalUpload(idJenis, namaJenis) {
            // Isi inputan modal dengan data dari tombol yg diklik
            document.getElementById('modal_id_jenis').value = idJenis;
            document.getElementById('modal_nama_jenis').value = namaJenis;
            
            // Buka Modal secara manual via JS Bootstrap
            var myModal = new bootstrap.Modal(document.getElementById('modalUpload'));
            myModal.show();
        }

        // 2. Script Tampilkan Syarat Dokumen (Kolom Kanan)
        document.addEventListener("DOMContentLoaded", function() {
            const selectJenis = document.getElementById('pilihan_jenis');
            const infoBox = document.getElementById('info_syarat');
            const listSyarat = document.getElementById('list_syarat');

            if(selectJenis) {
                selectJenis.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const dataSyarat = JSON.parse(selectedOption.getAttribute('data-syarat'));
                    
                    listSyarat.innerHTML = ''; // Reset list
                    
                    if (dataSyarat.length > 0) {
                        infoBox.style.display = 'block'; 
                        dataSyarat.forEach(item => {
                            const namaDoc = item.jenis_dokumen ? item.jenis_dokumen.nama_dokumen : 'Dokumen';
                            const li = document.createElement('li');
                            li.textContent = `${namaDoc} ${item.is_wajib ? '(Wajib)' : ''}`;
                            listSyarat.appendChild(li);
                        });
                    } else {
                        infoBox.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>