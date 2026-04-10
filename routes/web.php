<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;



Route::get('/', [PengajuanController::class, 'index'])->name('home');
Route::post('/simpan-identitas', [PengajuanController::class, 'storeIdentitas'])->name('identitas.store');

Route::get('/dashboard/{nik}', [PengajuanController::class, 'dashboard'])->name('dashboard');

// Aksi Dokumen
Route::post('/dokumen/upload', [PengajuanController::class, 'uploadDokumen'])->name('dokumen.upload');
Route::delete('/dokumen/hapus/{id}', [PengajuanController::class, 'hapusDokumen'])->name('dokumen.hapus');

// AKSI BARU: Finalisasi Pengajuan
Route::post('/ajukan-perubahan', [PengajuanController::class, 'ajukan'])->name('pengajuan.submit');