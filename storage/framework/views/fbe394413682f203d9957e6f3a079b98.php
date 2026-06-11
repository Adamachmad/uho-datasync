<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UHO-Datasync | Portal Perubahan Data Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:   #0f2557;
            --blue:   #1a3a8f;
            --accent: #e8a020;
            --gold:   #f5c842;
            --light:  #f4f7ff;
            --white:  #ffffff;
            --gray:   #6b7280;
            --text:   #1e293b;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--white);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem;
            height: 68px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(15,37,87,0.08);
            transition: box-shadow .3s;
        }
        .navbar.scrolled { box-shadow: 0 4px 24px rgba(15,37,87,0.10); }

        .nav-brand { display: flex; align-items: center; gap: .75rem; text-decoration: none; }
        .nav-brand img { height: 38px; }
        .nav-brand-text { font-weight: 700; font-size: 1.05rem; color: var(--navy); line-height: 1.2; }
        .nav-brand-sub { font-size: .7rem; font-weight: 500; color: var(--gray); letter-spacing: .04em; }

        .nav-links { display: flex; align-items: center; gap: .25rem; }

        .nav-link {
            padding: .5rem 1rem;
            font-size: .875rem; font-weight: 500;
            color: var(--text);
            text-decoration: none;
            border-radius: 8px;
            transition: background .2s, color .2s;
        }
        .nav-link:hover { background: var(--light); color: var(--navy); }

        /* Account icon / dropdown untuk guest */
        .nav-actions { display: flex; align-items: center; gap: .75rem; }

        .btn-login {
            display: flex; align-items: center; gap: .4rem;
            padding: .5rem 1.1rem;
            background: var(--light);
            color: var(--navy);
            border: 1.5px solid rgba(15,37,87,0.15);
            border-radius: 10px;
            font-size: .875rem; font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-login:hover { background: var(--navy); color: white; border-color: var(--navy); }
        .btn-login svg { width: 18px; height: 18px; }

        .btn-daftar {
            display: flex; align-items: center; gap: .4rem;
            padding: .5rem 1.2rem;
            background: var(--navy);
            color: white;
            border: 1.5px solid var(--navy);
            border-radius: 10px;
            font-size: .875rem; font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-daftar:hover { background: var(--blue); box-shadow: 0 4px 12px rgba(15,37,87,0.3); transform: translateY(-1px); }

        /* Logged-in account dropdown */
        .account-menu { position: relative; }
        .account-trigger {
            display: flex; align-items: center; gap: .5rem;
            padding: .45rem .9rem .45rem .6rem;
            background: var(--light);
            border: 1.5px solid rgba(15,37,87,0.12);
            border-radius: 50px;
            cursor: pointer;
            transition: all .2s;
        }
        .account-trigger:hover { border-color: var(--navy); background: white; }
        .account-avatar {
            width: 32px; height: 32px;
            background: var(--navy);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: .8rem; font-weight: 700;
        }
        .account-name { font-size: .875rem; font-weight: 600; color: var(--navy); max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .account-chevron { color: var(--gray); }

        .account-dropdown {
            position: absolute; right: 0; top: calc(100% + 8px);
            background: white;
            border: 1px solid rgba(15,37,87,0.1);
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(15,37,87,0.15);
            min-width: 220px;
            padding: .5rem;
            display: none;
            animation: dropIn .2s ease;
        }
        .account-menu:hover .account-dropdown { display: block; }
        @keyframes dropIn { from { opacity:0; transform: translateY(-6px); } to { opacity:1; transform:translateY(0); } }

        .dropdown-header { padding: .75rem 1rem .5rem; border-bottom: 1px solid #f1f5f9; margin-bottom: .25rem; }
        .dropdown-header .d-name { font-weight: 700; color: var(--navy); font-size: .9rem; }
        .dropdown-header .d-email { font-size: .75rem; color: var(--gray); }

        .dropdown-item {
            display: flex; align-items: center; gap: .6rem;
            padding: .6rem 1rem;
            border-radius: 8px;
            font-size: .875rem; font-weight: 500;
            color: var(--text);
            text-decoration: none;
            transition: background .15s;
        }
        .dropdown-item:hover { background: var(--light); }
        .dropdown-item.danger { color: #dc2626; }
        .dropdown-item.danger:hover { background: #fef2f2; }
        .dropdown-item svg { width: 16px; height: 16px; flex-shrink: 0; }
        .dropdown-divider { height: 1px; background: #f1f5f9; margin: .25rem 0; }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--navy) 0%, #1a3a8f 50%, #0d1f4a 100%);
            position: relative;
            overflow: hidden;
            display: flex; flex-direction: column;
        }

        /* Grid decoration */
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* Gold orb */
        .hero-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .hero-orb-1 { width: 500px; height: 500px; background: rgba(232,160,32,0.18); top: -100px; right: -100px; }
        .hero-orb-2 { width: 350px; height: 350px; background: rgba(26,58,143,0.5); bottom: 50px; left: -80px; }

        .hero-content {
            flex: 1; display: flex; align-items: center;
            max-width: 1200px; margin: 0 auto; padding: 120px 2rem 80px;
            gap: 4rem; position: relative; z-index: 2;
            width: 100%;
        }

        .hero-left { flex: 1; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(232,160,32,0.15);
            border: 1px solid rgba(232,160,32,0.35);
            color: var(--gold);
            padding: .35rem 1rem;
            border-radius: 50px;
            font-size: .8rem; font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            animation: fadeUp .6s ease both;
        }
        .hero-badge svg { width: 14px; height: 14px; }

        .hero-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2.2rem, 4.5vw, 3.8rem);
            color: white;
            line-height: 1.15;
            margin-bottom: 1.25rem;
            animation: fadeUp .6s .1s ease both;
        }
        .hero-title em { color: var(--gold); font-style: normal; }

        .hero-desc {
            font-size: 1.05rem;
            color: rgba(255,255,255,0.72);
            line-height: 1.75;
            max-width: 520px;
            margin-bottom: 2.25rem;
            animation: fadeUp .6s .2s ease both;
        }

        .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; animation: fadeUp .6s .3s ease both; }

        .cta-primary {
            display: inline-flex; align-items: center; gap: .5rem;
            background: var(--accent);
            color: white;
            padding: .85rem 1.75rem;
            border-radius: 12px;
            font-weight: 700; font-size: .95rem;
            text-decoration: none;
            box-shadow: 0 8px 24px rgba(232,160,32,0.35);
            transition: all .25s;
        }
        .cta-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(232,160,32,0.45); background: #d4911a; }

        .cta-secondary {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1.5px solid rgba(255,255,255,0.25);
            padding: .85rem 1.75rem;
            border-radius: 12px;
            font-weight: 600; font-size: .95rem;
            text-decoration: none;
            transition: all .25s;
        }
        .cta-secondary:hover { background: rgba(255,255,255,0.18); border-color: rgba(255,255,255,0.5); }

        /* Stats bar */
        .hero-stats {
            display: flex; gap: 2.5rem; margin-top: 3rem;
            animation: fadeUp .6s .4s ease both;
        }
        .stat-item { }
        .stat-number { font-size: 1.6rem; font-weight: 800; color: white; }
        .stat-label { font-size: .78rem; color: rgba(255,255,255,0.55); font-weight: 500; }
        .stat-divider { width: 1px; background: rgba(255,255,255,0.15); }

        /* Hero right: visual card */
        .hero-right {
            flex: 0 0 380px;
            animation: fadeUp .6s .2s ease both;
        }

        .hero-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.14);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 1.75rem;
        }
        .hero-card-title { color: rgba(255,255,255,0.6); font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 1.25rem; }

        .process-step {
            display: flex; align-items: flex-start; gap: 1rem;
            padding: .9rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .process-step:last-child { border-bottom: none; padding-bottom: 0; }
        .step-num {
            width: 34px; height: 34px; flex-shrink: 0;
            background: rgba(232,160,32,0.2);
            border: 1.5px solid rgba(232,160,32,0.4);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: .8rem; font-weight: 700;
        }
        .step-info { flex: 1; }
        .step-title { color: white; font-weight: 600; font-size: .9rem; margin-bottom: .2rem; }
        .step-desc { color: rgba(255,255,255,0.5); font-size: .78rem; line-height: 1.5; }
        .step-check { color: #4ade80; width: 20px; height: 20px; flex-shrink: 0; margin-top: 2px; }

        /* ===== LAYANAN SECTION ===== */
        .section-layanan {
            padding: 6rem 2rem;
            background: var(--light);
        }
        .section-inner { max-width: 1200px; margin: 0 auto; }

        .section-label {
            display: inline-block;
            background: rgba(15,37,87,0.08);
            color: var(--navy);
            padding: .3rem .9rem;
            border-radius: 50px;
            font-size: .75rem; font-weight: 700;
            letter-spacing: .06em; text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            color: var(--navy);
            margin-bottom: .75rem;
            line-height: 1.25;
        }
        .section-desc { color: var(--gray); font-size: 1rem; max-width: 560px; line-height: 1.7; margin-bottom: 3rem; }

        .layanan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .layanan-card {
            background: white;
            border: 1.5px solid rgba(15,37,87,0.08);
            border-radius: 18px;
            padding: 1.75rem;
            transition: all .25s;
            text-decoration: none;
            display: block;
            position: relative;
            overflow: hidden;
        }
        .layanan-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--navy), var(--accent));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .3s;
        }
        .layanan-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(15,37,87,0.12); border-color: rgba(15,37,87,0.15); }
        .layanan-card:hover::before { transform: scaleX(1); }

        .layanan-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: var(--light);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.25rem;
            color: var(--navy);
        }
        .layanan-icon svg { width: 26px; height: 26px; }
        .layanan-name { font-weight: 700; color: var(--navy); font-size: 1rem; margin-bottom: .4rem; }
        .layanan-desc { font-size: .82rem; color: var(--gray); line-height: 1.6; }
        .layanan-badge {
            display: inline-block; margin-top: .8rem;
            background: rgba(15,37,87,0.06);
            color: var(--navy);
            padding: .25rem .7rem;
            border-radius: 50px;
            font-size: .72rem; font-weight: 600;
        }
        .layanan-badge.wajib { background: rgba(232,160,32,0.12); color: #b5780e; }

        /* Login required badge */
        .login-required-tag {
            position: absolute; top: 1rem; right: 1rem;
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #c2410c;
            font-size: .68rem; font-weight: 700;
            padding: .2rem .55rem;
            border-radius: 50px;
            display: flex; align-items: center; gap: .3rem;
        }
        .login-required-tag svg { width: 11px; height: 11px; }

        /* ===== LOGIN MODAL ===== */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(15,37,87,0.5);
            backdrop-filter: blur(6px);
            z-index: 200;
            display: flex; align-items: center; justify-content: center;
            padding: 1rem;
            opacity: 0; pointer-events: none;
            transition: opacity .25s;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }

        .modal-box {
            background: white;
            border-radius: 24px;
            width: 100%; max-width: 420px;
            padding: 2.5rem;
            box-shadow: 0 32px 80px rgba(15,37,87,0.25);
            transform: translateY(20px) scale(0.97);
            transition: transform .3s;
        }
        .modal-overlay.active .modal-box { transform: translateY(0) scale(1); }

        .modal-logo { display: flex; justify-content: center; margin-bottom: 1.5rem; }
        .modal-logo img { height: 52px; }

        .modal-title { text-align: center; margin-bottom: .5rem; }
        .modal-title h2 { font-family: 'DM Serif Display', serif; font-size: 1.6rem; color: var(--navy); }
        .modal-title p { font-size: .875rem; color: var(--gray); margin-top: .3rem; }

        .modal-form { margin-top: 1.75rem; }
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; font-size: .8rem; font-weight: 600; color: var(--text); margin-bottom: .4rem; }
        .form-control {
            width: 100%;
            padding: .7rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: .9rem;
            font-family: inherit;
            color: var(--text);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .form-control:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(15,37,87,0.1); }

        .modal-submit {
            width: 100%; padding: .8rem;
            background: var(--navy);
            color: white;
            border: none; border-radius: 10px;
            font-size: .95rem; font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            margin-top: 1.25rem;
            transition: all .2s;
        }
        .modal-submit:hover { background: var(--blue); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(15,37,87,0.25); }

        .modal-footer { text-align: center; margin-top: 1.25rem; font-size: .825rem; color: var(--gray); }
        .modal-footer a { color: var(--navy); font-weight: 600; text-decoration: none; }
        .modal-footer a:hover { text-decoration: underline; }

        .modal-close {
            position: absolute; top: 1rem; right: 1rem;
            width: 32px; height: 32px;
            border: none; background: var(--light);
            border-radius: 50%; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--gray); font-size: 1rem;
            transition: background .2s;
        }
        .modal-close:hover { background: #e2e8f0; }
        .modal-box { position: relative; }

        /* ===== ALUR SECTION ===== */
        .section-alur { padding: 6rem 2rem; background: white; }

        .alur-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
            position: relative;
        }

        .alur-card {
            text-align: center; padding: 2rem 1.5rem;
            border-radius: 18px;
            border: 1.5px solid #f1f5f9;
            transition: all .25s;
        }
        .alur-card:hover { border-color: rgba(15,37,87,0.15); box-shadow: 0 8px 24px rgba(15,37,87,0.08); }
        .alur-num {
            display: inline-flex; align-items: center; justify-content: center;
            width: 48px; height: 48px;
            background: var(--navy);
            color: white;
            font-size: 1.1rem; font-weight: 800;
            border-radius: 14px;
            margin-bottom: 1.25rem;
        }
        .alur-title { font-weight: 700; color: var(--navy); font-size: .95rem; margin-bottom: .5rem; }
        .alur-desc { font-size: .82rem; color: var(--gray); line-height: 1.65; }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--navy);
            color: rgba(255,255,255,0.7);
            text-align: center;
            padding: 2rem;
            font-size: .82rem;
        }
        .footer strong { color: white; }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .hero-content { flex-direction: column; padding-top: 100px; gap: 2rem; }
            .hero-right { flex: none; width: 100%; }
            .hero-stats { gap: 1.5rem; flex-wrap: wrap; }
            .nav-link { display: none; }
            .account-name { display: none; }
        }
    </style>
</head>
<body>


<nav class="navbar" id="navbar">
    <a href="<?php echo e(route('home')); ?>" class="nav-brand">
        <img src="<?php echo e(asset('storage/Logo-UHO-Normal-1.png')); ?>" alt="UHO">
        <div>
            <div class="nav-brand-text">UHO-Datasync</div>
            <div class="nav-brand-sub">Portal Data Mahasiswa</div>
        </div>
    </a>

    <div class="nav-links">
        <a href="#layanan" class="nav-link">Layanan</a>
        <a href="#alur" class="nav-link">Alur Pengajuan</a>
    </div>

    <div class="nav-actions">
        <?php if(Auth::guard('pengaju')->check()): ?>
            
            <?php $pengajuAuth = Auth::guard('pengaju')->user(); ?>
            <div class="account-menu">
                <div class="account-trigger">
                    <div class="account-avatar">
                        <?php echo e(strtoupper(substr($pengajuAuth->nama_lengkap, 0, 1))); ?>

                    </div>
                    <span class="account-name"><?php echo e($pengajuAuth->nama_lengkap); ?></span>
                    <svg class="account-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="account-dropdown">
                    <div class="dropdown-header">
                        <div class="d-name"><?php echo e($pengajuAuth->nama_lengkap); ?></div>
                        <div class="d-email"><?php echo e($pengajuAuth->email); ?></div>
                    </div>
                    <a href="<?php echo e(route('dashboard')); ?>" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        Dashboard
                    </a>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="dropdown-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Profil Saya
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item danger" style="width:100%; background:none; border:none; cursor:pointer; text-align:left; font-family:inherit; font-size:.875rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            
            <a href="<?php echo e(route('login')); ?>" class="btn-login">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                Masuk
            </a>
            <a href="<?php echo e(route('daftar')); ?>" class="btn-daftar">Daftar Sekarang</a>
        <?php endif; ?>
    </div>
</nav>


<section class="hero">
    <div class="hero-orb hero-orb-1"></div>
    <div class="hero-orb hero-orb-2"></div>

    <div class="hero-content">
        <div class="hero-left">
            <div class="hero-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Platform Resmi UHO
            </div>

            <h1 class="hero-title">
                Portal <em>Perubahan Data</em><br>Mahasiswa Universitas<br>Halu Oleo
            </h1>

            <p class="hero-desc">
                Ajukan perubahan data PDDIKTI secara online — cepat, aman, dan tertelusuri. Tidak perlu antri, semua proses dilakukan secara digital.
            </p>

            <div class="hero-cta">
                <?php if(Auth::guard('pengaju')->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="cta-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                        Buka Dashboard Saya
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('daftar')); ?>" class="cta-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                        Mulai Pengajuan
                    </a>
                    <a href="<?php echo e(route('login')); ?>" class="cta-secondary">
                        Sudah punya akun? Masuk
                    </a>
                <?php endif; ?>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Digital & Paperless</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-number">5+</div>
                    <div class="stat-label">Jenis Pengajuan</div>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <div class="stat-number">Real-time</div>
                    <div class="stat-label">Tracking Status</div>
                </div>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-card">
                <div class="hero-card-title">Alur Proses Pengajuan</div>

                <div class="process-step">
                    <div class="step-num">1</div>
                    <div class="step-info">
                        <div class="step-title">Daftar & Isi Data Diri</div>
                        <div class="step-desc">Buat akun dengan NIK, NIM, dan data mahasiswa</div>
                    </div>
                    <svg class="step-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>

                <div class="process-step">
                    <div class="step-num">2</div>
                    <div class="step-info">
                        <div class="step-title">Pilih Jenis Pengajuan</div>
                        <div class="step-desc">Pilih jenis perubahan data yang ingin diajukan</div>
                    </div>
                    <svg class="step-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>

                <div class="process-step">
                    <div class="step-num">3</div>
                    <div class="step-info">
                        <div class="step-title">Upload Dokumen Wajib</div>
                        <div class="step-desc">Upload semua dokumen yang dipersyaratkan (PDF/JPG)</div>
                    </div>
                    <svg class="step-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>

                <div class="process-step">
                    <div class="step-num">4</div>
                    <div class="step-info">
                        <div class="step-title">Kirim & Pantau Status</div>
                        <div class="step-desc">Kirim pengajuan dan pantau progres verifikasi</div>
                    </div>
                    <svg class="step-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section-layanan" id="layanan">
    <div class="section-inner">
        <div class="section-label">Layanan Tersedia</div>
        <h2 class="section-title">Jenis Pengajuan<br>yang Dapat Diproses</h2>
        <p class="section-desc">Pilih layanan perubahan data yang Anda butuhkan. Klik untuk melihat detail dan mulai pengajuan.</p>

        <div class="layanan-grid">
            
            <a href="<?php echo e(Auth::guard('pengaju')->check() ? route('dashboard') : 'javascript:void(0)'); ?>"
               class="layanan-card"
               onclick="<?php echo e(Auth::guard('pengaju')->check() ? '' : "showLoginModal(event, 'Perubahan Nama')"); ?>">
                <?php if(auth()->guard('pengaju')->guest()): ?>
                    <span class="login-required-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Login Dulu
                    </span>
                <?php endif; ?>
                <div class="layanan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="layanan-name">Perubahan Nama</div>
                <div class="layanan-desc">Ajukan perbaikan nama lengkap sesuai dokumen resmi kependudukan.</div>
                <span class="layanan-badge wajib">KTP + Akta + KTM</span>
            </a>

            <a href="<?php echo e(Auth::guard('pengaju')->check() ? route('dashboard') : 'javascript:void(0)'); ?>"
               class="layanan-card"
               onclick="<?php echo e(Auth::guard('pengaju')->check() ? '' : "showLoginModal(event, 'Perubahan Tempat/Tanggal Lahir')"); ?>">
                <?php if(auth()->guard('pengaju')->guest()): ?>
                    <span class="login-required-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Login Dulu
                    </span>
                <?php endif; ?>
                <div class="layanan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect width="18" height="18" x="3" y="4" rx="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <div class="layanan-name">Tempat / Tanggal Lahir</div>
                <div class="layanan-desc">Perbaiki data tempat dan tanggal lahir yang tidak sesuai KTP.</div>
                <span class="layanan-badge wajib">KTP + Akta Kelahiran</span>
            </a>

            <a href="<?php echo e(Auth::guard('pengaju')->check() ? route('dashboard') : 'javascript:void(0)'); ?>"
               class="layanan-card"
               onclick="<?php echo e(Auth::guard('pengaju')->check() ? '' : "showLoginModal(event, 'Perubahan NIM')"); ?>">
                <?php if(auth()->guard('pengaju')->guest()): ?>
                    <span class="login-required-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Login Dulu
                    </span>
                <?php endif; ?>
                <div class="layanan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                </div>
                <div class="layanan-name">Perubahan NIM</div>
                <div class="layanan-desc">Koreksi Nomor Induk Mahasiswa yang tercatat salah di sistem.</div>
                <span class="layanan-badge wajib">KTM + Surat Dekan</span>
            </a>

            <a href="<?php echo e(Auth::guard('pengaju')->check() ? route('dashboard') : 'javascript:void(0)'); ?>"
               class="layanan-card"
               onclick="<?php echo e(Auth::guard('pengaju')->check() ? '' : "showLoginModal(event, 'Perubahan Jenis Kelamin')"); ?>">
                <?php if(auth()->guard('pengaju')->guest()): ?>
                    <span class="login-required-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Login Dulu
                    </span>
                <?php endif; ?>
                <div class="layanan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                </div>
                <div class="layanan-name">Jenis Kelamin</div>
                <div class="layanan-desc">Perbaiki data jenis kelamin yang tidak sesuai dokumen resmi.</div>
                <span class="layanan-badge wajib">KTP + Surat Ket. Kampus</span>
            </a>

            <a href="<?php echo e(Auth::guard('pengaju')->check() ? route('dashboard') : 'javascript:void(0)'); ?>"
               class="layanan-card"
               onclick="<?php echo e(Auth::guard('pengaju')->check() ? '' : "showLoginModal(event, 'Perubahan Agama')"); ?>">
                <?php if(auth()->guard('pengaju')->guest()): ?>
                    <span class="login-required-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Login Dulu
                    </span>
                <?php endif; ?>
                <div class="layanan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
                </div>
                <div class="layanan-name">Perubahan Agama</div>
                <div class="layanan-desc">Koreksi data agama yang tidak sesuai dengan KTP terbaru.</div>
                <span class="layanan-badge wajib">KTP + Formulir</span>
            </a>

            <a href="<?php echo e(Auth::guard('pengaju')->check() ? route('dashboard') : 'javascript:void(0)'); ?>"
               class="layanan-card"
               onclick="<?php echo e(Auth::guard('pengaju')->check() ? '' : "showLoginModal(event, 'Perubahan Lainnya')"); ?>">
                <?php if(auth()->guard('pengaju')->guest()): ?>
                    <span class="login-required-tag">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Login Dulu
                    </span>
                <?php endif; ?>
                <div class="layanan-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                </div>
                <div class="layanan-name">Perubahan Lainnya</div>
                <div class="layanan-desc">Data lain yang perlu dikoreksi — hubungi admin untuk informasi lebih.</div>
                <span class="layanan-badge">Menyusul</span>
            </a>
        </div>
    </div>
</section>


<section class="section-alur" id="alur">
    <div class="section-inner">
        <div class="section-label">Panduan</div>
        <h2 class="section-title">Alur Pengajuan</h2>
        <p class="section-desc">Proses pengajuan perubahan data selesai dalam beberapa langkah mudah.</p>

        <div class="alur-grid">
            <div class="alur-card">
                <div class="alur-num">1</div>
                <div class="alur-title">Daftar Akun</div>
                <div class="alur-desc">Isi data diri dengan NIK, NIM, email aktif, dan buat password akun.</div>
            </div>
            <div class="alur-card">
                <div class="alur-num">2</div>
                <div class="alur-title">Pilih Jenis Pengajuan</div>
                <div class="alur-desc">Pilih jenis data yang ingin diperbaiki dari daftar layanan yang tersedia.</div>
            </div>
            <div class="alur-card">
                <div class="alur-num">3</div>
                <div class="alur-title">Upload Dokumen</div>
                <div class="alur-desc">Unggah dokumen pendukung sesuai persyaratan (format PDF/JPG, maks 2MB).</div>
            </div>
            <div class="alur-card">
                <div class="alur-num">4</div>
                <div class="alur-title">Kirim Pengajuan</div>
                <div class="alur-desc">Kirim pengajuan ke UPA TIK dan tunggu verifikasi dari petugas.</div>
            </div>
            <div class="alur-card">
                <div class="alur-num">5</div>
                <div class="alur-title">Pantau Status</div>
                <div class="alur-desc">Cek progres pengajuan secara real-time melalui dashboard Anda.</div>
            </div>
        </div>
    </div>
</section>


<footer class="footer">
    <p>© <?php echo e(date('Y')); ?> <strong>UHO-Datasync</strong> — Portal Perubahan Data PDDIKTI Universitas Halu Oleo</p>
    <p style="margin-top:.4rem; font-size:.75rem; opacity:.6;">Dikelola oleh UPA TIK Universitas Halu Oleo · Kendari, Sulawesi Tenggara</p>
</footer>


<div class="modal-overlay" id="loginModal" onclick="closeLoginModal(event)">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal()">✕</button>

        <div class="modal-logo">
            <img src="<?php echo e(asset('storage/Logo-UHO-Normal-1.png')); ?>" alt="UHO">
        </div>

        <div class="modal-title">
            <h2>Masuk ke Akun Anda</h2>
            <p id="modalDesc">Silakan login untuk mengakses layanan ini</p>
        </div>

        <div class="modal-form">
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label">NIK (16 Digit)</label>
                    <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK Anda" maxlength="16" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password akun" required>
                </div>
                <button type="submit" class="modal-submit">Masuk ke Dashboard</button>
            </form>
        </div>

        <div class="modal-footer">
            Belum punya akun? <a href="<?php echo e(route('daftar')); ?>">Daftar sekarang</a>
        </div>
    </div>
</div>

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
    });

    // Login modal
    function showLoginModal(e, layananName) {
        e.preventDefault();
        document.getElementById('modalDesc').textContent = `Login diperlukan untuk mengakses layanan: ${layananName}`;
        document.getElementById('loginModal').classList.add('active');
    }
    function closeLoginModal(e) {
        if (e.target === document.getElementById('loginModal')) closeModal();
    }
    function closeModal() {
        document.getElementById('loginModal').classList.remove('active');
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>

</body>
</html><?php /**PATH F:\uho-datasync\resources\views/halaman_depan.blade.php ENDPATH**/ ?>