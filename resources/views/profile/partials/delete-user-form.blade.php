<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Jika Anda menghapus akun, seluruh data pengajuan Anda akan terhapus permanen.
        </p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
        @csrf
        @method('delete')

        <div>
            <x-input-label for="delete_password" value="Konfirmasi Password" />
            <x-text-input id="delete_password" name="password" type="password" class="mt-1 block w-full md:w-3/4" placeholder="Masukkan password Anda" required />
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <x-danger-button>
            Hapus Akun Saya
        </x-danger-button>
    </form>
</section>
