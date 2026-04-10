<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengaju;
use App\Models\JenisDokumen;
use App\Models\PengajuanHasDokumen;
use App\Models\Pengajuan; 
use App\Models\RiwayatPengajuan;
use App\Models\StatusPengajuan;
use App\Models\JenisPengajuan;

class PengajuanController extends Controller
{
    // ... (Fungsi index dan storeIdentitas TETAP SAMA seperti sebelumnya) ...
    public function index() {
        return view('halaman_depan'); 
    }

    public function storeIdentitas(Request $request) {
        $request->validate([
            'nik' => 'required|digits:16',
            'nim' => 'required|max:20',
            'nama_lengkap' => 'required|max:100',
            'alamat' => 'required',
            'jurusan' => 'required|max:50',
            'email' => 'required|email',
            'no_hp' => 'required|max:15',
            'password' => 'required|min:6'
        ]);

        $pengaju = Pengaju::updateOrCreate(
            ['nik' => $request->nik],
            [
                'nim' => $request->nim,
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'jurusan' => $request->jurusan,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password)
            ]
        );
        return redirect()->route('dashboard', ['nik' => $pengaju->nik]);
    }

    // --- UPDATE DI SINI ---
    public function dashboard($nik) {
    $pengaju = Pengaju::where('nik', $nik)->firstOrFail();
    
    $jenisDokumen = JenisDokumen::all(); 
    
    // --- PERUBAHAN DI SINI: Tambahkan 'with' untuk memuat syarat & nama dokumen ---
    $jenisPengajuan = JenisPengajuan::with('syarat.jenisDokumen') // Eager Loading
                        ->where('is_aktif', 1)
                        ->get(); 
    
    $pengajuanAktif = Pengajuan::where('id_pengaju', $pengaju->id)->latest()->first();

    $riwayat = [];
    if($pengajuanAktif) {
        $riwayat = RiwayatPengajuan::where('id_pengajuan', $pengajuanAktif->id)
                    ->with('status_pengajuan')
                    ->latest()
                    ->get();
    }

    return view('dashboard', compact('pengaju', 'jenisDokumen', 'jenisPengajuan', 'pengajuanAktif', 'riwayat'));
}

    public function uploadDokumen(Request $request) {
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg|max:2048',
            'id_jenis_dokumen' => 'required',
            'id_pengaju' => 'required'
        ]);

        // Buat Draft (Status ID 1) default Jenis ID 1 (nanti diupdate user)
        $pengajuan = Pengajuan::firstOrCreate(
            ['id_pengaju' => $request->id_pengaju, 'id_status_pengajuan' => 1], 
            ['id_jenis_pengajuan' => 1, 'keterangan_user' => 'Draft Upload'] 
        );

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');

        PengajuanHasDokumen::create([
            'id_pengajuan' => $pengajuan->id,
            'id_jenis_dokumen' => $request->id_jenis_dokumen,
            'path_file' => $path,
            'file_type' => $file->extension(),
            'file_size_kb' => round($file->getSize()/1024)
        ]);

        return back()->with('success', 'Dokumen berhasil diupload');
    }

    public function hapusDokumen($id) {
        $dokumen = PengajuanHasDokumen::find($id);
        if($dokumen) {
            $dokumen->delete(); 
            return back()->with('success', 'Dokumen dihapus (Soft Delete)');
        }
        return back()->with('error', 'Dokumen tidak ditemukan');
    }

    // --- FUNGSI BARU: KIRIM PENGAJUAN ---
    public function ajukan(Request $request) {
        $request->validate([
            'id_pengajuan' => 'required',
            'id_jenis_pengajuan' => 'required',
            'keterangan_user' => 'nullable'
        ]);

        $pengajuan = Pengajuan::find($request->id_pengajuan);
        
        // Update Status jadi "Diajukan ke UPA TIK" (ID 2)
        // Dan update jenis perubahan sesuai pilihan user
        $pengajuan->update([
            'id_status_pengajuan' => 2, 
            'id_jenis_pengajuan' => $request->id_jenis_pengajuan,
            'keterangan_user' => $request->keterangan_user
        ]);

        // Catat Riwayat
        RiwayatPengajuan::create([
            'id_pengajuan' => $pengajuan->id,
            'id_status_pengajuan' => 2,
            'catatan' => 'Mahasiswa mengirim pengajuan perubahan data.',
            'created_by' => 'Mahasiswa'
        ]);

        return back()->with('success', 'Pengajuan BERHASIL dikirim ke UPA TIK! Tunggu verifikasi.');
    }
}