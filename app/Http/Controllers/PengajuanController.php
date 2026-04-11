<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengaju;
use App\Models\JenisDokumen;
use App\Models\PengajuanHasDokumen;
use App\Models\Pengajuan; 
use App\Models\RiwayatPengajuan;
use App\Models\StatusPengajuan;
use App\Models\JenisPengajuan;
use App\Models\SyaratPengajuan;

class PengajuanController extends Controller
{
    private function getStatusIdByNama(string $namaStatus, ?int $fallback = null): int
    {
        return (int) (StatusPengajuan::where('nama_status', $namaStatus)->value('id') ?? $fallback);
    }

    private function getDraftStatusId(): int
    {
        return $this->getStatusIdByNama('Draft', 1);
    }

    // ... (Fungsi index dan storeIdentitas TETAP SAMA seperti sebelumnya) ...
    public function index() {
        return view('halaman_depan');
    }

    public function register() {
        return view('register');
    }

    public function storeIdentitas(Request $request) {
        // ===== FIX BUG #9 & #10: Improve password & NIK validation =====
        $request->validate([
            'nik' => 'required|digits:16', // Just validate 16 digits
            'nim' => 'required|max:20|alpha_num', // Alphanumeric only
            'nama_lengkap' => 'required|max:100', // Simple text validation
            'alamat' => 'required|max:255',
            'jurusan' => 'required|max:50',
            'email' => 'required|email|max:100',
            'no_hp' => ['required', 'max:15', 'regex:/^(\+62|62|0)\d{9,12}$/'], // Indonesian phone number
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/'] // At least 8 chars with upper, lower, digit
        ], [
            'nik.required' => 'NIK harus diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 angka.',
            'nim.required' => 'NIM harus diisi.',
            'nim.max' => 'NIM maksimal 20 karakter.',
            'nim.alpha_num' => 'NIM hanya boleh berisi huruf dan angka.',
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'jurusan.required' => 'Jurusan harus diisi.',
            'jurusan.max' => 'Jurusan maksimal 50 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus format yang valid (contoh: user@email.com).',
            'email.max' => 'Email maksimal 100 karakter.',
            'no_hp.required' => 'Nomor HP harus diisi.',
            'no_hp.max' => 'Nomor HP maksimal 15 karakter.',
            'no_hp.regex' => 'Nomor HP harus dimulai dengan +62, 62, atau 0 dilanjutkan 9-12 angka.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung kombinasi huruf besar, huruf kecil, dan angka.',
        ]);

        try {
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
        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return back()->withErrors(['nim' => 'NIM, Email, atau No HP ini sudah digunakan oleh akun lain (berbeda NIK). Silakan periksa kembali data Anda.'])->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? 0;
            if ($errorCode == 1062) {
                return back()->withErrors(['nim' => 'NIM, Email, atau No HP ini sudah digunakan oleh akun lain (berbeda NIK). Silakan periksa kembali data Anda.'])->withInput();
            }
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem saat menyimpan data.'])->withInput();
        }

        // ===== FIX: Auto-login setelah registrasi =====
        Auth::guard('pengaju')->login($pengaju);
        
        return redirect()->route('dashboard');
    }

    // --- UPDATE DI SINI ---
    public function dashboard($nik) {
        // Middleware pengaju.auth already checks authentication
        $pengaju = Pengaju::where('nik', $nik)->firstOrFail();
        
        // ===== SECURITY: Check if current user owns this data =====
        if ($pengaju->id != auth()->guard('pengaju')->id()) {
            abort(403, 'Anda tidak memiliki akses ke dashboard ini.');
        }
    
        $jenisDokumen = JenisDokumen::all(); 
        
        // --- PERUBAHAN DI SINI: Tambahkan 'with' untuk memuat syarat & nama dokumen ---
        $jenisPengajuan = JenisPengajuan::with('syarat.jenisDokumen') // Eager Loading
                            ->where('is_aktif', 1)
                            ->get(); 
        
        $pengajuanAktif = Pengajuan::where('id_pengaju', $pengaju->id)->latest()->first();
        $draftStatusId = $this->getDraftStatusId();

        $pengajuanDraft = Pengajuan::where('id_pengaju', $pengaju->id)
            ->where('id_status_pengajuan', $draftStatusId)
            ->latest()
            ->first();

        $dokumenDiunggah = collect();
        if ($pengajuanDraft) {
            $dokumenDiunggah = PengajuanHasDokumen::where('id_pengajuan', $pengajuanDraft->id)
                ->with('jenisDokumen')
                ->latest()
                ->get();
        }

        $riwayat = [];
        if($pengajuanAktif) {
            $riwayat = RiwayatPengajuan::where('id_pengajuan', $pengajuanAktif->id)
                        ->with('status_pengajuan')
                        ->latest()
                        ->get();
        }

        return view('dashboard', compact('pengaju', 'jenisDokumen', 'jenisPengajuan', 'pengajuanAktif', 'pengajuanDraft', 'dokumenDiunggah', 'riwayat'));
    }

    public function uploadDokumen(Request $request) {
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg|max:2048',
            'id_jenis_dokumen' => 'required',
            'id_pengaju' => 'required'
        ], [
            'file.required' => 'File harus diunggah.',
            'file.mimes' => 'Format file hanya boleh PDF atau JPG/JPEG.',
            'file.max' => 'Ukuran file maksimal 2 MB.',
            'id_jenis_dokumen.required' => 'Jenis dokumen harus dipilih.',
            'id_pengaju.required' => 'Data pengaju tidak valid.',
        ]);

        if ((int) $request->id_pengaju !== (int) Auth::guard('pengaju')->id()) {
            abort(403, 'Akses tidak valid untuk upload dokumen.');
        }

        // ===== FIX BUG #5: Ensure only one draft pengajuan per user =====
        // Look for existing draft (status 1) for this user
        $draftStatusId = $this->getDraftStatusId();

        $pengajuan = Pengajuan::where('id_pengaju', $request->id_pengaju)
            ->where('id_status_pengajuan', $draftStatusId)
            ->first();

        // Create new draft only if none exists
        if (!$pengajuan) {
            $pengajuan = Pengajuan::create([
                'id_pengaju' => $request->id_pengaju,
                'id_jenis_pengajuan' => 1,
                'id_status_pengajuan' => $draftStatusId,
                'keterangan_user' => 'Draft Upload'
            ]);
        }

        // ===== FIX BUG #13: Cek status sebelum upload =====
        if ((int) $pengajuan->id_status_pengajuan !== (int) $draftStatusId) {
            return back()->with('error', '❌ Tidak bisa mengupload dokumen setelah pengajuan dikirim. Status saat ini: ' . $pengajuan->status_pengajuan->nama_status);
        }

        $file = $request->file('file');
        
        // ===== FIX BUG #2: Server-side file type validation =====
        $allowedMimes = ['application/pdf', 'image/jpeg', 'image/jpg'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            return back()->with('error', '❌ Tipe file tidak diizinkan. Hanya PDF atau JPG.');
        }

        // Sanitize filename (FIX BUG #4: Path traversal)
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $originalName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
        $filename = time() . '_' . $originalName . '.' . $file->guessExtension();
        
        $path = $file->storeAs('uploads', $filename, 'public');

        $existing = PengajuanHasDokumen::where('id_pengajuan', $pengajuan->id)
            ->where('id_jenis_dokumen', $request->id_jenis_dokumen)
            ->first();

        if ($existing) {
            if ($existing->path_file && Storage::disk('public')->exists($existing->path_file)) {
                Storage::disk('public')->delete($existing->path_file);
            }
            $existing->delete();
        }

        PengajuanHasDokumen::create([
            'id_pengajuan' => $pengajuan->id,
            'id_jenis_dokumen' => $request->id_jenis_dokumen,
            'path_file' => $path,
            'file_type' => $file->guessExtension(),
            'file_size_kb' => round($file->getSize()/1024)
        ]);

        return back()->with('success', '✅ Dokumen berhasil diupload');
    }

    public function hapusDokumen($id)
    {
        $dokumen = PengajuanHasDokumen::with('pengajuan')->findOrFail($id);

        if (!$dokumen->pengajuan || $dokumen->pengajuan->id_pengaju != Auth::guard('pengaju')->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus dokumen ini.');
        }

        if ((int) $dokumen->pengajuan->id_status_pengajuan !== (int) $this->getDraftStatusId()) {
            return back()->with('error', 'Dokumen tidak bisa dihapus karena pengajuan sudah dikirim.');
        }

        if ($dokumen->path_file && Storage::disk('public')->exists($dokumen->path_file)) {
            Storage::disk('public')->delete($dokumen->path_file);
        }

        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Helper: Validasi apakah semua dokumen wajib sudah terupload
     * @return array berisi error messages jika ada dokumen yang kurang, atau empty jika OK
     */
    private function validateRequiredDocuments($idPengajuan, $idJenisPengajuan)
    {
        $errors = [];
        
        // Ambil list dokumen wajib untuk jenis pengajuan ini
        $requiredDocs = SyaratPengajuan::where([
            'id_jenis_pengajuan' => $idJenisPengajuan,
            'is_wajib' => 1
        ])->with('jenisDokumen')->get();

        // Ambil dokumen yang sudah diupload
        $uploadedDocs = PengajuanHasDokumen::where('id_pengajuan', $idPengajuan)
            ->pluck('id_jenis_dokumen')
            ->toArray();

        // Cek mana yang belum diupload
        foreach ($requiredDocs as $syarat) {
            if (!in_array($syarat->id_jenis_dokumen, $uploadedDocs)) {
                $errors[] = "Dokumen '{$syarat->jenisDokumen->nama_dokumen}' belum diunggah (wajib).";
            }
        }

        return $errors;
    }

    // --- FUNGSI BARU: KIRIM PENGAJUAN ---
    public function ajukan(Request $request) {
        $request->validate([
            'id_pengajuan' => 'required',
            'id_jenis_pengajuan' => 'required',
            'keterangan_user' => 'nullable'
        ]);

        $pengajuan = Pengajuan::find($request->id_pengajuan);
        
        if (!$pengajuan) {
            return back()->with('error', 'Data pengajuan tidak ditemukan.');
        }

        if ($pengajuan->id_pengaju != Auth::guard('pengaju')->id()) {
            abort(403, 'Anda tidak berhak mengirim pengajuan ini.');
        }

        $draftStatusId = $this->getDraftStatusId();
        $terkirimPustikId = $this->getStatusIdByNama(StatusPengajuan::TERKIRIM_PUSTIK, 2);

        if ((int) $pengajuan->id_status_pengajuan !== (int) $draftStatusId) {
            return back()->with('error', 'Pengajuan ini bukan draft dan tidak bisa dikirim ulang.');
        }

        // ===== VALIDASI BARU: CEK DOKUMEN WAJIB =====
        $validationErrors = $this->validateRequiredDocuments(
            $request->id_pengajuan, 
            $request->id_jenis_pengajuan
        );

        if (!empty($validationErrors)) {
            return back()->with('error', 'Pengajuan gagal! ' . implode(' ', $validationErrors))->withInput();
        }

        // Update status awal alur resmi: TERKIRIM_PUSTIK
        $pengajuan->update([
            'id_status_pengajuan' => $terkirimPustikId,
            'id_jenis_pengajuan' => $request->id_jenis_pengajuan,
            'keterangan_user' => $request->keterangan_user,
            'keterangan_penolakan' => null,
        ]);

        // Catat Riwayat
        RiwayatPengajuan::create([
            'id_pengajuan' => $pengajuan->id,
            'id_status_pengajuan' => $terkirimPustikId,
            'catatan' => StatusPengajuan::LABELS[StatusPengajuan::TERKIRIM_PUSTIK] ?? 'Mahasiswa mengirim pengajuan perubahan data.',
            'keterangan_penolakan' => null,
            'created_by' => 'Mahasiswa'
        ]);

        return back()->with('success', 'Pengajuan BERHASIL dikirim ke UPA TIK! Tunggu verifikasi.');
    }
}