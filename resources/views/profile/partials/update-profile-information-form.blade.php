<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Profil Mahasiswa
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui data profil akun Anda agar informasi pengajuan tetap akurat.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nama_lengkap" value="Nama Lengkap" />
            <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" :value="old('nama_lengkap', $user->nama_lengkap)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('nama_lengkap')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="jurusan" value="Jurusan / Program Studi" />
            <x-text-input id="jurusan" name="jurusan" type="text" class="mt-1 block w-full" :value="old('jurusan', $user->jurusan)" required />
            <x-input-error class="mt-2" :messages="$errors->get('jurusan')" />
        </div>

        <div>
            <x-input-label for="no_hp" value="No. HP / WhatsApp" />
            <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $user->no_hp)" required />
            <x-input-error class="mt-2" :messages="(is_objecerrors) && method_exists($errors, 'get')) ? $errors->get('no_hp') : []" />
        </div>

        <div>
            <x-input-label for="alamat" value="Alamat" />
            <textarea id="alamat" name="alamat" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan Perubahan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >Perubahan disimpan.</p>
            @endif
        </div>
    </form>
</section>
