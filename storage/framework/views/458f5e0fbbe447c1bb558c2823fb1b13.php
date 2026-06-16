<?php
    $pengajuAuth = Auth::guard('pengaju')->user();
?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" style="box-shadow: 0 1px 3px rgba(15,37,87,0.06);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2 no-underline">
                        <img src="<?php echo e(asset('storage/Logo-UHO-Normal-1.png')); ?>" alt="UHO Logo" style="height: 38px; width: auto;">
                        <span style="font-weight:700; font-size:.9rem; color:#0f2557; line-height:1.1;">
                            UHO-Datasync<br>
                            <span style="font-size:.65rem; font-weight:500; color:#6b7280; letter-spacing:.03em;">Portal Data Mahasiswa</span>
                        </span>
                    </a>
                </div>

                
                <?php if($pengajuAuth): ?>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => route('dashboard'),'active' => request()->routeIs('dashboard') || request()->routeIs('dashboard.detail')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard') || request()->routeIs('dashboard.detail'))]); ?>
                        <?php echo e(__('Dashboard')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <?php if($pengajuAuth): ?>
                    
                    <div x-data="{ dropOpen: false }" @click.outside="dropOpen = false" style="position:relative;">

                        
                        <button @click="dropOpen = !dropOpen"
                            :style="dropOpen ? 'border-color:#0f2557; background:white;' : ''"
                            style="
                                display:flex; align-items:center; gap:.5rem;
                                padding:.4rem .85rem .4rem .5rem;
                                background:#f0f4ff;
                                border:1.5px solid rgba(15,37,87,0.12);
                                border-radius:50px;
                                cursor:pointer;
                                transition:all .2s;
                                font-family:inherit;
                            ">
                            <div style="
                                width:32px; height:32px;
                                background:#0f2557;
                                border-radius:50%;
                                display:flex; align-items:center; justify-content:center;
                                color:white; font-size:.8rem; font-weight:700;
                                flex-shrink:0;
                            ">
                                <?php echo e(strtoupper(substr($pengajuAuth->nama_lengkap, 0, 1))); ?>

                            </div>
                            <span style="font-size:.875rem; font-weight:600; color:#0f2557; max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                <?php echo e($pengajuAuth->nama_lengkap); ?>

                            </span>
                            <svg :style="dropOpen ? 'transform:rotate(180deg)' : ''"
                                 style="color:#6b7280; transition:transform .2s; flex-shrink:0;"
                                 xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        
                        <div x-show="dropOpen"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             style="
                                position:absolute; right:0; top:calc(100% + 8px);
                                background:white;
                                border:1px solid rgba(15,37,87,0.1);
                                border-radius:14px;
                                box-shadow: 0 12px 40px rgba(15,37,87,0.15);
                                min-width:230px;
                                padding:.5rem;
                                z-index:50;
                             ">

                            
                            <div style="padding:.75rem 1rem .6rem; border-bottom:1px solid #f1f5f9; margin-bottom:.25rem;">
                                <div style="font-weight:700; color:#0f2557; font-size:.875rem;"><?php echo e($pengajuAuth->nama_lengkap); ?></div>
                                <div style="font-size:.72rem; color:#6b7280;"><?php echo e($pengajuAuth->email); ?></div>
                                <div style="font-size:.72rem; color:#6b7280;">NIM: <?php echo e($pengajuAuth->nim); ?></div>
                            </div>

                            <a href="<?php echo e(route('dashboard')); ?>" style="display:flex; align-items:center; gap:.6rem; padding:.6rem 1rem; border-radius:8px; font-size:.875rem; font-weight:500; color:#1e293b; text-decoration:none; transition:background .15s;"
                               onmouseover="this.style.background='#f0f4ff'" onmouseout="this.style.background='transparent'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                                Dashboard
                            </a>

                            <a href="<?php echo e(route('profile.edit')); ?>" style="display:flex; align-items:center; gap:.6rem; padding:.6rem 1rem; border-radius:8px; font-size:.875rem; font-weight:500; color:#1e293b; text-decoration:none; transition:background .15s;"
                               onmouseover="this.style.background='#f0f4ff'" onmouseout="this.style.background='transparent'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Profil Saya
                            </a>

                            <div style="height:1px; background:#f1f5f9; margin:.25rem 0;"></div>

                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" style="display:flex; align-items:center; gap:.6rem; padding:.6rem 1rem; border-radius:8px; font-size:.875rem; font-weight:500; color:#dc2626; background:none; border:none; cursor:pointer; width:100%; font-family:inherit; transition:background .15s;"
                                        onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                <?php else: ?>
                    
                    <a href="<?php echo e(route('login')); ?>" style="
                        display:flex; align-items:center; gap:.4rem;
                        padding:.45rem 1rem;
                        background:#f0f4ff;
                        color:#0f2557;
                        border:1.5px solid rgba(15,37,87,0.15);
                        border-radius:10px;
                        font-size:.875rem; font-weight:600;
                        text-decoration:none;
                        transition:all .2s;
                    "
                    onmouseover="this.style.background='#0f2557'; this.style.color='white'; this.style.borderColor='#0f2557';"
                    onmouseout="this.style.background='#f0f4ff'; this.style.color='#0f2557'; this.style.borderColor='rgba(15,37,87,0.15)';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        Masuk
                    </a>
                    <a href="<?php echo e(route('daftar')); ?>" style="
                        display:flex; align-items:center; gap:.4rem;
                        padding:.45rem 1.1rem;
                        background:#0f2557;
                        color:white;
                        border:1.5px solid #0f2557;
                        border-radius:10px;
                        font-size:.875rem; font-weight:600;
                        text-decoration:none;
                        transition:all .2s;
                    "
                    onmouseover="this.style.background='#1a3a8f'; this.style.boxShadow='0 4px 12px rgba(15,37,87,0.3)';"
                    onmouseout="this.style.background='#0f2557'; this.style.boxShadow='none';">
                        Daftar
                    </a>
                <?php endif; ?>
            </div>

            
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <?php if($pengajuAuth): ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('dashboard'),'active' => request()->routeIs('dashboard') || request()->routeIs('dashboard.detail')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard')),'active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard') || request()->routeIs('dashboard.detail'))]); ?>
                <?php echo e(__('Dashboard')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php else: ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('login')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('login'))]); ?>Masuk <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('daftar')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('daftar'))]); ?>Daftar <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if($pengajuAuth): ?>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800"><?php echo e($pengajuAuth->nama_lengkap); ?></div>
                <div class="font-medium text-sm text-gray-500"><?php echo e($pengajuAuth->email); ?></div>
            </div>
            <div class="mt-3 space-y-1">
                <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?><?php echo e(__('Profil Saya')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php if (isset($component)) { $__componentOriginald69b52d99510f1e7cd3d80070b28ca18 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.responsive-nav-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
                        <?php echo e(__('Keluar')); ?>

                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $attributes = $__attributesOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__attributesOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18)): ?>
<?php $component = $__componentOriginald69b52d99510f1e7cd3d80070b28ca18; ?>
<?php unset($__componentOriginald69b52d99510f1e7cd3d80070b28ca18); ?>
<?php endif; ?>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</nav><?php /**PATH F:\uho-datasync\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>