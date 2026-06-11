<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengaju;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Pengaju::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Pengaju::create([
            'nama_lengkap' => $request->nama,
            'nik' => null,
            'nim' => 'REG-'.strtoupper((string) \Illuminate\Support\Str::random(10)),
            'jurusan' => 'Belum diisi',
            'email' => $request->email,
            'no_hp' => '0000000000',
            'alamat' => '-',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::guard('pengaju')->login($user);

        return redirect(route('dashboard'));
    }
}
