<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;

Route::get('/', [PengajuanController::class, 'index'])->name('home');
Route::post('/simpan-identitas', [PengajuanController::class, 'storeIdentitas'])->name('identitas.store');

Route::get('/dashboard-old', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard.old');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== FIX BUG #1: Add auth middleware to protect dashboard =====
    Route::get('/dashboard/{nik}', [PengajuanController::class, 'dashboard'])->name('dashboard');

    // Aksi Dokumen
    // ===== FIX BUG #16: Add rate limiting to file upload =====
    Route::post('/dokumen/upload', [PengajuanController::class, 'uploadDokumen'])
        ->middleware('throttle:uploads')
        ->name('dokumen.upload');
    
    Route::delete('/dokumen/hapus/{id}', [PengajuanController::class, 'hapusDokumen'])->name('dokumen.hapus');

    // AKSI: Finalisasi Pengajuan
    Route::post('/ajukan-perubahan', [PengajuanController::class, 'ajukan'])->name('pengajuan.submit');
});

require __DIR__.'/auth.php';
