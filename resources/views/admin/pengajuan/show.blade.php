<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan #{{ $pengajuan->id }} - Admin UHO-Datasync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .timeline { position: relative; padding-left: 2rem; }
        .timeline::before { content: ''; position: absolute; left: 0.75rem; top: 0; bottom: 0; width: 2px; background: #dee2e6; }
        .timeline-item { position: relative; margin-bottom: 1.5rem; }
        .timeline-item::before { content: ''; position: absolute; left: -1.6rem; top: 0.35rem; width: 0.75rem; height: 0.75rem; border-radius: 50%; background: #6c757d; border: 2px solid #fff; box-shadow: 0 0 0 2px #6c757d; }
        .timeline-item.status-selesai::before { background: #198754; box-shadow: 0 0 0 2px #198754; }
        .timeline-item.status-ditolak::before { background: #dc3545; box-shadow: 0 0 0 2px #dc3545; }
        .timeline-item.status-proses::before { background: #ffc107; box-shadow: 0 0 0 2px #ffc107; }
        .timeline-item.status-pddikti::before { background: #0d6efd; box-shadow: 0 0 0 2px #0d6efd; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('storage/Logo-UHO-Normal-1.png') }}" alt="UHO" style="height: 36px">
                <span>Admin UHO-Datasync</span>
            </a>
            <div class="d-flex align-items-center gap-3 text-white">
                <span>{{ auth()->user()->nama }} ({{ auth()->user()->role }})</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-light" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="mb-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Dashboard
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Kolom Kiri: Info Pengajuan --}}
            <div class="col-lg-7">
                {{-- Info Mahasiswa --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle text-primary fs-5"></i>
                        <strong>Informasi Mahasiswa</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted" style="width:40%">Nama Lengkap</td>
                                <td><strong>{{ $pengajuan->pengaju->nama_lengkap ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIM</td>
                                <td>{{ $pengajuan->pengaju->nim ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIK</td>
                                <td>{{ $pengajuan->pengaju->nik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>{{ $pengajuan->pengaju->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. HP</td>
                                <td>{{ $pengajuan->pengaju->no_hp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jurusan</td>
                                <td>{{ $pengajuan->pengaju->jurusan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Info Pengajuan --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-text text-primary fs-5"></i>
                        <strong>Detail Pengajuan #{{ $pengajuan->id }}</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted" style="width:40%">Jenis Pengajuan</td>
                                <td><strong>{{ $pengajuan->jenis_pengajuan->nama_pengajuan ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status Saat Ini</td>
                                <td>
                                    @php
                                        $namaStatus = $pengajuan->status_pengajuan->nama_status ?? '';
                                        $labelStatus = \App\Models\StatusPengajuan::LABELS[$namaStatus] ?? $namaStatus;
                                        $badgeClass = \App\Models\StatusPengajuan::BADGE_CLASSES[$namaStatus] ?? 'bg-secondary';
                                        // Convert Tailwind to Bootstrap
                                        $bsBadge = match($namaStatus) {
                                            'SELESAI' => 'success',
                                            'DITOLAK' => 'danger',
                                            'TERKIRIM_PDDIKTI' => 'primary',
                                            'VERIFIKASI_PUSTIK' => 'warning',
                                            'TERKIRIM_PUSTIK' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $bsBadge }} fs-6">{{ $labelStatus }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tanggal Pengajuan</td>
                                <td>{{ $pengajuan->created_at->format('d M Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Keterangan Mahasiswa</td>
                                <td>{{ $pengajuan->keterangan_user ?? '-' }}</td>
                            </tr>
                            @if($pengajuan->keterangan_penolakan)
                            <tr>
                                <td class="text-muted">Alasan Penolakan</td>
                                <td><span class="text-danger fw-semibold">{{ $pengajuan->keterangan_penolakan }}</span></td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                {{-- Dokumen yang Diunggah --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex align-items-center gap-2">
                        <i class="bi bi-paperclip text-primary fs-5"></i>
                        <strong>Dokumen yang Diunggah</strong>
                    </div>
                    <div class="card-body">
                        @if($pengajuan->dokumens->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($pengajuan->dokumens as $dok)
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                            <strong>{{ $dok->jenisDokumen->nama_dokumen ?? 'Dokumen' }}</strong>
                                            <span class="text-muted small ms-2">({{ strtoupper($dok->file_type ?? '?') }}, {{ $dok->file_size_kb ?? '?' }} KB)</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $dok->path_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Lihat
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada dokumen yang diunggah.</p>
                        @endif
                    </div>
                </div>

                {{-- Riwayat Status --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-primary fs-5"></i>
                        <strong>Riwayat Perubahan Status</strong>
                    </div>
                    <div class="card-body">
                        @if($riwayat->count() > 0)
                            <div class="timeline">
                                @foreach($riwayat as $item)
                                    @php
                                        $rNama = $item->status_pengajuan->nama_status ?? '';
                                        $rLabel = \App\Models\StatusPengajuan::LABELS[$rNama] ?? $rNama;
                                        $rClass = match($rNama) {
                                            'SELESAI' => 'status-selesai',
                                            'DITOLAK' => 'status-ditolak',
                                            'TERKIRIM_PDDIKTI' => 'status-pddikti',
                                            default => 'status-proses',
                                        };
                                    @endphp
                                    <div class="timeline-item {{ $rClass }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="fw-semibold">{{ $rLabel }}</span>
                                                <p class="text-muted small mb-0">{{ $item->catatan ?? '-' }}</p>
                                                @if($item->keterangan_penolakan)
                                                    <p class="text-danger small mb-0"><i class="bi bi-exclamation-circle me-1"></i>Alasan: {{ $item->keterangan_penolakan }}</p>
                                                @endif
                                                <p class="text-muted small mb-0">Oleh: {{ $item->created_by ?? 'System' }}</p>
                                            </div>
                                            <span class="text-muted small text-nowrap ms-3">{{ $item->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada riwayat perubahan status.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Form Update Status --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-primary sticky-top" style="top: 1rem;">
                    <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square fs-5"></i>
                        <strong>Update Status Pengajuan</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pengajuan.update-status', $pengajuan->id) }}" method="POST" id="formUpdateStatus">
                            @csrf

                            <div class="mb-3">
                                <label for="id_status_pengajuan" class="form-label fw-semibold">
                                    Ubah Status Menjadi <span class="text-danger">*</span>
                                </label>
                                <select name="id_status_pengajuan" id="id_status_pengajuan"
                                    class="form-select @error('id_status_pengajuan') is-invalid @enderror"
                                    required onchange="toggleAlasanPenolakan(this)">
                                    <option value="">-- Pilih Status --</option>
                                    @foreach($statusFlow as $status)
                                        @php
                                            $sLabel = \App\Models\StatusPengajuan::LABELS[$status->nama_status] ?? $status->nama_status;
                                        @endphp
                                        <option value="{{ $status->id }}"
                                            data-nama="{{ $status->nama_status }}"
                                            {{ old('id_status_pengajuan') == $status->id ? 'selected' : '' }}>
                                            {{ $sLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_status_pengajuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="catatan" class="form-label fw-semibold">Catatan Admin (Opsional)</label>
                                <textarea name="catatan" id="catatan" rows="3"
                                    class="form-control"
                                    placeholder="Tulis catatan tambahan untuk riwayat...">{{ old('catatan') }}</textarea>
                            </div>

                            {{-- Alasan Penolakan (muncul hanya jika DITOLAK dipilih) --}}
                            <div class="mb-3" id="divAlasanPenolakan" style="display:none;">
                                <label for="keterangan_penolakan" class="form-label fw-semibold text-danger">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                    Alasan Penolakan (Dari PUSTIK/PDDIKTI) <span class="text-danger">*</span>
                                </label>
                                <textarea name="keterangan_penolakan" id="keterangan_penolakan" rows="4"
                                    class="form-control border-danger @error('keterangan_penolakan') is-invalid @enderror"
                                    placeholder="Tuliskan alasan penolakan secara jelas agar mahasiswa dapat memperbaiki pengajuannya...">{{ old('keterangan_penolakan') }}</textarea>
                                @error('keterangan_penolakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-danger">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Alasan ini akan ditampilkan kepada mahasiswa di dashboard mereka.
                                </div>
                            </div>

                            {{-- Konfirmasi Penolakan --}}
                            <div class="alert alert-warning d-none" id="alertKonfirmasiTolak">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Perhatian!</strong> Anda akan menolak pengajuan ini. Pastikan alasan penolakan sudah diisi dengan jelas.
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" id="btnSubmit">
                                    <i class="bi bi-check-circle me-2"></i>Simpan Perubahan Status
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Alur Status Resmi --}}
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white">
                        <strong><i class="bi bi-diagram-3 me-2"></i>Alur Status Resmi</strong>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column gap-2">
                            @php
                                $alurStatus = [
                                    'TERKIRIM_PUSTIK' => ['label' => 'Terkirim ke PUSTIK', 'badge' => 'warning', 'icon' => 'send'],
                                    'VERIFIKASI_PUSTIK' => ['label' => 'Diverifikasi PUSTIK', 'badge' => 'warning', 'icon' => 'search'],
                                    'TERKIRIM_PDDIKTI' => ['label' => 'Terkirim ke PDDIKTI', 'badge' => 'primary', 'icon' => 'cloud-upload'],
                                    'SELESAI' => ['label' => 'Selesai', 'badge' => 'success', 'icon' => 'check-circle'],
                                    'DITOLAK' => ['label' => 'Ditolak', 'badge' => 'danger', 'icon' => 'x-circle'],
                                ];
                                $currentNama = $pengajuan->status_pengajuan->nama_status ?? '';
                            @endphp
                            @foreach($alurStatus as $key => $info)
                                <div class="d-flex align-items-center gap-2 p-2 rounded {{ $currentNama === $key ? 'bg-' . $info['badge'] . ' bg-opacity-10 border border-' . $info['badge'] : '' }}">
                                    <span class="badge bg-{{ $info['badge'] }} rounded-pill" style="min-width:1.5rem">
                                        <i class="bi bi-{{ $info['icon'] }}"></i>
                                    </span>
                                    <span class="small {{ $currentNama === $key ? 'fw-bold' : 'text-muted' }}">
                                        {{ $info['label'] }}
                                        @if($currentNama === $key)
                                            <span class="badge bg-{{ $info['badge'] }} ms-1">Saat ini</span>
                                        @endif
                                    </span>
                                </div>
                                @if($key !== 'DITOLAK')
                                    <div class="text-center text-muted" style="font-size:0.7rem; margin: -0.25rem 0">
                                        @if($key !== 'SELESAI') <i class="bi bi-arrow-down"></i> @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleAlasanPenolakan(selectEl) {
            const selectedOption = selectEl.options[selectEl.selectedIndex];
            const namaStatus = selectedOption.getAttribute('data-nama');
            const divAlasan = document.getElementById('divAlasanPenolakan');
            const alertKonfirmasi = document.getElementById('alertKonfirmasiTolak');
            const textareaAlasan = document.getElementById('keterangan_penolakan');
            const btnSubmit = document.getElementById('btnSubmit');

            if (namaStatus === 'DITOLAK') {
                divAlasan.style.display = 'block';
                alertKonfirmasi.classList.remove('d-none');
                textareaAlasan.setAttribute('required', 'required');
                btnSubmit.classList.remove('btn-primary');
                btnSubmit.classList.add('btn-danger');
                btnSubmit.innerHTML = '<i class="bi bi-x-circle me-2"></i>Tolak Pengajuan Ini';
            } else {
                divAlasan.style.display = 'none';
                alertKonfirmasi.classList.add('d-none');
                textareaAlasan.removeAttribute('required');
                btnSubmit.classList.remove('btn-danger');
                btnSubmit.classList.add('btn-primary');
                btnSubmit.innerHTML = '<i class="bi bi-check-circle me-2"></i>Simpan Perubahan Status';
            }
        }

        // Trigger on page load if old value was DITOLAK
        document.addEventListener('DOMContentLoaded', function() {
            const selectEl = document.getElementById('id_status_pengajuan');
            if (selectEl.value) {
                toggleAlasanPenolakan(selectEl);
            }
        });
    </script>
</body>
</html>
