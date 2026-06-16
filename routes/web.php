<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;

Route::get('/', [PengajuanController::class, 'index'])->name('home');
Route::get('/daftar', [PengajuanController::class, 'register'])->name('daftar');
Route::post('/simpan-identitas', [PengajuanController::class, 'storeIdentitas'])->name('identitas.store');

Route::get('/dashboard-old', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard.old');

Route::middleware('pengaju.auth')->group(function () {
    Route::get('/dashboard', function () {
        $pengaju = auth()->guard('pengaju')->user();
        return redirect()->route('dashboard.detail', ['nik' => $pengaju->nik]);
    })->name('dashboard');

    Route::get('/dashboard/{nik}', [PengajuanController::class, 'dashboard'])->name('dashboard.detail');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Aksi Dokumen
    // ===== FIX BUG #16: Add rate limiting to file upload =====
    Route::post('/dokumen/upload', [PengajuanController::class, 'uploadDokumen'])
        ->middleware('throttle:uploads')
        ->name('dokumen.upload');

    Route::delete('/dokumen/hapus/{id}', [PengajuanController::class, 'hapusDokumen'])->name('dokumen.hapus');

    // AKSI: Finalisasi Pengajuan
    Route::post('/ajukan-perubahan', [PengajuanController::class, 'ajukan'])->name('pengajuan.submit');

    // AKSI: Ajukan Ulang setelah ditolak  ← TAMBAHKAN INI
    Route::post('/ajukan-ulang', [PengajuanController::class, 'ajukanUlang'])->name('pengajuan.ajukan-ulang');
});

Route::prefix('admin')->group(function () {
    Route::middleware('guest:web')->group(function () {
        Route::get('/login', [AdminAuthenticatedSessionController::class, 'create'])->name('admin.login');
        Route::post('/login', [AdminAuthenticatedSessionController::class, 'store'])->name('admin.login.submit');
    });

    Route::middleware(['auth:web', 'role:admin,super_admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/pengajuan/{pengajuan}', [AdminDashboardController::class, 'show'])->name('admin.pengajuan.show');
        Route::post('/pengajuan/{pengajuan}/status', [AdminDashboardController::class, 'updateStatus'])->name('admin.pengajuan.update-status');
        Route::post('/logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
    });
});

require __DIR__.'/auth.php';
