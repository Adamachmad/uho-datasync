<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - UHO-Datasync</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo e(route('admin.dashboard')); ?>">
                <img src="<?php echo e(asset('storage/Logo-UHO-Normal-1.png')); ?>" alt="UHO" style="height: 36px">
                <span>Admin UHO-Datasync</span>
            </a>

            <div class="d-flex align-items-center gap-3 text-white">
                <span><?php echo e(auth()->user()->name); ?> (<?php echo e(auth()->user()->role); ?>)</span>
                <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-sm btn-outline-light" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Total Pengaju</div>
                        <div class="fs-3 fw-bold"><?php echo e($stats['total_pengaju']); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Total Pengajuan</div>
                        <div class="fs-3 fw-bold"><?php echo e($stats['total_pengajuan']); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Menunggu Verifikasi</div>
                        <div class="fs-3 fw-bold"><?php echo e($stats['menunggu_verifikasi']); ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted small">Admin + Super Admin</div>
                        <div class="fs-3 fw-bold"><?php echo e($stats['total_admin']); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <strong>10 Pengajuan Terbaru</strong>
            </div>
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pengaju</th>
                            <th>NIM</th>
                            <th>Jenis Pengajuan</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pengajuanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="cursor: pointer;" onclick="window.location='<?php echo e(route('admin.pengajuan.show', $item)); ?>'">
                                <td><?php echo e($i + 1); ?></td>
                                <td><?php echo e($item->pengaju->nama_lengkap ?? '-'); ?></td>
                                <td><?php echo e($item->pengaju->nim ?? '-'); ?></td>
                                <td><?php echo e($item->jenis_pengajuan->nama_pengajuan ?? '-'); ?></td>
                                <td>
                                    <span class="badge badge-pill <?php echo e($item->status_pengajuan->badge_class ?? 'bg-gray-100'); ?>">
                                        <?php echo e($item->status_pengajuan->label ?? $item->status_pengajuan->nama_status ?? '-'); ?>

                                    </span>
                                </td>
                                <td><?php echo e($item->created_at->format('d/m/Y H:i')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data pengajuan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
<?php /**PATH F:\uho-datasync\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>