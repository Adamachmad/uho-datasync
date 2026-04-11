<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Pengajuan PDDIKTI
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Selamat datang, <?php echo e($pengaju->nama_lengkap); ?> (NIK: <?php echo e($pengaju->nik); ?>)
                </p>
                <p class="text-xs text-amber-700 mt-2">
                    <strong>Alur wajib:</strong> Upload dokumen terlebih dahulu, lalu kirim pengajuan perubahan data.
                </p>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <!-- Info Pengaju -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Nomor Induk Kependudukan</div>
                    <div class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($pengaju->nik); ?></div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">NIM</div>
                    <div class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($pengaju->nim); ?></div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Status Pengajuan</div>
                    <div class="text-lg font-bold text-gray-900 mt-2">
                        <?php if($pengajuanAktif): ?>
                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                <?php echo e($pengajuanAktif->status_pengajuan->nama_status ?? 'Draft'); ?>

                            </span>
                        <?php else: ?>
                            <span class="text-gray-500">Belum ada pengajuan</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Pilih Jenis Pengajuan -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-900">
                                <i class="bi bi-file-earmark-text me-2"></i>Pilih Jenis Pengajuan
                            </h3>
                        </div>
                        <div class="p-6">
                            <?php if($jenisPengajuan->count() > 0): ?>
                                <?php $__currentLoopData = $jenisPengajuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border rounded-lg p-4 mb-4 hover:shadow-md transition">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900"><?php echo e($jenis->nama_pengajuan); ?></h4>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo e($jenis->keterangan); ?></p>
                                                
                                                <?php if($jenis->syarat->count() > 0): ?>
                                                    <div class="mt-3 text-sm text-gray-700">
                                                        <p class="font-medium mb-2">Dokumen yang diperlukan:</p>
                                                        <ul class="list-disc list-inside space-y-1 ml-2">
                                                            <?php $__currentLoopData = $jenis->syarat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $syarat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li>
                                                                    <?php echo e($syarat->jenisDokumen->nama_dokumen ?? 'Dokumen'); ?>

                                                                    <?php if($syarat->is_wajib): ?>
                                                                        <span class="text-red-600 font-bold">*</span>
                                                                    <?php endif; ?>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <p class="text-gray-500">Tidak ada jenis pengajuan yang tersedia</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-24">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="font-semibold text-lg text-gray-900">
                                <i class="bi bi-cloud-upload me-2"></i>Upload Dokumen
                            </h3>
                        </div>
                        <div class="p-6">
                            <?php if(!$pengajuanAktif || $pengajuanAktif->id_status_pengajuan == 1): ?>
                                <form action="<?php echo e(route('dokumen.upload')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    <?php echo csrf_field(); ?>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen</label>
                                        <select name="id_jenis_dokumen" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                            <option value="">-- Pilih Dokumen --</option>
                                            <?php $__currentLoopData = $jenisDokumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($dok->id); ?>"><?php echo e($dok->nama_dokumen); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">File (PDF/JPG, Max 2MB)</label>
                                        <input type="file" name="file" accept=".pdf,.jpg,.jpeg" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                    </div>

                                    <input type="hidden" name="id_pengaju" value="<?php echo e($pengaju->id); ?>">

                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                                        Upload File
                                    </button>
                                </form>

                                <?php if($dokumenDiunggah->count() > 0): ?>
                                    <div class="mt-5 border-t pt-4">
                                        <h4 class="text-sm font-semibold text-gray-800 mb-3">Dokumen yang sudah diunggah</h4>
                                        <div class="space-y-2">
                                            <?php $__currentLoopData = $dokumenDiunggah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center justify-between bg-gray-50 border rounded p-2">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-800"><?php echo e($dok->jenisDokumen->nama_dokumen ?? 'Dokumen'); ?></p>
                                                        <a class="text-xs text-blue-600 hover:underline" href="<?php echo e(asset('storage/' . $dok->path_file)); ?>" target="_blank">Lihat file</a>
                                                    </div>
                                                    <form method="POST" action="<?php echo e(route('dokumen.hapus', $dok->id)); ?>" onsubmit="return confirm('Hapus dokumen ini?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="text-xs px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded">Hapus</button>
                                                    </form>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-gray-500 text-sm">Upload dokumen ditutup karena pengajuan terakhir sudah dikirim.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="font-semibold text-lg text-gray-900">
                        <i class="bi bi-send-check me-2"></i>Kirim Pengajuan
                    </h3>
                </div>
                <div class="p-6">
                    <?php if($pengajuanDraft): ?>
                        <p class="text-sm text-amber-700 mb-4">Pastikan seluruh dokumen wajib sudah terunggah sebelum klik tombol kirim pengajuan.</p>
                        <form action="<?php echo e(route('pengajuan.submit')); ?>" method="POST" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id_pengajuan" value="<?php echo e($pengajuanDraft->id); ?>">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pengajuan</label>
                                <select name="id_jenis_pengajuan" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                    <option value="">-- Pilih Jenis Pengajuan --</option>
                                    <?php $__currentLoopData = $jenisPengajuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($jenis->id); ?>"><?php echo e($jenis->nama_pengajuan); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan (Opsional)</label>
                                <textarea name="keterangan_user" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2" placeholder="Tulis keterangan tambahan jika ada..."></textarea>
                            </div>

                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition">
                                Kirim Pengajuan ke UPA TIK
                            </button>
                        </form>
                    <?php else: ?>
                        <p class="text-sm text-gray-600">Upload dokumen terlebih dahulu sebelum melakukan pengajuan.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Riwayat Pengajuan -->
            <?php if($pengajuanAktif): ?>
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="font-semibold text-lg text-gray-900">
                            <i class="bi bi-clock-history me-2"></i>Riwayat Pengajuan
                        </h3>
                    </div>
                    <div class="p-6">
                        <?php if($riwayat->count() > 0): ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                                                <i class="bi bi-check-circle text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900"><?php echo e($item->status_pengajuan->nama_status ?? 'Unknown'); ?></p>
                                            <p class="text-sm text-gray-600"><?php echo e($item->keterangan); ?></p>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo e($item->created_at->format('d M Y H:i')); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500">Belum ada riwayat pengajuan</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH F:\uho-datasync\resources\views/dashboard.blade.php ENDPATH**/ ?>