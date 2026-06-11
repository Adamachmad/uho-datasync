<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - UHO-Datasync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body { background-color: #f0f2f5; }
        .card-header {
            background: linear-gradient(45deg, #0d6efd, #0a58ca);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        .required::after { content: " *"; color: red; }
        .form-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .section-title {
            color: #0d6efd;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 5px;
        }

        /* Hilangkan ikon silang validasi Bootstrap di form registrasi */
        .form-control.is-invalid,
        .was-validated .form-control:invalid,
        .form-select.is-invalid,
        .was-validated .form-select:invalid {
            background-image: none;
            padding-right: 0.75rem;
        }

        /* Kecilkan ikon silang SweetAlert validasi error */
        .swal2-popup.register-error-popup .swal2-icon.swal2-error {
            width: 2.1em !important;
            height: 2.1em !important;
            margin: 0.4em auto 0.5em !important;
            border-width: 0.15em !important;
        }

        .swal2-popup.register-error-popup .swal2-icon.swal2-error .swal2-x-mark {
            width: 1.2em !important;
            height: 1.2em !important;
        }

        .swal2-popup.register-error-popup .swal2-title {
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-5">
        <div class="container">
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand mb-0 h1" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: white;">
                <img src="<?php echo e(asset('storage/Logo-UHO-Normal-1.png')); ?>" alt="UHO Logo" style="height: 40px; width: auto;">
                <span>UHO-Datasync</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="<?php echo e(route('home')); ?>" class="nav-link">Beranda</a>
                    </li>
                    <?php if(Route::has('login')): ?>
                        <?php if(auth()->guard('pengaju')->check()): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('dashboard')); ?>" class="nav-link">Dashboard</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('login')); ?>" class="nav-link">Login</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header py-4 text-center">
                        <h4 class="mb-2">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Registrasi Data Identitas
                        </h4>
                        <small class="opacity-75">Lengkapi data diri Anda untuk mendapatkan akses ke sistem pelaporan PDDIKTI</small>
                    </div>

                    <div class="card-body p-4">
                        <!-- Alert Notifications -->
                        <?php if (isset($component)) { $__componentOriginal595130c251a216889416ab98c27af6a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal595130c251a216889416ab98c27af6a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert-notification','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-notification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal595130c251a216889416ab98c27af6a0)): ?>
<?php $attributes = $__attributesOriginal595130c251a216889416ab98c27af6a0; ?>
<?php unset($__attributesOriginal595130c251a216889416ab98c27af6a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal595130c251a216889416ab98c27af6a0)): ?>
<?php $component = $__componentOriginal595130c251a216889416ab98c27af6a0; ?>
<?php unset($__componentOriginal595130c251a216889416ab98c27af6a0); ?>
<?php endif; ?>

                        <form action="<?php echo e(route('identitas.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="bi bi-person-lock me-2"></i>
                                    Akun & Keamanan
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label required">NIK (Nomor Induk Kependudukan)</label>
                                        <input type="text" name="nik" class="form-control <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               placeholder="16 Digit Angka"
                                               value="<?php echo e(old('nik')); ?>"
                                               required
                                               maxlength="16"
                                               minlength="16"
                                               inputmode="numeric"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <small class="text-muted">Masukkan 16 digit angka sesuai KTP</small>
                                        <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">Password</label>
                                        <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               placeholder="Minimal 8 karakter"
                                               value="<?php echo e(old('password')); ?>"
                                               required>
                                        <small class="text-muted">Kombinasi huruf besar, kecil, dan angka</small>
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="bi bi-mortarboard me-2"></i>
                                    Data Akademik
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label required">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               placeholder="Sesuai Kartu Tanda Mahasiswa"
                                               value="<?php echo e(old('nama_lengkap')); ?>"
                                               required maxlength="100">
                                        <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">NIM (Nomor Induk Mahasiswa)</label>
                                        <input type="text" name="nim" class="form-control <?php $__errorArgs = ['nim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               placeholder="Contoh: F1G119001"
                                               value="<?php echo e(old('nim')); ?>"
                                               required maxlength="20">
                                        <?php $__errorArgs = ['nim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">Jurusan / Program Studi</label>
                                    <input type="text" name="jurusan" class="form-control <?php $__errorArgs = ['jurusan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Contoh: Teknik Informatika"
                                           value="<?php echo e(old('jurusan')); ?>"
                                           required maxlength="50">
                                    <?php $__errorArgs = ['jurusan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-section">
                                <h6 class="section-title">
                                    <i class="bi bi-telephone me-2"></i>
                                    Kontak & Domisili
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label required">Email Aktif</label>
                                        <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               placeholder="email@uho.ac.id"
                                               value="<?php echo e(old('email')); ?>"
                                               required>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label required">No. HP / WhatsApp</label>
                                        <input type="text" name="no_hp" class="form-control <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               placeholder="08xxxxxxxxxx"
                                               value="<?php echo e(old('no_hp')); ?>"
                                               required
                                               maxlength="15"
                                               inputmode="numeric"
                                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label required">Alamat Lengkap</label>
                                    <textarea name="alamat" class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              rows="3"
                                              placeholder="Jalan, Kelurahan, Kecamatan, Kota/Kabupaten, Kode Pos"
                                              required><?php echo e(old('alamat')); ?></textarea>
                                    <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    <i class="bi bi-person-check me-2"></i>
                                    Daftar & Buat Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(isset($errors) && $errors->any()): ?>
        <script>
            let errorList = '';
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                errorList += '<li><?php echo e($error); ?></li>';
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            Swal.fire({
                icon: 'error',
                customClass: {
                    popup: 'register-error-popup'
                },
                title: 'Validasi Gagal',
                html: '<ul style="text-align: left; margin-bottom: 0;">' + errorList + '</ul>',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#dc3545'
            });
        </script>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?php echo e(session("success")); ?>',
                confirmButtonColor: '#198754'
            });
        </script>
    <?php endif; ?>
</body>
</html><?php /**PATH F:\uho-datasync\resources\views/register.blade.php ENDPATH**/ ?>