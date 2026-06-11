<x-app-layout>
<style>
    /* ===== DASHBOARD VARS ===== */
    :root {
        --navy:   #0f2557;
        --blue:   #1a3a8f;
        --accent: #e8a020;
        --gold:   #f5c842;
        --light:  #f0f4ff;
        --white:  #ffffff;
        --gray:   #6b7280;
        --text:   #1e293b;
        --success:#16a34a;
        --danger: #dc2626;
        --warn:   #d97706;
        --border: #e2e8f0;
    }

    body { background: #f0f4ff !important; }

    /* ===== LAYOUT ===== */
    .dash-wrap {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1.5rem 4rem;
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 1.75rem;
        align-items: start;
    }

    /* ===== SIDEBAR ===== */
    .sidebar { display: flex; flex-direction: column; gap: 1.25rem; }

    .profile-card {
        background: linear-gradient(135deg, var(--navy) 0%, #1a3a8f 100%);
        border-radius: 20px;
        padding: 1.75rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .profile-card::before {
        content: '';
        position: absolute;
        width: 180px; height: 180px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        top: -60px; right: -60px;
    }
    .profile-avatar {
        width: 64px; height: 64px;
        background: rgba(255,255,255,0.15);
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; font-weight: 800;
        color: white;
        margin-bottom: 1rem;
    }
    .profile-name { font-size: 1.05rem; font-weight: 700; margin-bottom: .2rem; }
    .profile-nim  { font-size: .78rem; opacity: .7; margin-bottom: .8rem; }
    .profile-tags { display: flex; flex-wrap: wrap; gap: .4rem; }
    .profile-tag  {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        color: rgba(255,255,255,.85);
        padding: .22rem .65rem;
        border-radius: 50px;
        font-size: .72rem; font-weight: 500;
    }

    .sidebar-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
    }
    .sidebar-card-title {
        padding: 1rem 1.25rem .75rem;
        font-size: .7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .08em;
        color: var(--gray);
        border-bottom: 1px solid var(--border);
    }
    .sidebar-nav-item {
        display: flex; align-items: center; gap: .7rem;
        padding: .75rem 1.25rem;
        font-size: .875rem; font-weight: 500;
        color: var(--text);
        cursor: pointer;
        border-bottom: 1px solid #f8fafc;
        transition: background .15s;
    }
    .sidebar-nav-item:hover { background: var(--light); }
    .sidebar-nav-item.active { background: var(--light); color: var(--navy); font-weight: 600; }
    .sidebar-nav-item svg { width: 18px; height: 18px; flex-shrink: 0; color: var(--gray); }
    .sidebar-nav-item.active svg { color: var(--navy); }
    .sidebar-nav-item:last-child { border-bottom: none; }

    /* ===== MAIN CONTENT ===== */
    .main-content { display: flex; flex-direction: column; gap: 1.5rem; }

    /* ===== STATUS BANNER ===== */
    .status-banner {
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
        display: flex; align-items: center; gap: 1rem;
        font-size: .875rem;
    }
    .status-banner.draft    { background: #fefce8; border: 1.5px solid #fde047; }
    .status-banner.success  { background: #f0fdf4; border: 1.5px solid #86efac; }
    .status-banner.info     { background: #eff6ff; border: 1.5px solid #93c5fd; }
    .status-banner.warning  { background: #fff7ed; border: 1.5px solid #fed7aa; }
    .status-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .status-banner.draft   .status-icon { background: #fde047; color: #78350f; }
    .status-banner.success .status-icon { background: #86efac; color: #14532d; }
    .status-banner.info    .status-icon { background: #93c5fd; color: #1e3a8a; }
    .status-banner.warning .status-icon { background: #fed7aa; color: #7c2d12; }
    .status-icon svg { width: 22px; height: 22px; }
    .status-text strong { display: block; font-weight: 700; color: var(--text); font-size: .9rem; }
    .status-text span { color: var(--gray); font-size: .8rem; }

    /* ===== CARDS GRID ===== */
    .cards-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .stat-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex; align-items: center; gap: 1rem;
    }
    .stat-card-icon {
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-card-icon.blue   { background: #eff6ff; color: var(--navy); }
    .stat-card-icon.gold   { background: #fef9c3; color: #854d0e; }
    .stat-card-icon.green  { background: #f0fdf4; color: var(--success); }
    .stat-card-icon svg { width: 24px; height: 24px; }
    .stat-card-val { font-size: 1.4rem; font-weight: 800; color: var(--navy); line-height: 1; }
    .stat-card-lbl { font-size: .75rem; color: var(--gray); margin-top: .25rem; }

    /* ===== SECTION HEADER ===== */
    .section-hdr {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1rem;
    }
    .section-hdr-title { font-size: 1rem; font-weight: 700; color: var(--navy); }
    .section-hdr-sub   { font-size: .78rem; color: var(--gray); margin-top: .1rem; }

    /* ===== JENIS PENGAJUAN ===== */
    .pengajuan-wrap {
        background: white;
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .pengajuan-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .pengajuan-header-left h3 { font-size: 1rem; font-weight: 700; color: var(--navy); }
    .pengajuan-header-left p  { font-size: .78rem; color: var(--gray); margin-top: .1rem; }

    .pengajuan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 1px;
        background: var(--border);
    }
    .pengajuan-item {
        background: white;
        padding: 1.25rem;
        cursor: pointer;
        transition: background .15s;
        position: relative;
    }
    .pengajuan-item:hover { background: #fafbff; }
    .pengajuan-item.selected {
        background: var(--light);
        outline: 2px solid var(--navy);
        outline-offset: -2px;
        z-index: 1;
    }

    .pi-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        background: var(--light);
        display: flex; align-items: center; justify-content: center;
        color: var(--navy);
        margin-bottom: .9rem;
    }
    .pi-icon svg { width: 22px; height: 22px; }
    .pi-name { font-weight: 700; font-size: .875rem; color: var(--navy); margin-bottom: .3rem; }
    .pi-desc { font-size: .75rem; color: var(--gray); line-height: 1.5; }
    .pi-selected-badge {
        position: absolute; top: .75rem; right: .75rem;
        background: var(--navy); color: white;
        font-size: .65rem; font-weight: 700;
        padding: .2rem .5rem; border-radius: 50px;
        display: none;
    }
    .pengajuan-item.selected .pi-selected-badge { display: block; }

    /* ===== DOKUMEN SECTION ===== */
    .dokumen-wrap {
        background: white;
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .dokumen-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: #fafbff;
    }
    .dokumen-header h3 { font-size: 1rem; font-weight: 700; color: var(--navy); }
    .dokumen-header p  { font-size: .78rem; color: var(--gray); margin-top: .15rem; }

    .dokumen-list { padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: .85rem; }

    .dokumen-item {
        display: flex; align-items: center; gap: 1rem;
        padding: 1rem 1.1rem;
        border: 1.5px solid var(--border);
        border-radius: 14px;
        transition: all .2s;
        background: white;
    }
    .dokumen-item.uploaded { border-color: #86efac; background: #f0fdf4; }
    .dokumen-item.missing  { border-color: #fca5a5; background: #fff5f5; }

    .dok-icon {
        width: 42px; height: 42px; flex-shrink: 0;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }
    .dok-icon.uploaded { background: #dcfce7; color: var(--success); }
    .dok-icon.missing  { background: #fee2e2; color: var(--danger); }
    .dok-icon.pending  { background: var(--light); color: var(--navy); }
    .dok-icon svg { width: 20px; height: 20px; }

    .dok-info { flex: 1; min-width: 0; }
    .dok-name { font-weight: 600; font-size: .875rem; color: var(--text); }
    .dok-meta { font-size: .75rem; color: var(--gray); margin-top: .15rem; }
    .dok-wajib { color: var(--danger); font-weight: 700; }
    .dok-opsional { color: var(--gray); }

    .dok-status-badge {
        flex-shrink: 0;
        padding: .3rem .75rem;
        border-radius: 50px;
        font-size: .72rem; font-weight: 700;
    }
    .dok-status-badge.uploaded { background: #dcfce7; color: #15803d; }
    .dok-status-badge.missing  { background: #fee2e2; color: #b91c1c; }
    .dok-status-badge.pending  { background: var(--light); color: var(--navy); }

    .dok-actions { display: flex; gap: .5rem; align-items: center; flex-shrink: 0; }

    /* Upload form inline */
    .upload-form { display: none; flex-direction: column; gap: .5rem; }
    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 10px;
        padding: .75rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s;
        font-size: .8rem; color: var(--gray);
    }
    .upload-area:hover { border-color: var(--navy); color: var(--navy); }
    .upload-area input { display: none; }

    .btn-upload-confirm {
        background: var(--navy);
        color: white;
        border: none;
        padding: .5rem 1rem;
        border-radius: 8px;
        font-size: .8rem; font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .2s;
    }
    .btn-upload-confirm:hover { background: var(--blue); }

    .btn-sm {
        padding: .4rem .85rem;
        border-radius: 8px;
        font-size: .78rem; font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        border: 1.5px solid;
        transition: all .2s;
        display: inline-flex; align-items: center; gap: .3rem;
    }
    .btn-primary-sm { background: var(--navy); color: white; border-color: var(--navy); }
    .btn-primary-sm:hover { background: var(--blue); }
    .btn-outline-sm { background: white; color: var(--navy); border-color: var(--border); }
    .btn-outline-sm:hover { border-color: var(--navy); }
    .btn-danger-sm  { background: white; color: var(--danger); border-color: #fca5a5; }
    .btn-danger-sm:hover  { background: #fff5f5; }

    /* ===== SUBMIT SECTION ===== */
    .submit-wrap {
        background: linear-gradient(135deg, var(--navy) 0%, #1a3a8f 100%);
        border-radius: 20px;
        padding: 1.75rem;
        display: flex; align-items: center; justify-content: space-between;
        gap: 1.5rem;
    }
    .submit-info { color: white; }
    .submit-info h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: .3rem; }
    .submit-info p  { font-size: .8rem; opacity: .75; }
    .btn-submit {
        background: var(--accent);
        color: white;
        border: none;
        padding: .85rem 2rem;
        border-radius: 12px;
        font-size: .95rem; font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
        box-shadow: 0 6px 20px rgba(232,160,32,0.4);
        transition: all .2s;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(232,160,32,0.5); }
    .btn-submit:disabled { opacity: .5; cursor: not-allowed; transform: none; }

    /* ===== RIWAYAT ===== */
    .riwayat-wrap {
        background: white;
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .riwayat-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    .riwayat-header h3 { font-size: 1rem; font-weight: 700; color: var(--navy); }

    .riwayat-timeline { padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: 0; }
    .timeline-item {
        display: flex; gap: 1rem;
        padding-bottom: 1.25rem;
        position: relative;
    }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 15px; top: 34px; bottom: 0;
        width: 2px;
        background: var(--border);
    }
    .timeline-item:last-child::before { display: none; }
    .tl-dot {
        width: 32px; height: 32px; flex-shrink: 0;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid white;
        box-shadow: 0 0 0 2px var(--border);
    }
    .tl-dot.green { background: #dcfce7; color: var(--success); }
    .tl-dot.blue  { background: #eff6ff; color: var(--blue); }
    .tl-dot.gold  { background: #fef9c3; color: #854d0e; }
    .tl-dot.red   { background: #fee2e2; color: var(--danger); }
    .tl-dot svg   { width: 14px; height: 14px; }
    .tl-content { flex: 1; padding-top: .2rem; }
    .tl-status { font-weight: 700; font-size: .875rem; color: var(--text); }
    .tl-note   { font-size: .78rem; color: var(--gray); margin-top: .15rem; }
    .tl-date   { font-size: .72rem; color: #94a3b8; margin-top: .2rem; }

    .empty-state { padding: 2.5rem; text-align: center; }
    .empty-state svg { width: 48px; height: 48px; color: #cbd5e1; margin: 0 auto .75rem; display: block; }
    .empty-state p { font-size: .875rem; color: var(--gray); }

    /* ===== PROGRESS BAR ===== */
    .progress-wrap { margin: .75rem 0 0; }
    .progress-label {
        display: flex; justify-content: space-between;
        font-size: .72rem; color: var(--gray); margin-bottom: .4rem; font-weight: 500;
    }
    .progress-bar {
        height: 6px; background: #e2e8f0; border-radius: 99px; overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--navy), var(--accent));
        border-radius: 99px;
        transition: width .4s;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .dash-wrap { grid-template-columns: 1fr; }
        .sidebar { display: grid; grid-template-columns: 1fr 1fr; }
        .profile-card { grid-column: 1 / -1; }
        .cards-row { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 640px) {
        .cards-row { grid-template-columns: 1fr; }
        .sidebar { grid-template-columns: 1fr; }
        .submit-wrap { flex-direction: column; }
        .btn-submit { width: 100%; }
    }
</style>

<div class="dash-wrap">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar">

        {{-- Profile Card --}}
        <div class="profile-card">
            <div class="profile-avatar">{{ strtoupper(substr($pengaju->nama_lengkap, 0, 1)) }}</div>
            <div class="profile-name">{{ $pengaju->nama_lengkap }}</div>
            <div class="profile-nim">NIM: {{ $pengaju->nim }}</div>
            <div class="profile-tags">
                <span class="profile-tag">{{ $pengaju->jurusan }}</span>
                <span class="profile-tag">{{ $pengaju->email }}</span>
                <span class="profile-tag">{{ $pengaju->no_hp }}</span>
            </div>
        </div>

        {{-- Navigasi --}}
        <div class="sidebar-card">
            <div class="sidebar-card-title">Menu</div>
            <div class="sidebar-nav-item active">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Dashboard Pengajuan
            </div>
            <a href="{{ route('profile.edit') }}" class="sidebar-nav-item" style="text-decoration:none; color:inherit;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Edit Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-nav-item" style="width:100%; background:none; border:none; cursor:pointer; font-family:inherit; font-size:.875rem; text-align:left; color:#dc2626;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#dc2626;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    Keluar
                </button>
            </form>
        </div>

        {{-- Info Kontak --}}
        <div class="sidebar-card">
            <div class="sidebar-card-title">Bantuan</div>
            <div style="padding:1rem 1.25rem; font-size:.78rem; color:var(--gray); line-height:1.7;">
                <p><strong style="color:var(--text);">UPA TIK UHO</strong></p>
                <p>📍 Gedung Rektorat Lantai 1</p>
                <p>📞 (0401) 390 XXX</p>
                <p>🕐 Senin–Jumat, 08.00–16.00 WITA</p>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="main-content">

        {{-- Alert flash --}}
        @if(session('success'))
        <div class="status-banner success">
            <div class="status-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <div class="status-text"><strong>Berhasil!</strong><span>{{ session('success') }}</span></div>
        </div>
        @endif
        @if(session('error'))
        <div class="status-banner warning">
            <div class="status-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
            <div class="status-text"><strong>Perhatian</strong><span>{{ session('error') }}</span></div>
        </div>
        @endif

        {{-- Stat Cards --}}
        <div class="cards-row">
            <div class="stat-card">
                <div class="stat-card-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div>
                    <div class="stat-card-val">{{ $dokumenDiunggah->count() }}</div>
                    <div class="stat-card-lbl">Dokumen Diupload</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon gold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="stat-card-val">{{ $pengajuanAktif ? 'Ada' : 'Belum' }}</div>
                    <div class="stat-card-lbl">Status Pengajuan</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div>
                    <div class="stat-card-val">{{ $pengajuanAktif ? $pengajuanAktif->status_pengajuan->nama_status ?? '-' : 'Belum Ada' }}</div>
                    <div class="stat-card-lbl">Status Terakhir</div>
                </div>
            </div>
        </div>

        {{-- Status Banner sesuai kondisi --}}
        @if($pengajuanAktif && $pengajuanAktif->id_status_pengajuan != $pengajuanDraft?->id_status_pengajuan)
        <div class="status-banner info">
            <div class="status-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg></div>
            <div class="status-text">
                <strong>Pengajuan Sedang Diproses</strong>
                <span>Status: <b>{{ $pengajuanAktif->status_pengajuan->nama_status ?? '-' }}</b> — Silakan pantau riwayat di bawah.</span>
            </div>
        </div>
        @elseif(!$pengajuanDraft)
        <div class="status-banner draft">
            <div class="status-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg></div>
            <div class="status-text">
                <strong>Belum Ada Pengajuan</strong>
                <span>Pilih jenis pengajuan di bawah, lalu upload dokumen yang diperlukan untuk memulai.</span>
            </div>
        </div>
        @endif

        {{-- ===== PILIH JENIS PENGAJUAN ===== --}}
        @if(!$pengajuanAktif || $pengajuanDraft)
        <div class="pengajuan-wrap">
            <div class="pengajuan-header">
                <div class="pengajuan-header-left">
                    <h3>Pilih Jenis Pengajuan</h3>
                    <p>Klik salah satu untuk melihat dokumen yang dibutuhkan</p>
                </div>
            </div>

            @if($jenisPengajuan->isEmpty())
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                    <p>Belum ada jenis pengajuan aktif. Hubungi admin.</p>
                </div>
            @else
            <div class="pengajuan-grid">
                @foreach($jenisPengajuan as $jp)
                <div class="pengajuan-item {{ $pengajuanDraft && $pengajuanDraft->id_jenis_pengajuan == $jp->id ? 'selected' : '' }}"
                     onclick="selectJenis({{ $jp->id }}, '{{ addslashes($jp->nama_jenis) }}')"
                     id="pi-{{ $jp->id }}">
                    <span class="pi-selected-badge">✓ Dipilih</span>
                    <div class="pi-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <div class="pi-name">{{ $jp->nama_jenis }}</div>
                    <div class="pi-desc">{{ $jp->deskripsi ?? 'Pengajuan perubahan ' . strtolower($jp->nama_jenis) }}</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ===== DOKUMEN YANG DIBUTUHKAN ===== --}}
        @foreach($jenisPengajuan as $jp)
        <div class="dokumen-wrap" id="dok-section-{{ $jp->id }}"
             style="{{ ($pengajuanDraft && $pengajuanDraft->id_jenis_pengajuan == $jp->id) ? '' : 'display:none;' }}">

            <div class="dokumen-header">
                <h3>📄 Dokumen untuk: {{ $jp->nama_jenis }}</h3>
                <p>Upload semua dokumen wajib (✱) sebelum mengirim pengajuan</p>

                {{-- Progress bar --}}
                @php
                    $totalDok    = $jp->syarat->count();
                    $wajibDok    = $jp->syarat->where('is_wajib', 1)->count();
                    $uploadedIds = $dokumenDiunggah->pluck('id_jenis_dokumen')->toArray();
                    $uploadedCount = $jp->syarat->filter(fn($s) => in_array($s->id_jenis_dokumen, $uploadedIds))->count();
                    $pct = $totalDok > 0 ? round(($uploadedCount / $totalDok) * 100) : 0;
                @endphp
                @if($pengajuanDraft)
                <div class="progress-wrap">
                    <div class="progress-label">
                        <span>Progres Upload Dokumen</span>
                        <span>{{ $uploadedCount }}/{{ $totalDok }} dokumen ({{ $pct }}%)</span>
                    </div>
                    <div class="progress-bar"><div class="progress-fill" style="width:{{ $pct }}%"></div></div>
                </div>
                @endif
            </div>

            <div class="dokumen-list">
                @forelse($jp->syarat as $syarat)
                @php
                    $dok = $syarat->jenisDokumen;
                    $uploaded = $dokumenDiunggah->firstWhere('id_jenis_dokumen', $dok->id);
                    $statusClass = $uploaded ? 'uploaded' : ($syarat->is_wajib ? 'missing' : '');
                @endphp
                <div class="dokumen-item {{ $statusClass }}">
                    <div class="dok-icon {{ $uploaded ? 'uploaded' : ($syarat->is_wajib ? 'missing' : 'pending') }}">
                        @if($uploaded)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        @elseif($syarat->is_wajib)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        @endif
                    </div>

                    <div class="dok-info">
                        <div class="dok-name">{{ $dok->nama_dokumen }}</div>
                        <div class="dok-meta">
                            @if($syarat->is_wajib)
                                <span class="dok-wajib">✱ Wajib</span>
                            @else
                                <span class="dok-opsional">Opsional</span>
                            @endif
                            @if($dok->keterangan) · {{ $dok->keterangan }} @endif
                            @if($uploaded) · {{ $uploaded->file_size_kb }} KB · {{ strtoupper($uploaded->file_type) }} @endif
                        </div>
                    </div>

                    <span class="dok-status-badge {{ $uploaded ? 'uploaded' : ($syarat->is_wajib ? 'missing' : 'pending') }}">
                        {{ $uploaded ? '✓ Terupload' : ($syarat->is_wajib ? '✗ Belum' : '○ Opsional') }}
                    </span>

                    <div class="dok-actions">
                        @if($uploaded)
                            <a href="{{ asset('storage/' . $uploaded->path_file) }}" target="_blank" class="btn-sm btn-outline-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                Lihat
                            </a>
                            <form method="POST" action="{{ route('dokumen.hapus', $uploaded->id) }}" onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    Hapus
                                </button>
                            </form>
                        @else
                            <button onclick="toggleUpload('upload-{{ $jp->id }}-{{ $dok->id }}')" class="btn-sm btn-primary-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                Upload
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Upload form per dokumen --}}
                @if(!$uploaded)
                <form method="POST" action="{{ route('dokumen.upload') }}" enctype="multipart/form-data"
                      id="upload-{{ $jp->id }}-{{ $dok->id }}"
                      style="display:none; margin-top:-.4rem; padding:.75rem 1rem; background:#fafbff; border:1.5px dashed var(--border); border-radius:12px;">
                    @csrf
                    <input type="hidden" name="id_jenis_dokumen" value="{{ $dok->id }}">
                    <input type="hidden" name="id_pengaju" value="{{ $pengaju->id }}">
                    <input type="hidden" name="id_jenis_pengajuan" value="{{ $jp->id }}">

                    <div style="font-size:.8rem; font-weight:600; color:var(--navy); margin-bottom:.5rem;">
                        Upload: {{ $dok->nama_dokumen }}
                    </div>

                    <label class="upload-area" for="file-{{ $jp->id }}-{{ $dok->id }}">
                        <input type="file" id="file-{{ $jp->id }}-{{ $dok->id }}" name="file" accept=".pdf,.jpg,.jpeg"
                               onchange="updateFileName(this)">
                        <div id="label-{{ $jp->id }}-{{ $dok->id }}">
                            📎 Klik untuk pilih file <br>
                            <span style="font-size:.72rem;">PDF atau JPG/JPEG · Maks 2MB</span>
                        </div>
                    </label>

                    <div style="display:flex; gap:.5rem; margin-top:.5rem;">
                        <button type="submit" class="btn-upload-confirm">Upload Sekarang</button>
                        <button type="button" onclick="toggleUpload('upload-{{ $jp->id }}-{{ $dok->id }}')" class="btn-sm btn-outline-sm">Batal</button>
                    </div>
                </form>
                @endif

                @empty
                <div class="empty-state" style="padding:1.5rem;">
                    <p>Belum ada syarat dokumen terdaftar untuk jenis pengajuan ini.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach

        {{-- ===== TOMBOL KIRIM ===== --}}
        @if($pengajuanDraft)
        <div class="submit-wrap">
            <div class="submit-info">
                <h3>Siap Mengirim Pengajuan?</h3>
                <p>Pastikan semua dokumen wajib sudah terupload sebelum mengirim.</p>
            </div>
            <form method="POST" action="{{ route('pengajuan.submit') }}">
                @csrf
                <input type="hidden" name="id_pengajuan" value="{{ $pengajuanDraft->id }}">
                <input type="hidden" name="id_jenis_pengajuan" value="{{ $pengajuanDraft->id_jenis_pengajuan }}">
                <textarea name="keterangan_user" style="display:none"></textarea>
                <button type="submit" class="btn-submit"
                        onclick="return confirm('Kirim pengajuan? Pastikan semua dokumen sudah lengkap.')">
                    🚀 Kirim Pengajuan ke UPA TIK
                </button>
            </form>
        </div>
        @endif

        @endif {{-- end if !pengajuanAktif || pengajuanDraft --}}

        {{-- ===== RIWAYAT STATUS ===== --}}
        <div class="riwayat-wrap">
            <div class="riwayat-header">
                <h3>📋 Riwayat Pengajuan</h3>
            </div>

            @if(count($riwayat) > 0)
            <div class="riwayat-timeline">
                @foreach($riwayat as $r)
                @php
                    $status = strtolower($r->status_pengajuan->nama_status ?? '');
                    $dotClass = str_contains($status, 'disetujui') || str_contains($status, 'selesai') ? 'green'
                               : (str_contains($status, 'tolak') || str_contains($status, 'ditolak') ? 'red'
                               : (str_contains($status, 'draft') ? 'gold' : 'blue'));
                @endphp
                <div class="timeline-item">
                    <div class="tl-dot {{ $dotClass }}">
                        @if($dotClass === 'green')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        @elseif($dotClass === 'red')
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        @endif
                    </div>
                    <div class="tl-content">
                        <div class="tl-status">{{ $r->status_pengajuan->nama_status ?? '-' }}</div>
                        <div class="tl-note">{{ $r->catatan ?? '-' }}</div>
                        <div class="tl-date">{{ \Carbon\Carbon::parse($r->created_at)->format('d M Y, H:i') }} WITA · oleh {{ $r->created_by ?? 'Sistem' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p>Belum ada riwayat pengajuan. Mulai pengajuan pertama Anda di atas.</p>
            </div>
            @endif
        </div>

    </div>{{-- end main-content --}}
</div>

<script>
    // Pilih jenis pengajuan
    function selectJenis(id, nama) {
        // Remove all selected
        document.querySelectorAll('.pengajuan-item').forEach(el => el.classList.remove('selected'));
        document.querySelectorAll('[id^="dok-section-"]').forEach(el => el.style.display = 'none');

        // Activate selected
        const item = document.getElementById('pi-' + id);
        if (item) item.classList.add('selected');

        const section = document.getElementById('dok-section-' + id);
        if (section) {
            section.style.display = 'block';
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Toggle upload form
    function toggleUpload(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.display = el.style.display === 'none' || el.style.display === '' ? 'flex' : 'none';
        if (el.style.display !== 'none') {
            el.style.flexDirection = 'column';
            el.style.gap = '.5rem';
        }
    }

    // Show filename in upload area
    function updateFileName(input) {
        const parts = input.id.split('-');
        const labelId = 'label-' + parts.slice(1).join('-');
        const label = document.getElementById(labelId);
        if (label && input.files[0]) {
            label.innerHTML = `✅ ${input.files[0].name}<br><span style="font-size:.72rem;">${(input.files[0].size/1024).toFixed(1)} KB</span>`;
        }
    }
</script>

</x-app-layout>