<?php

namespace Tests\Feature\Auth;

use App\Models\Pengaju;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated(): void
    {
        $user = Pengaju::create([
            'nik' => '747100000301',
            'nama_lengkap' => 'Password Updater 1',
            'nim' => 'E1E120301',
            'jurusan' => 'Teknik Informatika',
            'email' => 'pwd-updater1@example.com',
            'no_hp' => '081234567821',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this
            ->actingAs($user, 'pengaju')
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = Pengaju::create([
            'nik' => '747100000302',
            'nama_lengkap' => 'Password Updater 2',
            'nim' => 'E1E120302',
            'jurusan' => 'Teknik Informatika',
            'email' => 'pwd-updater2@example.com',
            'no_hp' => '081234567822',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this
            ->actingAs($user, 'pengaju')
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/profile');
    }
}
