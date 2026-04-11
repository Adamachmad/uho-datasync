<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UHO-Datasync - Universitas Halu Oleo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .btn-custom {
            background: linear-gradient(45deg, #0d6efd, #0a58ca);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent mb-5">
        <div class="container">
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand mb-0 h1" style="text-decoration: none; color: white;">
                <img src="<?php echo e(asset('storage/Logo-UHO-Normal-1.png')); ?>" alt="UHO Logo">
                <span>UHO-Datasync</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#tentang" class="nav-link">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a href="#fitur" class="nav-link">Fitur</a>
                    </li>
                    <?php if(Route::has('login')): ?>
                        <?php if(auth()->guard('pengaju')->check()): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('dashboard')); ?>" class="nav-link btn btn-custom text-white ms-2">Dashboard</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('login')); ?>" class="nav-link btn btn-outline-light ms-2">Login</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alert Notifications -->
    <div class="container mt-3">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Kesalahan Input Data</strong>
                <ul class="mt-2 mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="container">
        <!-- Hero Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="hero-section p-5 text-center text-white">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="bi bi-university me-3"></i>
                        UHO-Datasync
                    </h1>
                    <p class="lead mb-4 fs-5">
                        Universitas Halu Oleo (UHO) - Platform terintegrasi untuk pengelolaan dan pelaporan data akademik mahasiswa
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <?php if(auth()->guard('pengaju')->check()): ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-custom btn-lg">
                                <i class="bi bi-speedometer2 me-2"></i>Akses Dashboard
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-light btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sistem
                            </a>
                            <a href="<?php echo e(route('daftar')); ?>" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-person-plus me-2"></i>Daftar Baru
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="fitur" class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 text-center h-100">
                    <div class="mb-3">
                        <i class="bi bi-person-check-fill text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Registrasi Data Diri</h5>
                    <p class="text-muted">
                        Lengkapi data identitas mahasiswa dengan validasi yang ketat untuk memastikan keakuratan data akademik.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 text-center h-100">
                    <div class="mb-3">
                        <i class="bi bi-file-earmark-text-fill text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Upload Dokumen</h5>
                    <p class="text-muted">
                        Unggah berbagai dokumen pendukung dengan batasan ukuran dan format yang telah ditentukan.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card p-4 text-center h-100">
                    <div class="mb-3">
                        <i class="bi bi-graph-up-arrow text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Monitoring Status</h5>
                    <p class="text-muted">
                        Pantau status pengajuan secara real-time dengan riwayat lengkap dan notifikasi perubahan.
                    </p>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div id="tentang" class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="feature-card p-5 text-center">
                    <h3 class="fw-bold mb-4 text-primary">Tentang Sistem</h3>
                    <p class="lead text-muted mb-4" style="text-align: justify;">
                        Era transformasi digital menuntut institusi pendidikan tinggi untuk terus berinovasi dalam mengelola administrasi akademik yang efisien, transparan, dan akuntabel. Pangkalan Data Pendidikan Tinggi (PDDIKTI) pusat merupakan pusat rujukan data nasional yang memegang peranan vital dalam memastikan keabsahan status akademik seorang mahasiswa. Validitas data di PDDIKTI sangat menentukan berbagai aspek krusial dalam siklus kehidupan akademik mahasiswa, mulai dari pendaftaran beasiswa, validasi ijazah, pendaftaran program Kampus Merdeka, hingga persyaratan seleksi Calon Pegawai Negeri Sipil (CPNS). Oleh karena itu, ketidaksesuaian data akademik yang disebabkan oleh kesalahan proses manual konvensional dapat berdampak fatal bagi mahasiswa.
                    </p>
                    <p class="lead text-muted mb-4" style="text-align: justify;">
                        Di Universitas Halu Oleo (UHO), Unit Penunjang Akademik Teknologi Informasi dan Komunikasi (UPA TIK) adalah muara dari seluruh proses perbaikan data mahasiswa sebelum disinkronisasikan ke PDDIKTI pusat. UHO-Datasync hadir sebagai platform terintegrasi untuk mendigitalisasi proses pelayanan ini secara 'end-to-end'. Melalui implementasi fitur manajemen dokumen dinamis yang menyeleksi kelengkapan berkas prasyarat secara otomatis sesuai kategori permohonan, serta dilengkapi dengan dasbor pemantauan real-time bagi mahasiswa, UHO-Datasync mentransformasi birokrasi manual menjadi alur kerja digital yang terukur dan akuntabel. Kehadiran aplikasi ini mempercepat proses sinkronisasi data kementerian guna mendukung perwujudan visi smart campus di Universitas Halu Oleo.
                    </p>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3">
                                <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Data Aman</h6>
                                <small class="text-muted">Enkripsi dan validasi ketat</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3">
                                <i class="bi bi-clock-history text-primary" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Real-time</h6>
                                <small class="text-muted">Update status instan</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3">
                                <i class="bi bi-people-fill text-warning" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">User Friendly</h6>
                                <small class="text-muted">Interface intuitif</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center text-white-50 py-4">
            <div class="container">
                <p class="mb-2">
                    <strong>Universitas Halu Oleo</strong> - Sistem Informasi Akademik
                </p>
                <small>&copy; 2024 Universitas Halu Oleo. All rights reserved.</small>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH F:\uho-datasync\resources\views/halaman_depan.blade.php ENDPATH**/ ?>