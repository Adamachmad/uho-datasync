<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Pengajuan PDDIKTI
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Selamat datang, {{ $pengaju->nama_lengkap }} (NIK: {{ $pengaju->nik }})
                </p>
                <p class="text-xs text-amber-700 mt-2">
                    <strong>Alur wajib:</strong> Upload dokumen terlebih dahulu, lalu kirim pengajuan perubahan data.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert Notifications -->
            <x-alert-notification />

            <!-- Info Pengaju -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Nomor Induk Kependudukan</div>
                    <div class="text-2xl font-bold text-gray-900 mt-2">{{ $pengaju->nik }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">NIM</div>
                    <div class="text-2xl font-bold text-gray-900 mt-2">{{ $pengaju->nim }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Status Pengajuan</div>
                    <div class="text-lg font-bold text-gray-900 mt-2">
                        @if($pengajuanAktif)
                            <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                {{ $pengajuanAktif->status_pengajuan->nama_status ?? 'Draft' }}
                            </span>
                        @else
                            <span class="text-gray-500">Belum ada pengajuan</span>
                        @endif
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
                            @if($jenisPengajuan->count() > 0)
                                @foreach($jenisPengajuan as $jenis)
                                    <div class="border rounded-lg p-4 mb-4 hover:shadow-md transition">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $jenis->nama_pengajuan }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">{{ $jenis->keterangan }}</p>
                                                
                                                @if($jenis->syarat->count() > 0)
                                                    <div class="mt-3 text-sm text-gray-700">
                                                        <p class="font-medium mb-2">Dokumen yang diperlukan:</p>
                                                        <ul class="list-disc list-inside space-y-1 ml-2">
                                                            @foreach($jenis->syarat as $syarat)
                                                                <li>
                                                                    {{ $syarat->jenisDokumen->nama_dokumen ?? 'Dokumen' }}
                                                                    @if($syarat->is_wajib)
                                                                        <span class="text-red-600 font-bold">*</span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">Tidak ada jenis pengajuan yang tersedia</p>
                            @endif
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
                            @if(!$pengajuanAktif || $pengajuanAktif->id_status_pengajuan == 1)
                                <form action="{{ route('dokumen.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Dokumen</label>
                                        <select name="id_jenis_dokumen" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                            <option value="">-- Pilih Dokumen --</option>
                                            @foreach($jenisDokumen as $dok)
                                                <option value="{{ $dok->id }}">{{ $dok->nama_dokumen }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">File (PDF/JPG, Max 2MB)</label>
                                        <input type="file" name="file" accept=".pdf,.jpg,.jpeg" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                    </div>

                                    <input type="hidden" name="id_pengaju" value="{{ $pengaju->id }}">

                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition">
                                        Upload File
                                    </button>
                                </form>

                                @if($dokumenDiunggah->count() > 0)
                                    <div class="mt-5 border-t pt-4">
                                        <h4 class="text-sm font-semibold text-gray-800 mb-3">Dokumen yang sudah diunggah</h4>
                                        <div class="space-y-2">
                                            @foreach($dokumenDiunggah as $dok)
                                                <div class="flex items-center justify-between bg-gray-50 border rounded p-2">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-800">{{ $dok->jenisDokumen->nama_dokumen ?? 'Dokumen' }}</p>
                                                        <a class="text-xs text-blue-600 hover:underline" href="{{ asset('storage/' . $dok->path_file) }}" target="_blank">Lihat file</a>
                                                    </div>
                                                    <form method="POST" action="{{ route('dokumen.hapus', $dok->id) }}" onsubmit="return confirm('Hapus dokumen ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded">Hapus</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <p class="text-gray-500 text-sm">Upload dokumen ditutup karena pengajuan terakhir sudah dikirim.</p>
                            @endif
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
                    @if($pengajuanDraft)
                        <p class="text-sm text-amber-700 mb-4">Pastikan seluruh dokumen wajib sudah terunggah sebelum klik tombol kirim pengajuan.</p>
                        <form action="{{ route('pengajuan.submit') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="id_pengajuan" value="{{ $pengajuanDraft->id }}">

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Pengajuan</label>
                                <select name="id_jenis_pengajuan" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                    <option value="">-- Pilih Jenis Pengajuan --</option>
                                    @foreach($jenisPengajuan as $jenis)
                                        <option value="{{ $jenis->id }}">{{ $jenis->nama_pengajuan }}</option>
                                    @endforeach
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
                    @else
                        <p class="text-sm text-gray-600">Upload dokumen terlebih dahulu sebelum melakukan pengajuan.</p>
                    @endif
                </div>
            </div>

            <!-- Riwayat Pengajuan -->
            @if($pengajuanAktif)
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="font-semibold text-lg text-gray-900">
                            <i class="bi bi-clock-history me-2"></i>Riwayat Pengajuan
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($riwayat->count() > 0)
                            <div class="space-y-4">
                                @foreach($riwayat as $item)
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                                                <i class="bi bi-check-circle text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $item->status_pengajuan->nama_status ?? 'Unknown' }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->keterangan }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $item->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Belum ada riwayat pengajuan</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
