<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Pengaju;
use App\Models\RiwayatPengajuan;
use App\Models\StatusPengajuan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statusTerkirimPustik = StatusPengajuan::where('nama_status', StatusPengajuan::TERKIRIM_PUSTIK)->first();

        $stats = [
            'total_pengaju' => Pengaju::count(),
            'total_pengajuan' => Pengajuan::count(),
            'menunggu_verifikasi' => $statusTerkirimPustik
                ? Pengajuan::where('id_status_pengajuan', $statusTerkirimPustik->id)->count()
                : 0,
            'total_admin' => User::whereIn('role', ['admin', 'super_admin'])->count(),
        ];

        $pengajuanTerbaru = Pengajuan::with(['pengaju', 'jenis_pengajuan', 'status_pengajuan'])
            ->latest()
            ->take(10)
            ->get();

        $statusFlow = StatusPengajuan::query()
            ->whereIn('nama_status', [
                StatusPengajuan::TERKIRIM_PUSTIK,
                StatusPengajuan::VERIFIKASI_PUSTIK,
                StatusPengajuan::TERKIRIM_PDDIKTI,
                StatusPengajuan::SELESAI,
                StatusPengajuan::DITOLAK,
            ])
            ->orderBy('urutan')
            ->get();

        return view('admin.dashboard', compact('stats', 'pengajuanTerbaru', 'statusFlow'));
    }

    public function updateStatus(Request $request, Pengajuan $pengajuan): RedirectResponse
    {
        $validated = $request->validate([
            'id_status_pengajuan' => ['required', 'exists:status_pengajuan,id'],
            'catatan' => ['nullable', 'string'],
            'keterangan_penolakan' => ['nullable', 'string'],
        ]);

        $status = StatusPengajuan::findOrFail($validated['id_status_pengajuan']);
        $allowedStatus = [
            StatusPengajuan::TERKIRIM_PUSTIK,
            StatusPengajuan::VERIFIKASI_PUSTIK,
            StatusPengajuan::TERKIRIM_PDDIKTI,
            StatusPengajuan::SELESAI,
            StatusPengajuan::DITOLAK,
        ];

        if (!in_array($status->nama_status, $allowedStatus, true)) {
            return back()->withErrors([
                'id_status_pengajuan' => 'Status yang dipilih tidak termasuk alur resmi pengajuan.',
            ]);
        }

        $alasanPenolakan = trim((string) ($validated['keterangan_penolakan'] ?? ''));

        if ($status->nama_status === StatusPengajuan::DITOLAK && $alasanPenolakan === '') {
            return back()->withErrors([
                'keterangan_penolakan' => 'Alasan penolakan wajib diisi jika status DITOLAK.',
            ]);
        }

        DB::transaction(function () use ($pengajuan, $status, $validated, $alasanPenolakan): void {
            $catatan = trim((string) ($validated['catatan'] ?? ''));

            $pengajuan->update([
                'id_status_pengajuan' => $status->id,
                'keterangan_penolakan' => $status->nama_status === StatusPengajuan::DITOLAK ? $alasanPenolakan : null,
            ]);

            RiwayatPengajuan::create([
                'id_pengajuan' => $pengajuan->id,
                'id_status_pengajuan' => $status->id,
                'catatan' => $catatan !== '' ? $catatan : ($status->label ?? 'Status pengajuan diperbarui oleh Admin PUSTIK.'),
                'keterangan_penolakan' => $status->nama_status === StatusPengajuan::DITOLAK ? $alasanPenolakan : null,
                'created_by' => auth()->user()?->name ?? 'Admin PUSTIK',
            ]);
        });

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
